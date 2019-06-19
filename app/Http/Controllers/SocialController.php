<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social = Social::all();
        return view('coupon.admin.social.index', compact('social'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupon.admin.social.create');
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
            'title' => 'required',
            'icon' => 'required',
            'url' => 'required'
        ]);

        $input = $request->all();

        Social::create($input);

        flash('Social has been added')->success();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Social  $Social
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Social  $Social
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $social1 = Social::findOrFail($id);
        return view('coupon.admin.social.edit', compact('social1'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Social  $Social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'title' => 'required',
            'icon' => 'required',
            'url' => 'required'
        ]);

        $social = Social::findOrFail($id);

        $input = $request->all();

        $social->update($input);

        flash('Social has been updated')->info();

        return redirect('admin/social');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Social  $Social
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social = Social::findOrFail($id);

        $social->delete();

        flash('Social has been deleted')->error();

        return back();
    }
}
