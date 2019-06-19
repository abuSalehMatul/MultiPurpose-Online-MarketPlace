<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use App\FaqCategory;
use App\CouponCategory;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::all();
        return view('coupon.admin.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = FaqCategory::pluck('title', 'id')->all();
        return view('coupon.admin.faq.create', compact('categories'));
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
            'faq_category_id' => 'required',
            'question' => 'required|unique:faqs',
            'answer' => 'required'
        ]);

        $input = $request->all();

        Faq::create($input);

        return back()->with('added','Faq has been added');;
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categories = FaqCategory::pluck('title', 'id')->all();

        return view('coupon.admin.faq.edit', compact('faq', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'faq_category_id' => 'required',
            'question' => 'required',
            'answer' => 'required'
        ]);

        $faq = Faq::findOrFail($id);

        $input = $request->all();

        $faq->update($input);

        return redirect('admin/faq')->with('updated','Faq has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        
        $faq->delete();

        return back()->with('deleted','Faq has been deleted');;
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

        return back()->with('deleted', 'Faq has been deleted');   
    }
}
