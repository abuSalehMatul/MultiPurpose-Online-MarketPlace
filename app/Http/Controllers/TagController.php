<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tag = Tag::all();
        return view('coupon.admin.tag.index', compact('tag')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required|min:1|unique:tags'
        ]);

        $input = $request->all();

        $tag = Tag::create($input);
        $tag->slug = str_slug($input['title'],'-');
        $tag->save();

        return back()->with('added', 'Tag has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $tag = Tag::findOrFail($id);
      return view('coupon.admin.tag.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tagdtl = Tag::findOrFail($id);
        $tag = Tag::all();
        return view('coupon.admin.tag.index', compact('tagdtl','tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:1|unique:tags,id,'.$id
        ]);

        $tag = Tag::findOrFail($id);

        $input = $request->all();

        $tag->update($input);
        $tag->slug = str_slug($input['title'],'-');
        $tag->save();

        return redirect('admin/tag')->with('updated', 'Tag has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        return redirect('admin/tag')->with('deleted', 'Tag has been deleted');
    }
}

