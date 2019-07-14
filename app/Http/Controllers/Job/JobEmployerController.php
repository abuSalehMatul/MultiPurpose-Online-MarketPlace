<?php
/**
 * Class EmployerController.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers\Job;

use Illuminate\Http\Request;
use App\JobModel\JobHelper;
use App\JobModel\JobDepartment;
use App\JobModel\JobLocation;
use App\JobModel\JobProfile;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\User;
use Session;
use App\Language;
use App\JobModel\JobCategory;
use App\JobModel\JobSkill;
use App\JobModel\JobJob;
use App\JobModel\JobProposal;
use DB;
use App\JobModel\JobPackage;
use App\EmailTemplate;
use App\Mail\FreelancerEmailMailable;
use App\Invoice;
use App\JobModel\JobItem;
use Carbon\Carbon;
use App\Message;
use App\JobModel\JobSiteManagement;

/**
 * Class EmployerController
 */
class JobEmployerController extends Controller
{

    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $employer
     */
    protected $employer;

    /**
     * Create a new controller instance.
     *
     * @param instance $employer instance
     *
     * @return void
     */
    public function __construct(JobProfile $employer)
    {
        $this->employer = $employer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = $this->employer::where('user_id', Auth::user()->id)
            ->get()->first();
        $employees = JobHelper::getEmployeesList();
        $departments = JobDepartment::all();
        $locations = JobLocation::pluck('title', 'id');
        $gender = !empty($profile->gender) ? $profile->gender : '';
        $tagline = !empty($profile->tagline) ? $profile->tagline : '';
        $description = !empty($profile->description) ? $profile->description : '';
        $banner = !empty($profile->banner) ? $profile->banner : '';
        $avater = !empty($profile->avater) ? $profile->avater : '';
        $address = !empty($profile->address) ? $profile->address : '';
        $longitude = !empty($profile->longitude) ? $profile->longitude : '';
        $latitude = !empty($profile->latitude) ? $profile->latitude : '';
        $no_of_employees = !empty($profile->no_of_employees) ? $profile->no_of_employees : '';
        $department_id = !empty($profile->department_id) ? $profile->department_id : '';
        $packages = DB::table('job_items')->where('subscriber', Auth::user()->id)->count();
        $package_options = JobPackage::select('options')->where('role_id', Auth::user()->id)->first();
        $options = !empty($package_options) ? unserialize($package_options['options']) : array();
        return view(
            'job.back-end.employer.profile-settings.personal-detail.index',
            compact(
                'employees',
                'departments',
                'locations',
                'gender',
                'tagline',
                'description',
                'banner',
                'avater',
                'address',
                'longitude',
                'latitude',
                'no_of_employees',
                'department_id',
                'options',
                'packages'
            )
        );
    }


