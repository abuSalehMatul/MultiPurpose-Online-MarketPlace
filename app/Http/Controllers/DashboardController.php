<?php

namespace App\Http\Controllers;

use App\Model\LiveClass;
use App\Model\Subscriber;
use Illuminate\Http\Request;
use Auth;
use App\Model\GeneralSettings;
use App\User;
use App\Model\Mining;
use App\Model\PricingPlan;
use App\Model\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function live()
    {
        $data['page_title'] = 'Manage Live';
        $data['events'] = LiveClass::latest()->paginate(15);
        return view('admin.pages.live', $data);
    }
    public function UpdateLive(Request $request)
    {

        if ($request->id == 0) {
            $data['title'] = $request->title;
            $data['link'] = $request->link;
            $data['status'] = $request->status;
            $res = LiveClass::create($data);
            if ($res) {
                return back()->with('success', 'Saved Successfully!');
            } else {
                return back()->with('alert', 'Problem With Adding New Category');
            }

        } else {
            $mac = LiveClass::findOrFail($request->id);
            $mac['title'] = $request->title;
            $mac['link'] = $request->link;
            $mac['status'] = $request->status;
            $res = $mac->save();

            if ($res) {
                return back()->with('success', ' Updated Successfully!');
            } else {
                return back()->with('alert', 'Problem With Updating Category');
            }
        }
    }

    public function category()
    {
        $data['page_title'] = 'All Category';
        $data['events'] = Mining::latest()->paginate(15);
        return view('admin.pages.mining', $data);
    }

    public function searchCategory(Request $request)
    {
        $this->validate($request,
            [
                'search' => 'required',
            ]);

        $query = Mining::select('id','name',  'status', 'created_at', 'updated_at');
        $search = $request->input('search', null);
        $query = is_null($search) ? $query : $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('short_name', 'LIKE', '%' . $search . '%')
            ->orWhere('created_at', 'LIKE', '%' . $search . '%');

        $data['events'] = $query->latest()->get();
        $data['page_title'] = "Search Category";
        return view('admin.pages.search-mining', $data);
    }


    public function UpdateCategory(Request $request)
    {
        $macCount = Mining::where('name', $request->name)->where('id', '!=', $request->id)->count();
        if ($macCount > 0) {
            return back()->with('alert', 'This one Already Exist');
        }
        if ($request->id == 0) {
            $data['name'] = $request->name;
            $data['short_name'] = $request->short_name;
            $data['status'] = $request->status;
            $res = Mining::create($data);
            if ($res) {
                return back()->with('success', 'Saved Successfully!');
            } else {
                return back()->with('alert', 'Problem With Adding New Category');
            }

        } else {
            $mac = Mining::findOrFail($request->id);
            $mac['name'] = $request->name;
            $mac['short_name'] = $request->short_name;
            $mac['status'] = $request->status;
            $res = $mac->save();

            if ($res) {
                return back()->with('success', ' Updated Successfully!');
            } else {
                return back()->with('alert', 'Problem With Updating Category');
            }
        }
    }

    public function unit()
    {
        $data['page_title'] = 'Manage Subcategory';
        $data['category'] = Mining::whereStatus(1)->get();
        $data['events'] = Unit::paginate(15);
        return view('admin.pages.unit', $data);
    }
    public function searchSubCategory(Request $request)
    {
        $this->validate($request,['search' => 'required']);

        $query = Unit::select('id','title', 'category_id',  'status', 'created_at', 'updated_at');
        $search = $request->input('search', null);
        $query = is_null($search) ? $query : $query->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('created_at', 'LIKE', '%' . $search . '%')
            ->orWhereHas('category', function ($q) use ($search)
            {
                $q->where('name','LIKE','%'.$search.'%');
            });

        $data['events'] = $query->latest()->get();
        $data['page_title'] = "Search Sub-Category";
        $data['category'] = Mining::whereStatus(1)->get();
        return view('admin.pages.search-unit', $data);
    }




    public function UpdateUnit(Request $request)
    {
        if ($request->id == 0) {
            $data['title'] = $request->title;
            $data['category_id'] = $request->category_id;
            $data['status'] = $request->status;
            $res = Unit::create($data);
            if ($res) {
                return back()->with('success', 'Saved Successfully!');
            } else {
                return back()->with('alert', 'Problem With Adding New Unit');
            }

        } else {
            $mac = Unit::findOrFail($request->id);
            $mac['title'] = $request->title;
            $mac['category_id'] = $request->category_id;
            $mac['status'] = $request->status;
            $res = $mac->save();

            if ($res) {
                return back()->with('success', ' Updated Successfully!');
            } else {
                return back()->with('alert', 'Problem With Updating Unit');
            }
        }
    }


    public function createPlan()
    {
        $data['page_title'] = 'Add New Post';
        $data['category'] = Mining::whereStatus(1)->get();
        return view('admin.pages.create-plan', $data);
    }

    public function storePlan(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'video' => 'required',
        ],
            [
                'title.required' => 'Post Title Must not be empty',
                'category_id.required' => 'Category Must be selected',
                'video.required' => 'Embed video must not be empty'
            ]
        );

        $in = Input::except('_token');
        $in['status'] = $request->status == 'on' ? '1' : '0';
        $res = PricingPlan::create($in);

        if ($res) {
            return back()->with('success', 'Saved Successfully!');
        } else {
            return back()->with('alert', 'Problem With Adding New Post');
        }
    }

    public function plans()
    {
        $data['page_title'] = 'All Post';
        $data['plans'] = PricingPlan::latest()->paginate(10);
        return view('admin.pages.plans', $data);
    }

    public function searchPost(Request $request)
    {
        $this->validate($request,['search' => 'required']);

        $query = PricingPlan::select('id','title', 'category_id', 'subcategory_id', 'video', 'status', 'created_at', 'updated_at');
        $search = $request->input('search', null);
        $query = is_null($search) ? $query : $query->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('created_at', 'LIKE', '%' . $search . '%')
            ->orWhereHas('category', function ($q) use ($search)
            {
                $q->where('name','LIKE','%'.$search.'%');
            })
            ->orWhereHas('subcategory', function ($q) use ($search)
            {
                $q->where('title','LIKE','%'.$search.'%');
            });



        $data['plans'] = $query->latest()->get();
        $data['page_title'] = "Search Post";
        return view('admin.pages.search-plans', $data);
    }

    public function editPlan($id)
    {
        $data['page_title'] = 'Edit Post';
        $data['post'] = PricingPlan::find($id);
        $data['category'] = Mining::whereStatus(1)->get();
        return view('admin.pages.edit-plan', $data);
    }

    public function updatePlan(Request $request)
    {
        $data = PricingPlan::find($request->id);
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'video' => 'required',
        ],
            [
                'title.required' => 'Post Title Must not be empty',
                'category_id.required' => 'Category Must be selected',
                'video.required' => 'Embed video must not be empty'
            ]
        );


        $in = Input::except('_token');
        $in['status'] = $request->status == 'on' ? '1' : '0';
        if (!$request->subcategory_id) {
            $in['subcategory_id'] = 0;
        }
        $res = $data->fill($in)->save();

        if ($res) {
            return back()->with('success', 'Updated Successfully!');
        } else {
            return back()->with('alert', 'Problem With Updating Plan');
        }

        return $data;
    }

    public function manageSubscribers()
    {
        $data['page_title'] = 'Subscribers';
        $data['events'] = Subscriber::latest()->paginate(30);
        return view('admin.pages.subscriber', $data);
    }

    public function updateSubscriber(Request $request)
    {
        $mac = Subscriber::findOrFail($request->id);
        $mac['status'] = $request->status;
        $res = $mac->save();

        if ($res) {
            return back()->with('success', ' Updated Successfully!');
        } else {
            return back()->with('alert', 'Problem With Updating Category');
        }
    }

    public function sendMail()
    {
        $data['page_title'] = 'Mail to Subscribers';
        return view('admin.pages.subscriber-email', $data);
    }

    public function sendMailsubscriber(Request $request)
    {
        $this->validate($request,
            [
                'subject' => 'required',
                'emailMessage' => 'required'
            ]);
        $subscriber = Subscriber::whereStatus(1)->get();
        foreach ($subscriber as $data) {
            $to = $data->email;
            $name = substr($data->email, 0, strpos($data->email, "@"));
            $subject = $request->subject;
            $message = $request->emailMessage;
            send_email($to, $name, $subject, $message);
        }
        $notification = array('message' => 'Mail Sent Successfully!', 'alert-type' => 'success');
        return back()->with($notification);
    }


}
