<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Image;
use App\Chore_category;
use App\Wishlist;
use App\Chore_proposal;
use Session;
use Auth;
use App\User;
use App\chore;

class ServicesController extends Controller
{
   public function index(){
        return view('chore.service.add');
   }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category' => 'required',
            'delivery_day' => 'required'
        ]);
        $chore = new Chore;
        $chore->name = $request->name;
        $chore->description = $request->description;
        $chore->creator = Auth::user()->id;
        $chore->precidance = $request->precidance;
        $chore->price = $request->price;
        $chore->delivery_day=$request->delivey_day;
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $filename = time() . '.' . $image->getClientOriginalExtension();

            $location = public_path('/uploads/image/');

            // Image::make($image)->save($location);
            $image->move($location, $filename);
            //    return 'hi';
            // $product->image = $filename;
            $image = new Image;

            $image->image = $filename;
            $image->save();
        }
        if ($request->category_id == -10) {
            $chore->category_id = 1;
        } else {
            $chore->category_id = $request->category;
        }

        $chore->image_id = $image->id;
        $chore->type=2;
        $chore->save();
        return Redirect::to('chores/view');
    }
    public function show($chore)
    {
        $chore = chore::find($chore);
        $chore->view++;
        return view('chore.service.serviceDetails')->with('chore', $chore);
    }
    public function proposal(Request $request, $id)
    {
        $this->validate($request, [
            'price' => 'required',
        ]);
        $proposal = new Chore_proposal;
        $proposal->chore_id = $id;
        $proposal->user_id = Auth::user()->id;
        $proposal->price = $request->price;
        $proposal->save();
        Session::flash('message', 'Your Proposal has been sent');
        return redirect()->back();
    }
    public function sold_service(){
        return view( 'chore.service.sold_service');
    }
    public function proposal_received(){
        return view( 'chore.service.proposal_received');
    }
    public function accept($id)
    {
        $proposal = Chore_proposal::find($id);
        $chore = chore::find($proposal->chore_id);
        $proposal->status = 1;
       // $chore->gifted = $proposal->user_id;
        $proposal->save();
        // $chore->save();
        Session::flash('message', 'Proposal Accepted');
        return redirect()->back();
    }
    public function denied($id)
    {
        $proposal = Chore_proposal::find($id);
        $chore = chore::find($proposal->chore_id);
        $proposal->status = 2;
        $proposal->save();
        Session::flash('message', 'Proposal Denied');
        return redirect()->back();
    }
    public function my_service(){
        return view( 'chore.service.my_service');
    }
    public function my_active_service(){
        return view('chore.service.my_active_service');
    }
}
