<?php

namespace App\Http\Controllers;

use App\Chore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Image; 
use App\Chore_category;
use App\Wishlist;
use App\Chore_proposal;
use Session;
use Auth;
use App\User;
use Yajra\Datatables\Datatables;

use CyrildeWit\EloquentViewable\Viewable;


class ChoreController extends Controller
{
   
    public function index()
    {

        return view('chore.mainmaster')->with('flag','chorepage');
    }

    public function create()
    {
        // if (Auth::guard('admin')->check()) {
        //     $email = Auth::guard('admin')->email;
        //     $user = User::where('email', $email)->first();
        //     Auth::guard('admin')->logout();
        //     Auth::login($user);
        // }
       return view('chore.add');
    }

    
    public function store(Request $request)
    {
       $this->validate($request,[
            'name'=>'required',
            'price'=>'required',
            'description' =>'required',
            'category'=>'required'
       ]);
       $chore = new Chore;
       $chore->name=$request->name;
       $chore->description=$request->description;
       $chore->creator=Auth::user()->id;
       $chore->precidance=$request->precidance;
       $chore->price=$request->price;
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
        if($request->category_id=='other'){
            $chore->category_id=1;
        }else{
            $chore->category_id = $request->category;
        }
       
        $chore->image_id=$image->id;
       $chore->save();
       return Redirect::to('chores/view');
    }
    public function proposal(Request $request,$id){
        $this->validate($request,[
            'price'=>'required',
        ]);
        $proposal= new Chore_proposal;
        $proposal->chore_id=$id;
        $proposal->user_id=Auth::user()->id;
        $proposal->price=$request->price;
        $proposal->save();
        Session::flash('message','Your Proposal has been sent');
        return redirect()->back();

    }
    public function show( $chore)
    {
        $chore=Chore::find($chore);
       // return $chore;
        $chore->view++;
        $minutes=30;
        views($chore)
             ->delayInSession($minutes)
            ->record();
        $category=Chore::find($chore->id)->category;
        $view=views($chore)->count();
        $creator=Chore::find($chore->id)->user;
        // print_r($creator);
        // exit();
        return view('chore.choreDetails')
                    ->with('chore',$chore)
                    ->with('view',$view)
                    ->with('cat',$category)
                    ->with('creator',$creator);
    }

    public function edit(chore $chore)
    {
        //
    }

    public function wishlist(Request $request){
        if($request->data=='add'){
            $wish=new Wishlist;
            $wish->user_id=Auth::user()->id;
            $wish->ChoSer_id=$request->ChoSer_id;
            $wish->type=$request->type;
            $wish->save();
            return 'success';
        }else{
           $u=Auth::user()->id;
           $wish=Wishlist::where('ChoSer_id',$request->ChoSer_id)->where('type',$request->type)->where('user_id',$u)->delete();
           
           return 'remSuccess';

        }
    }
    public function my_active_task()
    {
       
        return view('chore.admin.my_active_task');
    }
    public function proposal_received()
    {
    //    $id=Auth::user()->id;
    //     $chore = chore::where('creator', $id)->get();
    //     return $chore;
        return view('chore.admin.proposal_received');
    }
    public function my_proposals()
    {
        
        return view('chore.admin.my_task_proposal');
    }
    public function task_i_get_pay()
    {
        return view('chore.admin.i_got_pay');
    }
    public function task_i_pay()
    {
        return view('chore.admin.i_have_to_pay');
    }
    public function admin(){
        if (Auth::guard('admin')->check()) {
            $email = Auth::guard('admin')->email;
            $user = User::where('email', $email)->first();
            Auth::guard('admin')->logout();
            Auth::login($user);
        }
        return view('chore.admin.myaccount');
    }
    public function accept($id){
        $proposal= Chore_proposal::find($id);
        $chore=chore::find($proposal->chore_id);
        $proposal->status=1;
        $chore->gifted=$proposal->user_id;
        $proposal->save();
        $chore->save();
        Session::flash('message','Proposal Accepted');
        return redirect()->back();
    }
    public function denied($id)
    {
        $proposal = Chore_proposal::find($id);
        $chore = Chore::find($proposal->chore_id);
        $proposal->status = 2;
        $proposal->save();
        Session::flash('message', 'Proposal Denied');
        return redirect()->back();
    }
    public function destroy(chore $chore)
    {
        //
    }
    public function mywishlist(){
        return view('chore.admin.mywishlist');
    }
    public function panel(){
        return view('backend.chore.admin_inbox');
    }
    public function panel_ajax(){
       
        $query = DB::table('chore_proposals')->orderBy('created_at', 'desc')
            ->get();
        return Datatables::queryBuilder($query)->make(true)
            ->setRowId('id')
            ->editColumn('user_id', function ($val) {
                // return 'Hi ' . $user->name . '!';
                $user=User::find($val->user_id);
                return $user->first_name;
            })
            ->editColumn('chore_id', function ( $v) {
                // return 'Hi ' . $user->name . '!';
                $chore=Chore::find($v->chore_id);
                return $chore->name;
            })
            ->editColumn('status', function ($val) {
                // return 'Hi ' . $user->name . '!';
                if($val->status==0){
                    return 'Not Accepted';
                }elseif ($val->status==1) {
                   return 'Accepted';
                }else{
                    return 'Denied';
                }
            })
            ->make(true);;
       
         
    }
}
