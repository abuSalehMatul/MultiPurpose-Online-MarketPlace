<?php
/**
 * Class RestAPIController
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
use App\User;
use App\JobModel\JobHelper;
use App\JobModel\JobProfile;
use Carbon\Carbon;
use App\JobModel\JobItem;
use App\JobModel\JobPackage;
use App\Review;
use App\JobModel\JobJob;
use Response;
use DB;
use App\Badge;
use App\JobModel\JobSkill;
use App\Language;
use Auth;
use File;
use Storage;
use App\JobModel\JobProposal;
use App\JobModel\JobSiteManagement;
use App\JobModel\JobLocation;
use App\EmailTemplate;
use App\JobModel\JobCategory;
use App\JobModel\JobDepartment;
use App\Mail\AdminEmailMailable;
use App\Mail\EmailVerificationMailable;
use App\Mail\EmployerEmailMailable;
use App\Mail\FreelancerEmailMailable;
use App\Mail\GeneralEmailMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use App\JobModel\JobReport;
use Intervention\Image\Facades\Image;
use App\Payout;

/**
 * Class RestAPIController
 *
 */
class JobRestAPIController extends Controller
{

    /**
     * Get freelancers API
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancer()
    {
        $json = array();
        $currency   = JobSiteManagement::getMetaValue('commision');
        $curr_symbol = !empty($currency) && !empty($currency[0]['currency']) ? JobHelper::currencyList($currency[0]['currency']) : array();
        $symbol = !empty($curr_symbol) ? $curr_symbol['symbol'] : '$';
        $profile_id = !empty($_GET['profile_id']) ? $_GET['profile_id'] : '';
        $login_user = !empty($profile_id) ? User::find($profile_id) : new User();
        $type = !empty($_GET['listing_type']) ? $_GET['listing_type'] : '';
        $post_per_page = !empty($_GET['show_users']) ? $_GET['show_users'] : 10;
        $page_number = !empty($_GET['page_number']) ? $_GET['page_number'] : 1;
        Paginator::currentPageResolver(
            function () use ($page_number) {
                return $page_number;
            }
        );
        if (!empty($login_user) && !empty($type)) {
            $user_by_role =  User::role('freelancer')->select('id')
                ->get()->pluck('id')->toArray();
            $users = User::whereIn('id', $user_by_role);
            if ($type === 'featured') {
                $subscribers =  DB::table('job_packages')
                    ->join('job_items', 'job_items.product_id', '=', 'packages.id')
                    ->join('invoices', 'invoices.id', '=', 'job_items.invoice_id')
                    ->select('job_items.subscriber')
                    ->where('invoices.type', '!=', 'project')
                    ->where('job_packages.badge_id', '!=', 0)
                    ->pluck('job_items.subscriber')->toArray();
                if (!empty($subscribers)) {
                    $users =  $users->whereIn('id', $subscribers)->orderBy('updated_at', 'desc')
                        ->paginate($post_per_page);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_freelancers_list');
                    return Response::json($json, 203);
                }
            } elseif ($type === 'latest') {
                if (!empty($users)) {
                    $users = $users->latest()->paginate($post_per_page);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_freelancers_list');
                    return Response::json($json, 203);
                }
            } elseif ($type === 'favorite') {
                $save_freelancer = !empty($login_user->profile->saved_freelancer) ?
                    unserialize($login_user->profile->saved_freelancer) : array();
                if (!empty($save_freelancer)) {
                    $users =  $users->whereIn('id', $save_freelancer)->orderBy('updated_at', 'desc')
                        ->paginate($post_per_page);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_freelancers_list');
                    return Response::json($json, 203);
                }
            } elseif ($type === 'search') {
                $user_id = array();
                $keyword = !empty($_GET['keyword']) ? $_GET['keyword'] : '';
                $search_locations = !empty($_GET['location']) ? $_GET['location'] : array();
                $search_skills = !empty($_GET['skills']) ? $_GET['skills'] : array();
                $search_hourly_rates = !empty($_GET['hourly_rate']) ? $_GET['hourly_rate'] : array();
                $search_freelaner_types = !empty($_GET['freelaner_type']) ? $_GET['freelaner_type'] : array();
                $search_english_levels = !empty($_GET['english_level']) ? $_GET['english_level'] : array();
                $search_languages = !empty($_GET['language']) ? $_GET['language'] : array();
                $filters = array();
                $filters['type'] = $type;
                if (!empty($keyword)) {
                    $filters['s'] = $keyword;
                    $users->where('first_name', 'like', '%' . $keyword . '%');
                    $users->orWhere('last_name', 'like', '%' . $keyword . '%');
                    $users->orWhere('slug', 'like', '%' . $keyword . '%');
                    $users->whereIn('id', $user_by_role);
                }
                if (!empty($search_locations)) {
                    $filters['locations'] = $search_locations;
                    $locations = JobLocation::select('id')->whereIn('slug', $search_locations)
                        ->get()->pluck('id')->toArray();
                    $users->whereIn('location_id', $locations);
                }
                if (!empty($search_skills)) {
                    $filters['skills'] = $search_skills;
                    $skills =JobSkill::whereIn('slug', $search_skills)->get();
                    foreach ($skills as $key => $skill) {
                        if (!empty($skill->freelancers[$key]->id)) {
                            $user_id[] = $skill->freelancers[$key]->id;
                        }
                    }
                    $users->whereIn('id', $user_id);
                }
                if (!empty($search_hourly_rates)) {
                    $filters['hourly_rate'] = $search_hourly_rates;
                    $min = '';
                    $max = '';
                    foreach ($search_hourly_rates as $search_hourly_rate) {
                        $hourly_rates = explode("-", $search_hourly_rate);
                        $min = $hourly_rates[0];
                        if (!empty($hourly_rates[1])) {
                            $max = $hourly_rates[1];
                        }
                        $user_id = JobProfile::select('user_id')->whereIn('user_id', $user_by_role)
                            ->whereBetween('hourly_rate', [$min, $max])->get()->pluck('user_id')->toArray();
                    }
                    $users->whereIn('id', $user_id);
                }
                if (!empty($search_freelaner_types)) {
                    $filters['freelaner_type'] = $search_freelaner_types;
                    $freelancers = JobProfile::whereIn('freelancer_type', $search_freelaner_types)->get();
                    foreach ($freelancers as $key => $freelancer) {
                        if (!empty($freelancer->user_id)) {
                            $user_id[] = $freelancer->user_id;
                        }
                    }
                    $users->whereIn('id', $user_id)->get();
                }
                if (!empty($search_english_levels)) {
                    $filters['english_level'] = $search_english_levels;
                    $freelancers = JobProfile::whereIn('english_level', $search_english_levels)->get();
                    foreach ($freelancers as $key => $freelancer) {
                        if (!empty($freelancer->user_id)) {
                            $user_id[] = $freelancer->user_id;
                        }
                    }
                    $users->whereIn('id', $user_id)->get();
                }
                if (!empty($search_languages)) {
                    $filters['languages'] = $search_languages;
                    $languages = Language::whereIn('slug', $search_languages)->get();
                    foreach ($languages as $key => $language) {
                        if (!empty($language->users[$key]->id)) {
                            $user_id[] = $language->users[$key]->id;
                        }
                    }
                    $users->whereIn('id', $user_id);
                }
                $users = $users->orderBy('updated_at', 'desc')->paginate($post_per_page);
            } else {
                $json['type']        = 'error';
                $json['message']    = trans('lang.no_listing_type');
                return Response::json($json, 203);
            }
            if (!empty($users) && $users->count() > 0) {
                foreach ($users as $key => $user) {
                    $user_object = User::find($user['id']);
                    $save_freelancer = !empty($login_user->profile->saved_freelancer) ?
                        unserialize($login_user->profile->saved_freelancer) : array();
                    $amount = Payout::where('user_id', $user_object->id)->select('amount')->pluck('amout')->first();
                    $json[$key]['favorit'] = in_array($user['id'], $save_freelancer) ? 'yes' : '';
                    $json[$key]['name'] = JobHelper::getUserName($user['id']);
                    $json[$key]['freelancer_link'] = url('profile/' . $user_object->slug);
                    $json[$key]['total_earnings'] = !empty($user_obj) ? $amount : '';
                    $json[$key]['user_id'] = "" . $user['id'] . "";
                    $json[$key]['profile_id'] = $user_object->profile->id;
                    $json[$key]['content'] = !empty($user_object->profile->description) ? $user_object->profile->description : '';
                    $json[$key]['member_since'] = "" . Carbon::parse($user['created_at'])->format('M d Y') . "";
                    $json[$key]['profile_img'] = url(JobHelper::getProfileImage($user['id']));
                    $json[$key]['banner_img'] = url(JobHelper::getProfileBanner($user['id']));
                    $badge = JobHelper::getUserBadge($user['id']);
                    $json[$key]['badge']['badget_url'] = !empty($badge->image) ? url('/uploads/badges/' . $badge->image) : '';
                    $json[$key]['badge']['badget_color'] = !empty($badge->color) ? $badge->color : '';
                    $reviews = Review::where('receiver_id', $user['id'])->get();
                    $rating  = $reviews->sum('avg_rating') != 0 ? round($reviews->sum('avg_rating') / $reviews->count()) : 0;
                    $json[$key]['wt_average_rating'] = $rating;
                    $json[$key]['wt_total_rating'] = $reviews->count();
                    $json[$key]['wt_total_percentage'] = $rating;
                    $educations = !empty(unserialize($user_object->profile->education)) ? unserialize($user_object->profile->education) : array();
                    $freelancer_educations  = array();
                    if (!empty($educations)) {
                        foreach ($educations as $edu_key => $education) {
                            $freelancer_educations[$edu_key]['title'] = !empty($education['degree_title']) ? $education['degree_title'] : '';
                            $freelancer_educations[$edu_key]['institute'] = !empty($education['institute_title']) ? $education['institute_title'] : '';
                            $freelancer_educations[$edu_key]['startdate'] = !empty($education['start_date']) ? url($education['start_date']) : '';
                            $freelancer_educations[$edu_key]['enddate'] = !empty($education['end_date']) ? url($education['end_date']) : '';
                            $freelancer_educations[$edu_key]['description'] = !empty($education['description']) ? url($education['description']) : '';
                        }
                        $json[$key]['_educations'] = $freelancer_educations;
                    }

                    $experiences = !empty(unserialize($user_object->profile->experience)) ? unserialize($user_object->profile->experience) : array();
                    $freelancer_experiences  = array();
                    if (!empty($experiences)) {
                        foreach ($experiences as $exp_key => $experience) {
                            $freelancer_experiences[$exp_key]['title'] = !empty($experience['job_title']) ? $experience['job_title'] : '';
                            $freelancer_experiences[$exp_key]['company'] = !empty($experience['company_title']) ? $experience['company_title'] : '';
                            $freelancer_experiences[$exp_key]['startdate'] = !empty($experience['start_date']) ? url($experience['start_date']) : '';
                            $freelancer_experiences[$exp_key]['enddate'] = !empty($experience['end_date']) ? $experience['end_date'] : '';
                            $freelancer_experiences[$exp_key]['description'] = !empty($experience['description']) ? $experience['description'] : '';
                        }
                        $json[$key]['_experiences'] = $freelancer_experiences;
                    }
                    $projects = !empty(unserialize($user_object->profile->projects)) ? unserialize($user_object->profile->projects) : array();
                    $freelancer_projects  = array();
                    if (!empty($projects)) {
                        foreach ($projects as $project_key => $project) {
                            $freelancer_projects[$project_key]['title'] = !empty($project['project_title']) ? $project['project_title'] : '';
                            $freelancer_projects[$project_key]['url'] = !empty($project['project_url']) ? $project['project_url'] : '';
                            $freelancer_projects[$project_key]['image']['url'] = !empty($project['project_hidden_image']) ? url('/uploads/users/' . $user['id'] . '/projects/' . $project['project_hidden_image']) : '';
                        }
                        $json[$key]['_projects'] = $freelancer_projects;
                    }
                    $awards = !empty(unserialize($user_object->profile->awards)) ? unserialize($user_object->profile->awards) : array();
                    $freelancer_awards  = array();
                    if (!empty($awards)) {
                        foreach ($awards as $award_key => $award) {
                            $freelancer_awards[$award_key]['title'] = !empty($award['award_title']) ? $award['award_title'] : '';
                            $freelancer_awards[$award_key]['date'] = !empty($award['award_date']) ? $award['award_date'] : '';
                            $freelancer_awards[$award_key]['image']['url'] = !empty($award['award_hidden_image']) ? url('/uploads/users/' . $user['id'] . '/awards/' . $award['award_hidden_image']) : '';
                        }
                        $json[$key]['_awards'] = $freelancer_awards;
                    }
                    $json[$key]['_longitude'] = !empty($user_object->profile->longitude) ? $user_object->profile->longitude : '';
                    $json[$key]['_latitude'] = !empty($user_object->profile->latitude) ? $user_object->profile->latitude : '';
                    $json[$key]['location']['_country'] = !empty($user_object->location->title) ? $user_object->location->title : '';
                    $json[$key]['location']['flag'] = !empty($user_object->location->flag) ? url('/uploads/locations/' . $user_object->location->flag) : '';
                    $json[$key]['_address'] = !empty($user_object->profile->address) ? $user_object->profile->address : '';
                    $json[$key]['_tag_line'] = !empty($user_object->profile->tagline) ? $user_object->profile->tagline : '';
                    $json[$key]['_gender'] = !empty($user_object->profile->gender) ? $user_object->profile->gender : '';
                    $json[$key]['_is_verified'] = $user['user_verified'] == 1 ? 'yes' : 'no';
                    $json[$key]['_english_level'] = $user_object->profile->english_level;
                    $json[$key]['_profile_blocked'] = $user_object->profile->profile_blocked;
                    $json[$key]['_profile_searchable'] = $user_object->profile->profile_searchable;
                    $json[$key]['_featured_timestamp']['class'] = "wt-featured";
                    $json[$key]['_freelancer_type'] = !empty($user_object->profile->freelancer_type) ? $user_object->profile->freelancer_type : '';
                    $json[$key]['_categories'] = !empty($user_object->category) ? $user_object->category : '';
                    $json[$key]['_perhour_rate'] = !empty($user_object->profile->hourly_rate) ? $symbol . '&nbsp;' . $user_object->profile->hourly_rate : '';
                    $skills = $user_object->skills->toArray();
                    $skills_args  = array();
                    if (!empty($skills)) {
                        foreach ($skills as $skill_key => $skill) {
                            $skills_args[$skill_key]['skill_val'] = !empty($skill['pivot']['skill_rating']) ? $skill['pivot']['skill_rating'] : '';
                            $skills_args[$skill_key]['skill_name'] = !empty($skill['title']) ? $skill['title'] : '';
                        }
                    }
                    $json[$key]['skills'] = $skills_args;
                    $json[$key]['completed_jobs'] = JobHelper::getProposals($user['id'], 'completed')->count();
                    $json[$key]['ongoning_jobs'] = JobHelper::getProposals($user['id'], 'hired')->count();
                    $json[$key]['cancelled_jobs'] = JobHelper::getProposals($user['id'], 'cancelled')->count();
                    $reviews = Review::where('receiver_id', $user['id'])->get();
                    $freelancer_reviewes  = array();
                    if (!empty($reviews) && $reviews->count() > 0) {
                        foreach ($reviews as $reviews_key => $review) {
                            $job = JobJob::where('id', $review->job_id)->first();
                            $verified_user = User::select('user_verified')->where('id', $review->user_id)->pluck('user_verified')->first();
                            $freelancer_reviewes[$reviews_key]['project_title'] = !empty($job->title) ? $job->title : '';
                            $freelancer_reviewes[$reviews_key]['post_date'] = Carbon::parse($job->created_at)->format('M Y');
                            $freelancer_reviewes[$reviews_key]['employer_image'] = !empty(JobHelper::getProfileImage($review->user_id)) ? asset(JobHelper::getProfileImage($review->user_id)) : '';
                            $freelancer_reviewes[$reviews_key]['_is_verified'] = $verified_user == 1 ? 'yes' : 'no';
                            $freelancer_reviewes[$reviews_key]['employer_name'] = JobHelper::getUserName($review->user_id);
                            $freelancer_reviewes[$reviews_key]['level_title'] = !empty($job->project_level) ?  JobHelper::getProjectLevel($job->project_level) : '';
                            $freelancer_reviewes[$reviews_key]['project_location'] = $job->location->title;
                            $freelancer_reviewes[$reviews_key]['project_rating'] = "" . $review->avg_rating . "";
                            $freelancer_reviewes[$reviews_key]['review_content'] = !empty($review->feedback) ?  $review->feedback : '';
                        }
                        $json[$key]['reviews'] = $freelancer_reviewes;
                    }
                }
                return Response::json($json, 200);
            } else {
                $json['type']        = 'error';
                $json['message']    = trans('lang.no_record');
                return Response::json($json, 203);
            }
        } else {
            $json['type']        = 'error';
            $json['message']    = trans('lang.no_record');
            return Response::json($json, 203);
        }
    }

    /**
     * Login user for application
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function userLogin(Request $request)
    {
        $json = array();
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $json['type'] = 'success';
            $json['profile']['pmeta']['user_type'] = auth()->user()->getRoleNames()[0];
            $json['profile']['pmeta']['profile_img'] = url(JobHelper::getProfileImage(auth()->user()->id));
            $json['profile']['pmeta']['banner_img'] = url(JobHelper::getProfileBanner(auth()->user()->id));
            $json['profile']['pmeta']['_tag_line'] = auth()->user()->profile->tagline;
            $json['profile']['pmeta']['_gender'] = auth()->user()->profile->gender;
            $json['profile']['pmeta']['_is_verified'] = auth()->user()->user_verified == 1 ? 'yes' : 'no';
            $json['profile']['pmeta']['full_name'] = JobHelper::getUserName(auth()->user()->id);
            $json['profile']['umeta']['profile_id'] = auth()->user()->profile->id;
            $json['profile']['umeta']['id'] = auth()->user()->id;
            $json['profile']['umeta']['user_login'] = $request['email'];
            $json['profile']['umeta']['user_pass'] = $request['password'];
            $json['profile']['umeta']['user_email'] = $request['email'];
            return response()->json($json, 200);
        } else {
            return response()->json(['error' => 'UnAuthorized'], 203);
        }
    }

    /**
     * Login user for application
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function userLogout(Request $request)
    {
        $json = array();
        if (auth()->user()) {
            auth()->logout();
            return response()->json($json, 200);
        } else {
            return response()->json(['error' => 'UnAuthorized'], 203);
        }
    }

    /**
     * Upload profile image
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadMedia(Request $request)
    {
        $image = '';
        $user_id    = !empty($request['id']) ? intval($request['id']) : '';
        if ($request->file('profile_image')) {
            $image = !empty($request->file('profile_image')) ?  $request->file('profile_image') : '';
        } elseif ($request->file('banner_image')) {
            $image = !empty($request->file('banner_image')) ?  $request->file('banner_image') : '';
        }
        $path = JobHelper::PublicPath() . '/uploads/users/' . $user_id;
        $file_name = time() . '-' . $image->getClientOriginalName();
        if (!empty($user_id) && !empty($image)) {
            $upload_image = JobHelper::uploadTempImage($path, $image, $file_name);
            if ($upload_image['type'] == 'success') {
                $user_profile = JobProfile::select('id')->where('user_id', $user_id)
                    ->get()->first();
                if (!empty($user_profile->id)) {
                    $profile = JobProfile::find($user_profile->id);
                    if ($request->file('profile_image')) {
                        $profile->avater = filter_var($file_name, FILTER_SANITIZE_STRING);
                    } else if ($request->file('banner_image')) {
                        $profile->banner = filter_var($file_name, FILTER_SANITIZE_STRING);
                    }
                    $profile->save();
                    $json['type']        = 'success';
                    $json['message']    = $upload_image['message'];
                    return Response::json($json, 200);
                } else {
                    $json['type']       = 'error';
                    $json['message']    = trans('lang.profile_rec_found');
                    return Response::json($json, 203);
                }
            } else if ($upload_image['type'] == 'error') {
                $json['type']        = 'error';
                $json['message']    = $upload_image['message'];
                return Response::json($json, 203);
            }
        } else {
            $json['type']        = 'error';
            $json['message']    = trans('lang.invalid_img_data');
            return Response::json($json, 200);
        }
    }

    /**
     * Update user wishlist
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function updateWishlist(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type']    = 'error';
            $json['message'] = $server->getData()->message;
            return Response::json($json, 203);
        }
        $json = array();
        $user_id = !empty($request['id']) ? $request['id'] : '';
        $id = !empty($request['favorite_id']) ? $request['favorite_id'] : '';
        $column = !empty($request['type']) ? $request['type'] : '';
        if (!empty($user_id) && !empty($id) && !empty($column)) {
            $profile = new JobProfile();
            $add_wishlist = $profile->addWishlist($column, $id, $user_id);
            if ($add_wishlist == "success") {
                $json['type'] = 'success';
                $json['message'] = trans('lang.added_to_wishlist');
                return Response::json($json, 200);
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return Response::json($json, 203);
            }
        } else {
            $json['type']        = 'error';
            $json['message']    = trans('lang.invalid_data');
            return Response::json($json, 203);
        }
    }

    /**
     * Submit proposal
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function submitProposal(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type']    = 'error';
            $json['message'] = $server->getData()->message;
            return Response::json($json, 203);
        }
        if (!empty($request)) {
            $json = array();
            $user_id = !empty($request['user_id']) ? $request['user_id'] : '';
            $project_id = !empty($request['project_id']) ? $request['project_id'] : '';
            $amount = !empty(($request['proposed_amount'])) ? ($request['proposed_amount']) : '';
            $duration = !empty($request['proposed_time']) ? $request['proposed_time'] : '';
            $description = !empty($request['proposed_content']) ? $request['proposed_content'] : '';
            $size = !empty($request['size']) ? $request['size'] : '';
            $path = 'uploads/proposals/' . $user_id . '/';
            if (!file_exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
            if (!empty($request['user_id']) && !empty($request['project_id']) && !empty($request['proposed_amount']) && !empty($request['proposed_time']) && !empty($request['proposed_content'])) {
                $job = JobJob::find(intval($project_id));
                if (intval($amount) > $job->price) {
                    $json['type'] = 'error';
                    $json['message'] = 'Proposal amount must not exceed the job amount';
                    return Response::json($json, 203);
                }
                $package = DB::table('job_items')->where('subscriber', $user_id)->select('product_id')->first();
                $proposal = new JobProposal();
                $proposals = $proposal::where('freelancer_id', $user_id)->count();
                $settings = JobSiteManagement::getMetaValue('settings');
                $required_connects = !empty($settings) && !empty($settings[0]['connects_per_job']) ? $settings[0]['connects_per_job'] : 2;
                if (!empty($package->product_id)) {
                    $package_options = JobPackage::select('options')->where('id', $package->product_id)->get()->first();
                    $option = unserialize($package_options->options);
                    $allowed_proposals = $option['no_of_connects'] / $required_connects;
                    if ($proposals <= $allowed_proposals) {
                        $proposal->amount = intval($amount);
                        $proposal->completion_time = filter_var($duration, FILTER_SANITIZE_STRING);
                        $proposal->content = filter_var($description, FILTER_SANITIZE_STRING);
                        $proposal->freelancer_id = intval($user_id);
                        $job = JobJob::find($project_id);
                        $proposal->job()->associate($job);
                        $proposal_attachments = array();
                        $path = storage_path() . '/uploads/proposals/' . $user_id . '/';
                        if (!file_exists($path)) {
                            File::makeDirectory($path, 0755, true, true);
                        }
                        if (!empty($size)) {
                            for ($x = 0; $x < $size; $x++) {
                                $attachments = $request['attachments' . $x];
                                //$file = 'attachments'.$size;
                                $file_original_name = time() . '-' . $attachments->getClientOriginalName();
                                $img = Image::make($attachments);
                                $img->save($path . '/' . $file_original_name);
                                $proposal_attachments[] = $file_original_name;
                            }
                        }
                        $proposal->attachments = serialize($proposal_attachments);
                        $proposal->save();
                        $json['type'] = 'success';
                        $json['message'] = trans('lang.proposal_submitted');
                        // Send Email
                        $email_settings = JobSiteManagement::getMetaValue('settings');
                        if (!empty($email_settings) && !empty($email_settings[0]['email'])) {
                            config(['mail.username' => $email_settings[0]['email']]);
                        }
                        $user = User::find($user_id);
                        //send email
                        if (!empty($job->employer->email)) {
                            $email_params = array();
                            $proposal_received_template = DB::table('email_types')->select('id')
                                ->where('email_type', 'employer_email_proposal_received')
                                ->get()->first();
                            $proposal_message_template = DB::table('email_types')->select('id')
                                ->where('email_type', 'employer_email_proposal_message')
                                ->get()->first();
                            $proposal_submitted_template = DB::table('email_types')->select('id')
                                ->where('email_type', 'freelancer_email_new_proposal_submitted')
                                ->get()->first();
                            if (
                                !empty($proposal_received_template->id)
                                || !empty($proposal_message_template->id)
                                || !empty($proposal_submitted_template->id)
                            ) {
                                $template_data = EmailTemplate::getEmailTemplateByID($proposal_received_template->id);
                                $template_message_data = EmailTemplate::getEmailTemplateByID($proposal_message_template->id);
                                $template_submit_proposal = EmailTemplate::getEmailTemplateByID($proposal_submitted_template->id);
                                $email_params['employer'] = JobHelper::getUserName($job->employer->id);
                                $email_params['employer_profile'] = url('Job/profile/' . $job->employer->slug);
                                $email_params['freelancer'] = JobHelper::getUserName($user_id);
                                $email_params['freelancer_profile'] = url('Job/profile/' . $user->slug);
                                $email_params['title'] = $job->title;
                                $email_params['link'] = url('job/' . $job->slug);
                                $email_params['amount'] = $amount;
                                $email_params['duration'] = JobHelper::getJobDurationList($duration);
                                $email_params['message'] = $description;
                                Mail::to($job->employer->email)
                                    ->send(
                                        new EmployerEmailMailable(
                                            'employer_email_proposal_received',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                                Mail::to($job->employer->email)
                                    ->send(
                                        new EmployerEmailMailable(
                                            'employer_email_proposal_message',
                                            $template_message_data,
                                            $email_params
                                        )
                                    );
                                Mail::to($user->email)
                                    ->send(
                                        new FreelancerEmailMailable(
                                            'freelancer_email_new_proposal_submitted',
                                            $template_submit_proposal,
                                            $email_params
                                        )
                                    );
                            }
                        }
                        return Response::json($json, 200);
                    } else {
                        $json['type'] = 'error';
                        $json['message'] = trans('lang.not_enough_connects');
                        return Response::json($json, 203);
                    }
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.need_to_purchase_pkg');
                    return Response::json($json, 203);
                }
            }
            $json['type']        = 'error';
            $json['message']    = trans('lang.invalid_data');
            return Response::json($json, 203);
        }
    }

    /**
     * Get employer API
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployer()
    {
        $json = array();
        $profile_id = !empty($_GET['profile_id']) ? $_GET['profile_id'] : '';
        $login_user = !empty($profile_id) ? User::find($profile_id) : new User();
        $type = !empty($_GET['listing_type']) ? $_GET['listing_type'] : '';
        $post_per_page = !empty($_GET['show_users']) ? $_GET['show_users'] : 10;
        $page_number = !empty($_GET['page_number']) ? $_GET['page_number'] : 1;
        $user_by_role =  User::role('employer')->select('id')
            ->get()->pluck('id')->toArray();
        $users = User::whereIn('id', $user_by_role);
        Paginator::currentPageResolver(
            function () use ($page_number) {
                return $page_number;
            }
        );
        if ($type === 'latest') {
            if (!empty($users)) {
                $users = $users->latest()->paginate($post_per_page);
            } else {
                $json['type']        = 'error';
                $json['message']    = trans('lang.no_emp_list');
                return Response::json($json, 203);
            }
        } elseif ($type === 'favorite') {
            $save_employer = !empty($login_user->profile->saved_employers) ?
                unserialize($login_user->profile->saved_employers) : array();
            if (!empty($save_employer)) {
                $users->whereIn('id', $save_employer)->orderBy('updated_at', 'desc')
                    ->paginate($post_per_page);
            } else {
                $json['type']        = 'error';
                $json['message']    = trans('lang.no_emp_list');
                return Response::json($json, 203);
            }
        } elseif ($type === 'search') {
            $user_id = array();
            $keyword = !empty($_GET['keyword']) ? $_GET['keyword'] : '';
            $search_locations = !empty($_GET['location']) ? $_GET['location'] : array();
            $search_employees = !empty($_GET['employees']) ? $_GET['employees'] : array();
            $search_project_types = !empty($_GET['project_type']) ? $_GET['project_type'] : array();
            $filters = array();
            $filters['type'] = $type;
            if (!empty($keyword)) {
                $filters['s'] = $keyword;
                $users->where('first_name', 'like', '%' . $keyword . '%');
                $users->orWhere('last_name', 'like', '%' . $keyword . '%');
                $users->orWhere('slug', 'like', '%' . $keyword . '%');
                $users->whereIn('id', $user_by_role);
            }
            if (!empty($search_locations)) {
                $filters['locations'] = $search_locations;
                $locations = JobLocation::select('id')->whereIn('slug', $search_locations)
                    ->get()->pluck('id')->toArray();
                $users->whereIn('location_id', $locations);
            }
            if (!empty($search_employees)) {
                $filters['employees'] = $search_employees;
                $employees = JobProfile::whereIn('no_of_employees', $search_employees)->get();
                foreach ($employees as $key => $employee) {
                    if (!empty($employee->user_id)) {
                        $user_id[] = $employee->user_id;
                    }
                }
                $users->whereIn('id', $user_id)->get();
            }
            if (!empty($search_project_types)) {
                $filters['project_type'] = $search_project_types;
                $projects = JobJob::where('project_type', $search_project_types)->get();
                if ($projects->count() > 0) {
                    foreach ($projects as $key => $project) {
                        if (!empty($project->employer[$key]->id)) {
                            $user_id[] = $project->employer[$key]->id;
                        }
                    }
                    $users->whereIn('id', $user_id);
                }
            }
            $users = $users->orderBy('updated_at', 'desc')->paginate($post_per_page);
        }
        if (!empty($users) && $users->count() > 0) {
            foreach ($users as $key => $user) {
                $saved_employers = !empty($login_user->profile->saved_employers) ?
                    unserialize($login_user->profile->saved_employers) : array();
                $json[$key]['favorit'] = in_array($user['id'], $saved_employers) ? 'yes' : '';
                $json[$key]['name'] = JobHelper::getUserName($user['id']);
                $json[$key]['user_id'] = !empty("" . $user['id'] . "") ? "" . $user['id'] . "" : '';
                $user_object = User::find($user['id']);
                $json[$key]['company_link'] = !empty($user_object) ? url('profile/' . $user_object->slug) : '';
                $json[$key]['employ_id'] = !empty($user_object->profile->id) ? "" . $user_object->profile->user_id . "" : '';
                $json[$key]['profile_id'] = !empty($user_object->profile->id) ? $user_object->profile->id : '';
                $json[$key]['profile_img'] = !empty($user_object->profile->avater) ? url(JobHelper::getProfileImage($user_object->id)) : '';
                $json[$key]['User_profileID'] = $user_object->profile->id;
                $json[$key]['employer_des'] = !empty($user_object->profile->description) ? $user_object->profile->description : '';
                $json[$key]['banner_img'] = !empty($user_object->profile->banner) ? url(JobHelper::getProfileBanner($user_object->id)) : '';
                $json[$key]['link'] = !empty($user_object->id) ? url('/profile/' . $user['slug'] . '') : '';
                $json[$key]['_longitude'] = !empty($user_object->profile->longitude) ? $user_object->profile->longitude : '';
                $json[$key]['_latitude'] = !empty($user_object->profile->latitude) ? $user_object->profile->latitude : '';
                $json[$key]['_address'] = !empty($user_object->profile->address) ? $user_object->profile->address : '';
                $json[$key]['_tag_line'] = !empty($user_object->profile->tagline) ? $user_object->profile->tagline : '';
                $json[$key]['_following_employers'] = array();
                $json[$key]['_saved_projects'] = !empty($user_object->profile->saved_jobs) ? $user_object->profile->saved_jobs : '';
                $json[$key]['_is_verified'] = $user['user_verified'] == 1 ? 'yes' : 'no';
                $freelancer_awards  = array();
                if (!empty($awards)) {
                    foreach ($awards as $award_key => $award) {
                        $freelancer_awards[$award_key]['title'] = !empty($award['award_title']) ? $award['award_title'] : '';
                        $freelancer_awards[$award_key]['date'] = !empty($award['award_date']) ? $award['award_date'] : '';
                        $freelancer_awards[$award_key]['image']['url'] = !empty($award['award_hidden_image']) ? url($award['award_hidden_image']) : '';
                    }
                    $json[$key]['_awards'] = $freelancer_awards;
                }
                $json[$key]['location']['_country'] = !empty($user_object->location->title) ? $user_object->location->title : '';
                $json[$key]['location']['flag'] = !empty($user_object->location->flag) ? url('/uploads/locations/' . $user_object->location->flag) : '';
            }
            return Response::json($json, 200);
        } else {
            $json['type']        = 'error';
            $json['message']    = trans('lang.no_record');
            return Response::json($json, 203);
        }
        return $json;
    }

    /**
     * Get jobs API
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getJobs(Request $request)
    {
        $json = array();
        $jobs = new JobJob();
        $post_per_page = !empty($_GET['show_users']) ? $_GET['show_users'] : 10;
        $page_number = !empty($_GET['page_number']) ? $_GET['page_number'] : 1;
        if (!empty($_GET['profile_id'])) {
            $profile_id = !empty($_GET['profile_id']) ? $_GET['profile_id'] : '';
        } elseif (!empty($_GET['company_id'])) {
            $profile_id = !empty($_GET['company_id']) ? $_GET['company_id'] : '';
        }
        $user = !empty($profile_id) ? User::find($profile_id) : new User();
        $type = !empty($_GET['listing_type']) ? $_GET['listing_type'] : '';
        $currency   = JobSiteManagement::getMetaValue('commision');
        $curr_symbol = !empty($currency) && !empty($currency[0]['currency']) ? JobHelper::currencyList($currency[0]['currency']) : array();
        $symbol = !empty($curr_symbol) ? $curr_symbol['symbol'] : '$';
        Paginator::currentPageResolver(
            function () use ($page_number) {
                return $page_number;
            }
        );
        if ($type === 'latest') {
            $jobs = $jobs->latest()->paginate($post_per_page);
        } elseif ($type === 'favorite') {
            $saved_jobs = !empty($user->profile->saved_jobs) ?
                unserialize($user->profile->saved_jobs) : array();
            if (!empty($saved_jobs)) {
                $jobs =  $jobs->whereIn('id', $saved_jobs)->paginate($post_per_page);
            } else {
                $json['type']     = 'error';
                $json['message']  = trans('lang.no_jobs_list');
                return Response::json($json, 203);
            }
        } elseif ($type === 'company') {
            if (!empty($user)) {
                $jobs = $user->jobs;
            }
        } elseif ($type === 'search') {
            $job_id = array();
            $keyword = !empty($request['keyword']) ? $request['keyword'] : '';
            $search_languages = !empty($request['language']) ? $request['language'] : '';
            $search_locations = !empty($request['location']) ? $request['location'] : array();
            $search_categories = !empty($request['categories']) ? $request['categories'] : array();
            $search_category = !empty($request['category']) ? $request['category'] : array();
            $search_skills = !empty($request['skills']) ? $request['skills'] : array();
            $search_project_lengths = !empty($_GET['duration']) ? $_GET['duration'] : array();
            $json = array();
            $jobs = JobJob::select('*');
            $job_id = array();
            $filters = array();
            $filters['type'] = 'job';
            if (!empty($keyword)) {
                $filters['s'] = $keyword;
                $jobs->where('title', 'like', '%' . $keyword . '%');
            };
            if (!empty($search_categories)) {
                foreach ($search_categories as $key => $search_category) {
                    $categor_obj = JobCategory::where('slug', $search_category)->first();
                    $category = JobCategory::find($categor_obj->id);
                    if (!empty($category->jobs)) {
                        $category_jobs = $category->jobs->pluck('id')->toArray();
                        foreach ($category_jobs as $id) {
                            $job_id[] = $id;
                        }
                    }
                }
                $jobs->whereIn('id', $job_id);
            }
            if (!empty($search_category)) {
                $category_obj = JobCategory::where('slug', $search_category)->first();
                $category = JobCategory::find($category_obj->id);
                if (!empty($category->jobs)) {
                    $category_jobs = $category->jobs->pluck('id')->toArray();
                    foreach ($category_jobs as $id) {
                        $job_id[] = $id;
                    }
                }
                $jobs->whereIn('id', $job_id);
            }
            if (!empty($search_locations)) {
                $filters['locations'] = $search_locations;
                $locations = JobLocation::select('id')->whereIn('slug', $search_locations)->get()->pluck('id')->toArray();
                $jobs->whereIn('location_id', $locations);
            }
            if (!empty($search_skills)) {
                $filters['skills'] = $search_skills;
                foreach ($search_skills as $key => $search_skill) {
                    $skill_obj =JobSkill::where('slug', $search_skill)->first();
                    $skill =JobSkill::find($skill_obj->id);
                    if (!empty($skill->jobs)) {
                        $skill_jobs = $skill->jobs->pluck('id')->toArray();
                        foreach ($skill_jobs as $id) {
                            $job_id[] = $id;
                        }
                    }
                }
                $jobs->whereIn('id', $job_id);
            }
            if (!empty($search_project_lengths)) {
                $filters['project_lengths'] = $search_project_lengths;
                $jobs->whereIn('duration', $search_project_lengths);
            }
            if (!empty($search_languages)) {
                $filters['languages'] = $search_languages;
                $languages = Language::whereIn('slug', $search_languages)->get();
                foreach ($languages as $key => $language) {
                    if (!empty($language->jobs[$key]->id)) {
                        $job_id[] = $language->jobs[$key]->id;
                    }
                }
                $jobs->whereIn('id', $job_id);
            }

            $jobs = $jobs->orderBy('updated_at', 'desc')->paginate($post_per_page);
        }
        if (!empty($user) && $user->count() > 0) {
            foreach ($jobs as $key => $job) {
                $saved_jobs = !empty($user->profile->saved_jobs) ?
                    unserialize($user->profile->saved_jobs) : array();
                $json[$key]['favorit'] = in_array($job->id, $saved_jobs) ? 'yes' : '';
                $json[$key]['job_id'] = !empty($job->id) ? $job->id : '';
                $json[$key]['status'] = !empty($job->status) ? $job->status : '';
                $json[$key]['link'] = url('Job/job/' . $job->slug);
                $json[$key]['amount'] = $symbol . '&nbsp;' . $job->price;
                $user_object = User::find($job->user_id);
                $json[$key]['_is_verified'] = !empty($user_obj->id) && $user_obj->user_verified === 1  ? "yes" : "no";
                $json[$key]['featured_url'] = !empty($job->is_featured) && $job->is_featured === 'true' ? "" . url('images/featured.png') . "" : '';
                $json[$key]['featured_color'] = !empty($job->is_featured) && $job->is_featured === 'true' ? "#f1c40f" : '';
                $json[$key]['location']['_country'] = !empty($job->location->title) ? $job->location->title : '';
                $json[$key]['location']['flag'] = !empty($job->location->flag) ? url('/uploads/locations/' . $job->location->flag) : '';
                $json[$key]['project_level']['level_title'] = !empty($job->id) ? JobHelper::getProjectLevel($job->project_level) : '';
                $json[$key]['project_level']['level_sign'] = 0;
                $json[$key]['project_type'] = !empty($job->project_type) ? $job->project_type : '';
                $json[$key]['project_duration'] = !empty($job->duration) ? JobHelper::getJobDurationList($job->duration) : '';
                $attachments = !empty($job->attachments) ? unserialize($job->attachments) : array();
                $doc = array();
                if (!empty($attachments)) {
                    $docs_count = 0;
                    foreach ($attachments as $attach_key => $attachment) {
                        $docs_count++;
                        $doc[$docs_count]['document_name'] = !empty($attachment) ? $attachment : '';
                        $doc[$docs_count]['url'] = !empty($attachment) ? "" . route('getfile', ['type'=>'jobs','attachment'=>$attachment,'id'=>$job->user_id]) . "" : '';
                    }
                }
                $json[$key]['attanchents']    = array_values($doc);
                $skills = $job->skills->toArray();
                $skills_args  = array();
                foreach ($skills as $skill_key => $skill) {
                    $skills_args[$skill_key]['skill_val'] = !empty($skill['pivot']['skill_rating']) ? $skill['pivot']['skill_rating'] : '';
                    $skills_args[$skill_key]['skill_name'] = !empty($skill['title']) ? $skill['title'] : '';
                }
                $json[$key]['skills'] = $skills_args;
                $json[$key]['employer_name'] = !empty($user_object->id) ? JobHelper::getUserName($user_object->id) : '';
                $json[$key]['project_title'] = !empty($job->title) ? $job->title : '';
                $json[$key]['project_content'] = !empty($job->id) ? $job->description : '';
            }
            return Response::json($json, 200);
        } else {
            $json['type']        = 'error';
            $json['message']    = trans('lang.no_record');
            return Response::json($json, 203);
        }
        return $json;
    }

    /**
     * Update Profile
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type']    = 'error';
            $json['message'] = $server->getData()->message;
            return Response::json($json, 203);
        }
        $user = User::find($request['user_id']);
        $role_id = JobHelper::getRoleByUserID($request['user_id']);
        $packages = DB::table('job_items')->where('subscriber', $request['user_id'])->count();
        $package_options = JobPackage::select('options')->where('role_id', $role_id)->first();
        $options = !empty($package_options) ? unserialize($package_options->options) : array();
        if ($packages > 0) {
            if ($user->getRoleNames()->first() === 'freelancer') {
                $skills = !empty($options) ? $options['no_of_skills'] : array();
                if (!empty($request['skills'])) {
                    if (count($request['skills']) > $skills) {
                        $json['type'] = 'error';
                        $json['message'] = trans('lang.cannot_add_morethan') . '' . $options['no_of_skills'] . '' . trans('lang.skills');
                        return $json;
                    }
                }
            }
            //Updation in User table
            if ($user->first_name . '-' . $user->last_name != $request['first_name'] . '-' . $request['last_name']) {
                $user->slug = filter_var($request['first_name'], FILTER_SANITIZE_STRING) . '-' .
                    filter_var($request['last_name'], FILTER_SANITIZE_STRING);
            }
            $user->first_name = filter_var($request['first_name'], FILTER_SANITIZE_STRING);
            $user->last_name = filter_var($request['last_name'], FILTER_SANITIZE_STRING);
            $location = JobLocation::find($request['location_id']);
            $user->location()->associate($location);
            $user->save();
            //Updation in Profile table
            $profile = new JobProfile();
            $user_profile = $profile->select('id')
                ->where('user_id', $request['user_id'])
                ->get()->first();
            if (!empty($user_profile->id)) {
                $profile = JobProfile::find($user_profile->id);
            } else {
                $profile = $user;
            }
            $profile->user()->associate($request['user_id']);
            $profile->freelancer_type = !empty($request['freelancer_type']) ?
                filter_var($request['freelancer_type'], FILTER_SANITIZE_STRING) : $profile->freelancer_type;
            $profile->hourly_rate = !empty($request['hourly_rate']) ?
                intval($request['hourly_rate']) : $profile->hourly_rate;
            $profile->longitude = !empty($request['longitude']) ?
                filter_var($request['longitude'], FILTER_SANITIZE_STRING) : $profile->longitude;
            $profile->latitude = !empty($request['latitude']) ?
                filter_var($request['latitude'], FILTER_SANITIZE_STRING) : $profile->latitude;
            $profile->address = !empty($request['address']) ?
                filter_var($request['address'], FILTER_SANITIZE_STRING) : $profile->address;
            $profile->gender = !empty($request['gender']) ?
                filter_var($request['gender'], FILTER_SANITIZE_STRING) : $profile->gender;
            $profile->tagline = !empty($request['tagline']) ?
                filter_var($request['tagline'], FILTER_SANITIZE_STRING) : $profile->tagline;
            if ($request['employees']) {
                $profile->no_of_employees = intval($request['employees']);
            }
            if ($request['department']) {
                $department = JobDepartment::find($request['department']);
                $profile->department()->associate($department);
            }

            $profile->save();
            $json['type'] = 'success';
            $json['message'] = trans('lang.profile_update_success');
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.update_pkg');
            return $json;
        }
        return $json;
    }

    /**
     * Get listings
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function listings()
    {
        $json = array();
        $rates = array();
        $english_levels = array();
        $freelancer_level = array();
        $duration_list = array();
        $project_type = array();
        $reason_types = array();
        $type = !empty($_GET['list']) ? $_GET['list'] : '';
        if (!empty($type)) {
            //Hourly Rates
            if ($type === 'rates') {
                $rates = JobHelper::getHourlyRate();
                if (!empty($rates)) {
                    $count = 0;
                    foreach ($rates as $value => $rate) {
                        $json[$count]['title'] = !empty($rate) ? JobHelper::getHourlyRate($value) : '';
                        $json[$count]['value'] = !empty($rate) ? $value : '';
                        $count++;
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            //English Levels
            if ($type === 'english_levels') {
                $english_levels = JobHelper::getEnglishLevelList();
                if (!empty($english_levels)) {
                    $count = 0;
                    foreach ($english_levels as $value => $level) {
                        $json[$count]['title'] = !empty($level) ? JobHelper::getEnglishLevelList($value) : '';
                        $json[$count]['value'] = !empty($level) ? $value : '';
                        $count++;
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            //Freelancer Levels
            if ($type === 'freelancer_level') {
                $freelancer_level = JobHelper::getFreelancerLevelList();
                if (!empty($freelancer_level)) {
                    $count = 0;
                    foreach ($freelancer_level as $value => $level) {
                        $json[$count]['title'] = !empty($level) ? JobHelper::getFreelancerLevelList($value) : '';
                        $json[$count]['value'] = !empty($level) ? $value : '';
                        $count++;
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            //Duration List
            if ($type === 'duration_list') {
                $duration_list  = JobHelper::getJobDurationList();
                if (!empty($duration_list)) {
                    $count = 0;
                    foreach ($duration_list as $value => $list) {
                        $json[$count]['title'] = !empty($list) ? JobHelper::getJobDurationList($value) : '';
                        $json[$count]['value'] = !empty($list) ? $value : '';
                        $count++;
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            //Project Type
            if ($type === 'project_type') {
                $project_type  = JobHelper::getProjectType();
                if (!empty($project_type)) {
                    $count = 0;
                    foreach ($project_type as $value => $type) {
                        $json[$count]['title'] = !empty($type) ? JobHelper::getProjectType($value) : '';
                        $json[$count]['value'] = !empty($type) ? $value : '';
                        $count++;
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            //Reason Types
            if ($type === 'reason_type') {
                $reason_types = JobHelper::getReportReasons();
                if (!empty($reason_types)) {
                    $count = 0;
                    foreach ($reason_types as $value => $type) {
                        $json[$count]['title'] = !empty($type) ? $type['title']  : '';
                        $json[$count]['value'] = !empty($type) ? $type['value'] : '';
                        $count++;
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            //Project Level
            if ($type === 'project_level') {
                $project_level  = JobHelper::getProjectLevel();
                if (!empty($project_level)) {
                    $count = 0;
                    foreach ($project_level as $value => $level) {
                        $json[$count]['title'] = !empty($level) ? JobHelper::getProjectLevel($value) : '';
                        $json[$count]['value'] = !empty($level) ? $value : '';
                        $count++;
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
        } else {
            $json['type']        = 'error';
            $json['message']    = trans('lang.no_list');
            return Response::json($json, 203);
        }
    }

    /**
     * Get categories
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getCategories()
    {
        $categories = JobCategory::all();
        if (!empty($categories) && $categories->count() > 0) {
            foreach ($categories as $key => $cat) {
                $cat_obj = JobCategory::find($cat->id);
                $json[$key]['image'] = !empty($cat->id) ? url('Job/uploads/categories/' . $cat->image) : array();
                $json[$key]['link'] = url('Job/search-results?type=job&category%5B%5D=' . $cat->id);
                $json[$key]['name'] = !empty($cat->title) ? $cat->title : '';
                $json[$key]['slug'] = !empty($cat->slug) ? $cat->slug : '';
                $json[$key]['term_id'] = !empty($cat->id) ? $cat->id : '';
                $json[$key]['description'] = !empty($cat->abstract) ? $cat->abstract : '';
                $json[$key]['items'] = !empty($cat->id) ? $cat_obj->jobs->count() : array();
            }
            return Response::json($json, 200);
        } else {
            $json['type']        = 'error';
            $json['message']    = trans('lang.no_record');
            return Response::json($json, 203);
        }
    }

    /**
     * Submit Report
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function storeReport(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type']    = 'error';
            $json['message'] = $server->getData()->message;
            return Response::json($json, 203);
        }
        $json = array();
        if (!empty($request['user_id']) && !empty($request['id'])) {
            $model = JobJob::find($request['id']);
            $report = new Report;
            if (!empty($request['reason']) && !empty($request['description'])) {
                $report->reason = filter_var($request['reason'], FILTER_SANITIZE_STRING);
                $report->description = filter_var($request['description'], FILTER_SANITIZE_STRING);
                $model->reports()->save($report);
                $json['type'] = 'success';
            } else {
                $json['error'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return Response::json($json, 203);
            }
            if ($json['type'] == 'success') {
                $email_settings = JobSiteManagement::getMetaValue('settings');
                $user = User::find($request['user_id']);
                //send email
                if (!empty($email_settings) && !empty($email_settings[0]['email'])) {
                    $email_params = array();
                    if ($request['type'] == 'job') {
                        $report_project_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_report_project')->get()->first();
                        if (!empty($report_project_template->id)) {
                            $job = Job::where('id', $request['id'])->first();
                            $template_data = EmailTemplate::getEmailTemplateByID($report_project_template->id);
                            $email_params['reported_project'] = $job->title;
                            $email_params['link'] = url('Job/job/' . $job->slug);
                            $email_params['report_by_link'] = url('Job/profile/' . $user->slug);
                            $email_params['reported_by'] = JobHelper::getUserName($user->id);
                            $email_params['message'] = $request['description'];
                            Mail::to(config('mail.username'))
                                ->send(
                                    new AdminEmailMailable(
                                        'admin_email_report_project',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                    }
                }
                $json['message'] = trans('lang.report_submitted');
                return Response::json($json, 200);
            } else {
                $json['error'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return Response::json($json, 203);
            }
            return Response::json($json, 200);
        } else {
            return Response::json($json, 203);
        }
    }

    /**
     * Get listings
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function taxonomies()
    {
        $json = array();
        $languages = array();
        $skills = array();
        $locations = array();
        $categories = array();
        $no_of_employes = array();
        $type = !empty($_GET['taxonomy']) ? $_GET['taxonomy'] : '';
        if (!empty($type)) {
            // Categories
            if ($type === 'project_cat') {
                $categories = JobCategory::all();
                if (!empty($categories)) {
                    foreach ($categories as $key => $cat) {
                        $cat_obj = JobCategory::find($cat->id);
                        $json[$key]['id'] = !empty($cat->id) ? $cat->id : '';
                        $json[$key]['title'] = !empty($cat->title) ? $cat->title : '';
                        $json[$key]['slug'] = !empty($cat->slug) ? $cat->slug : '';
                        $json[$key]['items'] = !empty($cat->id) ? $cat_obj->jobs->count() : array();
                        $json[$key]['image'] = !empty($cat->id) ? url('Job/uploads/categories/' . $cat->image) : array();
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            // Skills
            if ($type === 'skills') {
                $skills =JobSkill::all();

                if (!empty($skills)) {
                    foreach ($skills as $key => $skill) {
                        $skill_obj =JobSkill::find($skill->id);
                        $json[$key]['id'] = !empty($skill->id) ? $skill->id : '';
                        $json[$key]['title'] = !empty($skill->title) ? $skill->title : '';
                        $json[$key]['slug'] = !empty($skill->slug) ? $skill->slug : array();
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            // Languages
            if ($type === 'languages') {
                $languages = Language::all();
                if (!empty($languages)) {
                    foreach ($languages as $key => $lang) {
                        $lang_obj =JobSkill::find($lang->id);
                        $json[$key]['id'] = !empty($lang->id) ? $lang->id : '';
                        $json[$key]['title'] = !empty($lang->title) ? $lang->title : '';
                        $json[$key]['slug'] = !empty($lang->slug) ? $lang->slug : array();
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            // Locations
            if ($type === 'locations') {
                $locations = JobLocation::all();
                if (!empty($locations)) {
                    foreach ($locations as $key => $location) {
                        $location_obj = JobLocation::find($location->id);
                        $json[$key]['id'] = !empty($location->id) ? $location->id : '';
                        $json[$key]['title'] = !empty($location->title) ? $location->title : '';
                        $json[$key]['slug'] = !empty($location->slug) ? $location->slug : array();
                        $json[$key]['flag'] = !empty($location->flag) ? url('/uploads/locations/' . $location->flag) : array();
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
            //No of Employees
            if ($type === 'no_of_employes') {
                $no_of_employes = JobHelper::getEmployeesList();
                if (!empty($no_of_employes)) {
                    $count = 0;
                    foreach ($no_of_employes as $value => $list) {
                        $json[$count]['title'] = !empty($list) ? $list['title']  : '';
                        $json[$count]['search_title'] = !empty($list) ? $list['search_title']  : '';
                        $json[$count]['value'] = !empty($list) ? $list['value'] : '';
                        $count++;
                    }
                    return Response::json($json, 200);
                } else {
                    $json['type']        = 'error';
                    $json['message']    = trans('lang.no_record');
                    return Response::json($json, 203);
                }
            }
        } else {
            $json['type']        = 'error';
            $json['message']    = trans('lang.no_list');
            return Response::json($json, 203);
        }
    }

    /**
     * Get user info
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserInfo()
    {
        $json = array();
        $currency   = JobSiteManagement::getMetaValue('commision');
        $curr_symbol = !empty($currency) && !empty($currency[0]['currency']) ? JobHelper::currencyList($currency[0]['currency']) : array();
        $symbol = !empty($curr_symbol) ? $curr_symbol['symbol'] : '$';
        $id = !empty($_GET['id']) ? $_GET['id'] : '';
        if (!empty($id)) {
            $user = User::find($id);
            $json['first_name'] = !empty($user->first_name) ? $user->first_name : '';
            $json['last_name'] = !empty($user->last_name) ? $user->last_name : '';
            $json['tag_line'] = !empty($user->profile->tagline) ? $user->profile->tagline : '';
            $json['address'] = !empty($user->profile->address) ? $user->profile->address : '';
            $json['latitude'] =  !empty($user->profile->latitude) ? $user->profile->latitude : '';
            $json['longitude'] = !empty($user->profile->longitude) ? $user->profile->longitude : '';
            $json['location'] = !empty($user->location['title']) ? $user->location['title'] : '';
            $json['per_hour_rate'] = !empty($user->profile->hourly_rate) ? $symbol . '&nbsp;' . $user->profile->hourly_rate : '';
            $json['gender'] = !empty($user->profile->gender) ? $user->profile->gender : '';
            $json['department'] = !empty($user->profile->department) ? $user->profile->department['title'] : '';
            $json['no_of_employees'] = !empty($user->profile->no_of_employees) ? $user->profile->no_of_employees : '';
            $json['type'] = 'success';
            $json['message'] = 'Profile Settings';
            return Response::json($json, 200);
        } else {
            $json['type']    = 'error';
            $json['message'] = trans('lang.no_user');
            return Response::json($json, 203);
        }
    }

    /**
     * Store project Offer
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function sendProjectOffers(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type']    = 'error';
            $json['message'] = $server->getData()->message;
            return Response::json($json, 203);
        }
        $json = array();
        if (!empty($request['user_id'])
            && $request['freelancer_id']
            && $request['job_id']
            && $request['desc']
        ) {
            $offer = new JobOffer();
            $user = User::find($request['user_id']);
            if ($user->getRoleNames()->first() === 'employer') {
                $offer->freelancer_id = filter_var($request['freelancer_id'], FILTER_SANITIZE_STRING);
                $offer->project_id = filter_var($request['job_id'], FILTER_SANITIZE_STRING);
                $offer->description = filter_var($request['desc'], FILTER_SANITIZE_STRING);
                $offer->user()->associate($user);
                $offer->save();
                $json['type'] = 'success';
            } else {
                $json['type'] = 'error';
                $json['message'] = 'you are not authorized to perform this action';
                return Response::json($json, 203);
            }
            if ($json['type'] == "success") {
                $email_settings = JobSiteManagement::getMetaValue('settings');
                //send email
                if (!empty($email_settings) && !empty($email_settings[0]['email'])) {
                    $email_params = array();
                    $send_freelancer_offer = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_send_offer')->get()->first();
                    $message = new Message();
                    if (!empty($send_freelancer_offer->id)) {
                        $job = JobJob::where('id', $request['job_id'])->first();
                        $freelancer = User::find($request['freelancer_id']);
                        $template_data = EmailTemplate::getEmailTemplateByID($send_freelancer_offer->id);
                        $message->user_id = intval($request['user_id']);
                        $message->receiver_id = intval($request['freelancer_id']);
                        $message->body = $template_data->content;
                        $message->status = 0;
                        $message->save();
                        $email_params['project_title'] = $job->title;
                        $email_params['project_link'] = url('Job/job/' . $job->slug);
                        $email_params['employer_profile'] = url('Job/profile/' . $user->slug);
                        $email_params['emp_name'] = JobHelper::getUserName($request['user_id']);
                        $email_params['link'] = url('Job/profile/' . $freelancer->slug);
                        $email_params['name'] = JobHelper::getUserName($freelancer->id);
                        $email_params['msg'] = $request['desc'];
                        Mail::to($freelancer->email)
                            ->send(
                                new FreelancerEmailMailable(
                                    'freelancer_email_send_offer',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                }
                return Response::json($json, 200);
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.not_send_offer');
                return Response::json($json, 203);
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return Response::json($json, 203);
        }
    }

    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request req attr
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse response
     */
    public function sendResetLinkEmail(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type']    = 'error';
            $json['message'] = $server->getData()->message;
            return Response::json($json, 203);
        }
        $random_number = JobHelper::generateRandomCode(10);
        $verification_code = strtoupper($random_number);
        $json = array();
        $email_settings = JobSiteManagement::getMetaValue('settings');
        if (!empty($email_settings) && !empty($email_settings[0]['email'])) {
            config(['mail.username' => $email_settings[0]['email']]);
        }
        if (!empty($email_settings) && !empty($email_settings[0]['email'])) {
            $email_params = array();
            $template = DB::table('email_types')->select('id')->where('email_type', 'lost_password')->get()->first();
            $user = User::where('email', $request['email'])->first();
            if (!empty($template->id)) {
                $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                $email_params['email'] = $request['email'];
                $email_params['link'] = url('Job/user/password/reset/' . $verification_code);
                $email_params['name'] = JobHelper::getUserName($user->id);
                Mail::to($request['email'])
                    ->send(
                        new GeneralEmailMailable(
                            'lost_password',
                            $template_data,
                            $email_params
                        )
                    );
                $json['type'] = 'success';
                $json['message'] = trans('lang.email_sent');
                return Response::json($json, 200);
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return Response::json($json, 203);
        }
    }

