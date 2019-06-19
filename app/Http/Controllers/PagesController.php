<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CouponPages;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = CouponPages::all();
        return view('coupon.admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupon.admin.pages.create');
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
            'title' => 'required|unique:pages',
            'body' => 'required'
        ]);

        $input = $request->all();

        $slug = str_slug($input['title']);

        $data = CouponPages::create($input);

        $data->slug = $slug;

        $data->save();

        return back()->with('added','Page has been added');;
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
        $pages = CouponPages::findOrFail($id);
        return view('coupon.admin.pages.edit', compact('pages'));
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
            'title' => 'required|unique:pages,title,'.$id,
            'body' => 'required'
        ]);

        $pages = CouponPages::findOrFail($id);

        $input = $request->all();        

        $slug = str_slug($input['title']);

        $pages->update($input);

        $pages->slug = $slug;

        $pages->save();

        return redirect('admin/pages')->with('updated','Page has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pages = CouponPages::findOrFail($id);
        
        $pages->delete();

        return back()->with('deleted','Page has been deleted');;
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

        return back()->with('deleted', 'Page has been deleted');   
    }
}
