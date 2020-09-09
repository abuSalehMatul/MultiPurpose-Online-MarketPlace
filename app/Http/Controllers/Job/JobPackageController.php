<?php
/**
 * Class PackageController.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @version <PHP: 1.0.0>
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers\Job;

use App\JobModel\JobPackage;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use function Opis\Closure\serialize;
use Session;
use Spatie\Permission\Models\Role;
use App\JobModel\JobHelper;
use Auth;
use DB;
use App\JobModel\JobJob;
use App\JobModel\JobProposal;
use App\Badge;
use App\JobModel\JobSiteManagement;
use Illuminate\Support\Facades\Input;


/**
 * Class PackageController
 *
 */
class JobPackageController extends Controller
{

    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $package
     */
    protected $package;

    /**
     * Create a new controller instance.
     *
     * @param instance $package instance
     *
     * @return void
     */
    public function __construct(JobPackage $package)
    {
        $this->package = $package;
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $role_type role type
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role_type)
    {
        if (Auth::user() && Auth::user()->getRoleNames()[0] != "admin") {
            $role = Role::where('role_type', $role_type)->first();
            $package_options = JobHelper::getPackageOptions($role_type);
            $packages = $this->package::all()->where('role_id', $role->id)->where('trial', 0);
            $purchase_packages = DB::table('job_items')->select('product_id')->where('subscriber', Auth::user()->id)->get()->pluck('product_id')->toArray();
            $currency   = JobSiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? JobHelper::currencyList($currency[0]['currency']) : array();
            return View::make('job.back-end.package.index', compact('packages', 'package_options', 'purchase_packages', 'symbol'));
            if (Auth::user()->getRoleNames()[0] != $role_type) {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $packages = $this->package::where('title', 'like', '%' . $keyword . '%')->orderBy('role_id', 'desc')->paginate(10)->setPath('');
            $pagination = $packages->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $packages = $this->package::orderBy('role_id', 'desc')->paginate(10);
        }
        $employer_trial = $this->package::select('trial')->where('role_id', 2)->where('trial', 1)->get();
        $freelancer_trial = $this->package::select('trial')->where('role_id', 3)->where('trial', 1)->get();
        $roles = Role::where('name', '!=', 'admin')->get();
        $durations = JobHelper::getPackageDurationList();
        $badges = Badge::select('id', 'title')->get()->pluck('title', 'id');
        $delete_title = trans("lang.ph_delete_confirm_title");
        $delete_message = trans("lang.ph_package_delete_message");
        $deleted = trans("lang.ph_delete_title");
        return view(
            'job.back-end.admin.packages.index',
            compact(
                'packages',
                'delete_title',
                'delete_message',
                'deleted',
                'durations',
                'roles',
                'badges',
                'employer_trial',
                'freelancer_trial'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $request \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $server_verification = JobHelper::worketicIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request,
            [
                'package_title' => 'required',
                'package_subtitle' => 'required',
                'package_price' => 'required',
            ]
        );
        $this->package->savePackage($request);
        Session::flash('message', trans('lang.save_package'));
        return Redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug package slug
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if (!empty($slug)) {
            $package = $this->package::where('slug', $slug)->first();
            $options = unserialize($package->options);
            $roles = Role::where('name', '!=', 'admin')->pluck('name', 'id')->toArray();
            $durations = \App\JobModel\JobHelper::getPackageDurationList();
            $badges = Badge::select('id', 'title')->get()->pluck('title', 'id');
            $employer_trial = $this->package::select('trial')->where('role_id', 2)->where('trial', 1)->get();
            $freelancer_trial = $this->package::select('trial')->where('role_id', 3)->where('trial', 1)->get();
            $package_duration = unserialize($package['options'])['duration'];
            if (!empty($package)) {
                return View::make(
                    'job.back-end.admin.packages.edit',
                    compact(
                        'package',
                        'options',
                        'durations',
                        'roles',
                        'badges',
                        'employer_trial',
                        'freelancer_trial',
                        'package_duration'
                    )
                );
            }
        }
    }

    /**
     * Update departments.
     *
     * @param string $request string
     * @param string $slug    integer
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $server_verification = JobHelper::worketicIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request,
            [
                'package_title' => 'required',
            ]
        );
        $this->package->updatePackage($request, $slug);
        Session::flash('message', trans('lang.package_updated'));
        return Redirect::to('Job/admin/packages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $package $request $req->attribute
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        $json = array();
        $id = $request['id'];
        if (!empty($id)) {
            $this->package::where('id', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.package_deleted');
            return $json;
        }
    }

    /**
     * Get package options.
     *
     * @param integer $request $request->attributes
     *
     * @return settings
     */
    public function getPackageOptions(Request $request)
    {
        $json = array();
        if ($request['slug']) {
            $package = $this->package::where('slug', $request['slug'])->first();
            $options = unserialize($package->options);
            if (!empty($options)) {
                $json['type'] = 'success';
                if ($options['banner_option'] == 'true') {
                    $json['banner_option'] = 'true';
                }
                if ($options['private_chat'] == 'true') {
                    $json['private_chat'] = 'true';
                }
            } else {
                $json['type'] = 'error';
            }
            return $json;
        }
    }

    /**
     * Get user purchase package.
     *
     * @return settings
     */
    public function getPurchasePackage()
    {
        $json = array();
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type'] = 'server_error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        if (Auth::user()) {
            $purchase_packages = DB::table('pro_items')
                ->join('packages', 'packages.id', '=', 'pro_items.product_id')
                ->where('packages.trial', 0)
                ->where('subscriber', Auth::user()->id)->get();
            if ($purchase_packages->count() == 0) {
                $json['type'] = 'success';
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.cannot_purchase_more_then_one_pkg');
            }
            return $json;
        } else {
            abort(404);
        }
    }
}