    /**
     * Upload Image to temporary folder.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempImage(Request $request)
    {
        $path = JobHelper::PublicPath() . '/uploads/users/temp/';
        if (!empty($request['hidden_avater_image'])) {
            $profile_image = $request['hidden_avater_image'];
            return JobHelper::uploadTempImage($path, $profile_image);
        } elseif (!empty($request['hidden_banner_image'])) {
            $image_size = array(
                'small' => array(
                    'width' => 350,
                    'height' => 172,
                ),
                'medium' => array(
                    'width' => 1140,
                    'height' => 400,
                ),
            );
            $profile_image = $request['hidden_banner_image'];
            return JobHelper::uploadTempImageWithSize($path, $profile_image, '', $image_size);
        }
    }

    /**
     * Store profile settings.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function storeProfileSettings(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $json = array();
        $this->validate(
            $request, [
                'first_name'    => 'required',
                'last_name'    => 'required',
            ]
        );
        if (!empty($request)) {
            $user_id = Auth::user()->id;
            $this->employer->storeProfile($request, $user_id);
            $json['type'] = 'success';
            $json['process'] = trans('lang.saving_profile');
            return $json;
        }
    }

    /**
     * Show Employer Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function employerDashboard()
    {
        $ongoing_jobs = array();
        $employer_id = Auth::user()->id;
        $package_item = JobItem::where('subscriber', $employer_id)->first();
        $package = !empty($package_item) ? JobPackage::find($package_item->product_id) : array();
        $option = !empty($package) && !empty($package['options']) ? unserialize($package['options']) : '';
        $expiry = !empty($option) && !empty($package_item) ? $package_item->created_at->addDays($option['duration']) : '';
        $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
        $message_status = Message::where('status', 0)->where('receiver_id', $employer_id)->count();
        $notify_class = $message_status > 0 ? 'wt-insightnoticon' : '';
        $currency   = JobSiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? JobHelper::currencyList($currency[0]['currency']) : array();
        $icons  = JobSiteManagement::getMetaValue('icons');
        $latest_proposals_icon = !empty($icons['hidden_latest_proposal']) ? $icons['hidden_latest_proposal'] : 'img-20.png';
        $latest_package_expiry_icon = !empty($icons['hidden_package_expiry']) ? $icons['hidden_package_expiry'] : 'img-21.png';
        $latest_new_message_icon = !empty($icons['hidden_new_message']) ? $icons['hidden_new_message'] : 'img-19.png';
        $latest_saved_item_icon = !empty($icons['hidden_saved_item']) ? $icons['hidden_saved_item'] : 'img-22.png';
        $latest_cancel_job_icon = !empty($icons['hidden_cancel_job']) ? $icons['hidden_cancel_job'] : 'img-16.png';
        $latest_ongoing_job_icon = !empty($icons['hidden_ongoing_job']) ? $icons['hidden_ongoing_job'] : 'img-17.png';
        $latest_completed_job_icon = !empty($icons['hidden_completed_job']) ? $icons['hidden_completed_job'] : 'img-18.png';
        $latest_posted_job_icon = !empty($icons['hidden_posted_job']) ? $icons['hidden_posted_job'] : 'img-15.png';
        if (Auth::user()) {
            $ongoing_jobs = Auth::user()->jobs->where('status', 'hired')->take(8);
            return view(
                'job.back-end.employer.dashboard',
                compact(
                    'ongoing_jobs',
                    'expiry_date',
                    'notify_class',
                    'symbol',
                    'latest_proposals_icon',
                    'latest_package_expiry_icon',
                    'latest_new_message_icon',
                    'latest_saved_item_icon',
                    'latest_cancel_job_icon',
                    'latest_ongoing_job_icon',
                    'latest_completed_job_icon',
                    'latest_posted_job_icon'
                )
            );
        }
    }

    /**
     * Show Employer Jobs.
     *
     * @param string $status job status
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmployerJobs($status)
    {
        $ongoing_jobs = array();
        $employer_id = Auth::user()->id;
        if (Auth::user()) {
            $ongoing_jobs = JobJob::where('user_id', $employer_id)->latest()->where('status', 'hired')->paginate(7);
            $completed_jobs = JobJob::where('user_id', $employer_id)->latest()->where('status', 'completed')->paginate(7);
            $cancelled_jobs = JobJob::where('user_id', $employer_id)->latest()->where('status', 'cancelled')->paginate(7);
            $currency   = JobSiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? JobHelper::currencyList($currency[0]['currency']) : array();
            if (!empty($status) && $status === 'hired') {
                return view(
                    'job.back-end.employer.jobs.ongoing',
                    compact(
                        'ongoing_jobs', 'symbol'
                    )
                );
            } elseif (!empty($status) && $status === 'completed') {
                return view(
                    'job.back-end.employer.jobs.completed',
                    compact(
                        'completed_jobs', 'symbol'
                    )
                );
            }
        }
    }

    /**
     * Employer Payment Process.
     *
     * @param string $id proposal ID
     *
     * @return \Illuminate\Http\Response
     */
    public function employerPaymentProcess($id)
    {
        if (Auth::user() && !empty($id)) {
            if (Auth::user()) {
                $user_id = Auth::user()->id;
                $employer = User::find($user_id);
                $proposal = JobProposal::where('id', $id)->get()->first();
                $job = $proposal->job;
                $freelancer = User::find($proposal->freelancer_id);
                $freelancer_name = JobHelper::getUserName($proposal->freelancer_id);
                $profile = User::find($proposal->freelancer_id)->profile;
                $attachments = !empty($proposal->attachments) ? unserialize($proposal->attachments) : '';
                $user_image = !empty($profile) ? $profile->avater : '';
                $profile_image = !empty($user_image) ? '/uploads/users/' . $proposal->freelancer_id . '/' . $user_image : 'images/user-login.png';
                $payout_settings = JobSiteManagement::getMetaValue('commision');
                $payment_gateway = !empty($payout_settings) && !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : null;
                $currency   = JobSiteManagement::getMetaValue('commision');
                $symbol = !empty($currency) && !empty($currency[0]['currency']) ? JobHelper::currencyList($currency[0]['currency']) : array();
                return view(
                    'job.back-end.employer.jobs.checkout',
                    compact(
                        'job',
                        'freelancer_name',
                        'profile_image',
                        'proposal',
                        'payment_gateway',
                        'proposal',
                        'symbol'
                    )
                );
            }
        } else {
            abort(404);
        }
    }
}
