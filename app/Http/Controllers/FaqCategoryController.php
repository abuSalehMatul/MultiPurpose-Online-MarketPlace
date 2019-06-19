<?php

namespace App\Http\Controllers;

use App\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $faqcategory = FaqCategory::all();
        return view('coupon.admin.faqcategory.index', compact('faqcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupon.admin.faqcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|unique:faq_categories'
        ]);

        $input = $request->all();

        if (isset($input['is_active']) && $input['is_active'] == '1')
        {
          $input['is_active'] = 1;
        }
        else{
            $input['is_active'] = 0;
        }

        $slug = str_slug($input['title'],'-');

        $data = FaqCategory::create($input);

        $data->slug = $slug;

        $data->save();

        return back()->with('added', 'Category has been added');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\FaqCategory  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FaqCategory  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faqcategory = FaqCategory::findOrFail($id);
        return view('coupon.admin.faqcategory.edit', compact('faqcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FaqCategory  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3|unique:faq_categories,title,'.$id
        ]);
        
        $faqcategory = FaqCategory::findOrFail($id);

        $input = $request->all();

        if (isset($input['is_active']) && $input['is_active'] == 'on')
        {
          $input['is_active'] = 1;
        }
        else{
            $input['is_active'] = 0;
        }

        $faqcategory->update($input);

        $slug = str_slug($input['title'],'-');

        $faqcategory->slug = $slug;

        $faqcategory->save();

        return redirect('admin/faqcategory')->with('updated', 'Category has been updated');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FaqCategory  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faqcategory = FaqCategory::findOrFail($id);

        $faqcategory->delete();

        return back()->with('deleted', 'Category has been deleted');
    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('deleted', 'Please select one of them to delete');
        }

        foreach ($request->checked as $checked) {

            $this->destroy($checked);
            
        }

        return back()->with('deleted', 'FaqCategory has been deleted');   
    }
}