    /**
     * Get employer jobs
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployerJobs()
    {
        $json = array();
        $employer_id = !empty($_GET['employer_id']) ? $_GET['employer_id'] : '';
        $employers = User::find($employer_id);
        if (!empty($employer_id)) {
            $employer_jobs  = array();
            if (!empty($employers->jobs)) {
                foreach ($employers->jobs->all() as $key => $project) {
                    $employer_jobs[$key]['id'] = !empty($project->id) ? $project->id : '';
                    $employer_jobs[$key]['title'] = !empty($project->title) ? $project->title : '';
                }
            }
            $json['jobs'] = $employer_jobs;
            //$json['type'] = 'success';
            return Response::json($json, 200);
        } else {
            $json['type']    = 'error';
            $json['message'] = trans('lang.no_jobs_found');
            return Response::json($json, 203);
        }
    }
    /**
     * Post Job
     *
     * @param mixed $request $req->attr
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function postJob(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type']    = 'error';
            $json['message'] = $server->getData()->message;
            return Response::json($json, 203);
        }
        $json = array();
        if (empty($request['title'])) {
            $json['error'] = 'Job title is required';
            return Response::json($json, 203);
        }
        if (empty($request['project_level'])) {
            $json['error'] = 'Project level is required.';
            return Response::json($json, 203);
        }
        if (empty($request['project_duration'])) {
            $json['error'] = 'Project duration is required.';
            return Response::json($json, 203);
        }
        if (empty($request['english_level'])) {
            $json['error'] = 'English level is required.';
            return Response::json($json, 203);
        }
        if (empty($request['project_cost'])) {
            $json['error'] = 'Project cost is required.';
            return Response::json($json, 203);
        }
        if (empty($request['description'])) {
            $json['error'] = 'Job description is required.';
            return Response::json($json, 203);
        }
        $freelancer_type = !empty($request['freelancer_level']) ? $request['freelancer_level'] : null;
        $is_featured = !empty($request['is_featured']) ? $request['is_featured'] : false;
        $show_attachments = !empty($request['show_attachments']) ? $request['show_attachments'] : false;
        $address = !empty($request['address']) ? $request['address'] : null;
        $longitude = !empty($request['longitude']) ? $request['longitude'] : null;
        $latitude = !empty($request['latitude']) ? $request['latitude'] : null;
        $current_user = $request['user_id'];
        $package_item = JobItem::where('subscriber', $current_user)->first();
        $package = JobPackage::find($package_item->product_id);
        $option = !empty($package->options) ? unserialize($package->options) : '';
        $expiry = !empty($option) ? $package_item->created_at->addDays($option['duration']) : '';
        $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->format('M d, Y') : '';
        $current_date = Carbon::now()->format('M d, Y');
        $posted_jobs = JobJob::where('user_id', $current_user)->count();
        $posted_featured_jobs = JobJob::where('user_id', $current_user)->where('is_featured', 'true')->count();
        $size = !empty($request['size']) ? $request['size'] : '';
        if (!empty($package) && $current_date <= $expiry_date) {
            if ($request['is_featured'] == 'true') {
                if ($posted_featured_jobs >= intval($option['featured_jobs'])) {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.sorry_can_only_feature')  . ' ' . $option['featured_jobs'] . ' ' . trans('lang.jobs_acc_to_pkg');
                    return Response::json($json, 203);
                }
            }
            if ($posted_jobs >= intval($option['jobs'])) {
                $json['type'] = 'error';
                $json['message'] = trans('lang.sorry_cannot_submit') . ' ' . $option['jobs'] . ' ' . trans('lang.jobs_acc_to_pkg');
                return Response::json($json, 203);
            } else {
                $random_number = JobHelper::generateRandomCode(8);
                $code = strtoupper($random_number);
                $location = $request['country'];
                $job = new JobJob();
                $job->location()->associate($location);
                $job->employer()->associate($current_user);
                $job->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
                $job->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
                $job->price = filter_var($request['project_cost'], FILTER_SANITIZE_STRING);
                $job->project_level = filter_var($request['project_level'], FILTER_SANITIZE_STRING);
                $job->description = $request['description'];
                $job->english_level = filter_var($request['english_level'], FILTER_SANITIZE_STRING);
                $job->duration = filter_var($request['project_duration'], FILTER_SANITIZE_STRING);
                $job->freelancer_type = filter_var($freelancer_type, FILTER_SANITIZE_STRING);
                $job->is_featured = filter_var($is_featured, FILTER_SANITIZE_STRING);
                $job->show_attachments = filter_var($show_attachments, FILTER_SANITIZE_STRING);
                $job->address = filter_var($address, FILTER_SANITIZE_STRING);
                $job->longitude = filter_var($longitude, FILTER_SANITIZE_STRING);
                $job->latitude = filter_var($latitude, FILTER_SANITIZE_STRING);
                $path = 'uploads/jobs/' . $current_user;
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }
                $job_attachments = array();
                if (!empty($size)) {
                    for ($x = 0; $x < $size; $x++) {
                        $attachments = $request['attachments' . $x];
                        $file_original_name = time() . '-' . $attachments->getClientOriginalName();
                        Storage::disk('local')->putFileAs(
                            $path,
                            $attachments,
                            $file_original_name
                        );
                        $job_attachments[] = $file_original_name;
                    }
                }
                $job->attachments = serialize($job_attachments);
                $job->code = $code;
                $job->save();
                $job_id = $job->id;
                $skills = $request['skills'];
                $job->skills()->detach();
                if (!empty($skills)) {
                    foreach ($skills as $skill) {
                        $job->skills()->attach($skill);
                    }
                }
                $job = JobJob::find($job_id);
                $languages = $request['languages'];
                $job->languages()->sync($languages);
                $categories = $request['categories'];
                $job->categories()->sync($categories);
                $email_settings = JobSiteManagement::getMetaValue('settings');
                // Send Email
                $user = User::find($current_user);
                //send email to admin
                if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                    $job = JobJob::where('user_id', $current_user)->latest()->first();
                    $email_params = array();
                    $new_posted_job_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_new_job_posted')->get()->first();
                    $new_posted_job_template_employer = DB::table('email_types')->select('id')->where('email_type', 'employer_email_new_job_posted')->get()->first();
                    if (!empty($new_posted_job_template->id) || !empty(new_posted_job_template_employer)) {
                        $template_data = EmailTemplate::getEmailTemplateByID($new_posted_job_template->id);
                        $template_data_employer = EmailTemplate::getEmailTemplateByID($new_posted_job_template_employer->id);
                        $email_params['job_title'] = $job->title;
                        $email_params['posted_job_link'] = url('/job/' . $job->slug);
                        $email_params['name'] = JobHelper::getUserName($current_user);
                        $email_params['link'] = url('Job/profile/' . $user->slug);
                        $admin_mail = User::role('admin')->select('email')->pluck('email')->first();
                        Mail::to(config('mail.username'))
                            ->send(
                                new AdminEmailMailable(
                                    'admin_email_new_job_posted',
                                    $template_data,
                                    $email_params
                                )
                            );
                        if (!empty($user->email)) {
                            Mail::to($user->email)
                                ->send(
                                    new EmployerEmailMailable(
                                        'employer_email_new_job_posted',
                                        $template_data_employer,
                                        $email_params
                                    )
                                );
                        }
                    }
                }
            }
            $json['type'] = 'success';
            return Response::json($json, 200);
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.need_to_purchase_pkg');
            return Response::json($json, 203);
        }
    }
}
