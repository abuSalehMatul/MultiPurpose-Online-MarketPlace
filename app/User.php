<?php
/**
 * Class User.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use DB;
use App\Location;
use App\Profile;
use App\ProModel\ProLocation;
use App\ProModel\ProProfile;
use App\JobModel\JobLocation;
use App\JobModel\JobProfile;
use Auth;
use App\Package;
use App\Helper;
use App\ProModel\ProPackage;
use App\ProModel\ProHelper;
use App\JobModel\JobPackage;
use App\JobModel\JobHelper;
use App\Job;
use Carbon\Carbon;
use canResetPassword;
use App\Notifications;
use Event;

/**
 * Class User
 *
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'slug', 'email', 'password',
        'avatar', 'banner', 'tagline', 'description',
        'location_id', 'verification_code', 'address',
        'longitude', 'latitude'
    ];

    /**
     * For creating event.
     *
     * @return event
     */
    public static function boot()
    {
        parent::boot();
        static::created(
            function ($user) {
                Event::fire('user.created', $user);
            }
        );
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The skills that belong to the user.
     *
     * @return relation
     */
    public function skills()
    {
        return $this->belongsToMany('App\Skill')->withPivot('skill_rating');
    }
    public function pro_skills()
    {
        return $this->belongsToMany('App\ProModel\ProSkill')->withPivot('skill_rating');
    }
    public function job_skills()
    {
        return $this->belongsToMany('App\JobModel\JobSkill')->withPivot('skill_rating');
    }

    /**
     * Get all of the categories for the user.
     *
     * @return relation
     */
    public function categories()
    {
        return $this->morphToMany('App\Category', 'catable');
    }
    public function pro_categories()
    {
        return $this->morphToMany('App\ProModel\ProCategory', 'catable');
    }
    public function job_categories()
    {
        return $this->morphToMany('App\JobModel\JobCategory', 'catable');
    }

    /**
     * Get all of the languages for the user.
     *
     * @return relation
     */
    public function languages()
    {
        return $this->morphToMany('App\Language', 'langable');
    }

    /**
     * Get the location that owns the user.
     *
     * @return relation
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }
    public function pro_location()
    {
        return $this->belongsTo('App\ProModel\ProLocation');
    }
    public function job_location()
    {
        return $this->belongsTo('App\JobModel\JobLocation');
    }

    /**
     * Get the profile record associated with the user.
     *
     * @return relation
     */
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
    public function pro_profile()
    {
        return $this->hasOne('App\ProModel\ProProfile');
    }
    public function job_profile()
    {
        return $this->hasOne('App\JobModel\JobProfile');
    }

    /**
     * Get the payout record associated with the user.
     *
     * @return relation
     */
    public function payout()
    {
        return $this->hasOne('App\Payout');
    }

    /**
     * Get the jobs for the employer.
     *
     * @return relation
     */
    public function jobs()
    {
        return $this->hasMany('App\Job');
    }
    public function pro_jobs()
    {
        return $this->hasMany('App\ProModel\ProJob');
    }
    public function job_jobs()
    {
        return $this->hasMany('App\JobModel\JobJob');
    }

    /**
     * Get the proposals for the freelancer.
     *
     * @return relation
     */
    public function proposals()
    {
        return $this->hasMany('App\Proposal', 'freelancer_id');
    }
    public function pro_proposals()
    {
        return $this->hasMany('App\ProModel\ProProposal', 'freelancer_id');
    }
    public function job_proposals()
    {
        return $this->hasMany('App\JobModel\JobProposal', 'freelancer_id');
    }

    /**
     * Get the reviews for the user.
     *
     * @return relation
     */
    public function reviews()
    {
        return $this->hasMany('App\Review', 'user_id');
    }

    /**
     * Get the user that owns the offer.
     *
     * @return offers
     */
    public function offers()
    {
        return $this->hasOne('App\Offer');
    }
    public function pro_offers()
    {
        return $this->hasOne('App\ProModel\ProOffer');
    }
    public function job_offers()
    {
        return $this->hasOne('App\JobModel\JobOffer');
    }

    /**
     * Get all of reported employers.
     *
     * @return relation
     */
    public function reports()
    {
        return $this->morphMany('App\Report', 'reportable');
    }
    public function pro_reports()
    {
        return $this->morphMany('App\ProModel\ProReport', 'reportable');
    }
    public function job_reports()
    {
        return $this->morphMany('App\JobModel\JobReport', 'reportable');
    }

    /**
     * Get the message for the user.
     *
     * @return relation
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    /**
     * Get the item record associated with the user.
     *
     * @return relation
     */
    public function item()
    {
        return $this->hasMany('App\item', 'subscriber');
    }
    public function pro_item()
    {
        return $this->hasMany('App\ProModel\Proitem', 'subscriber');
    }
    public function job_item()
    {
        return $this->hasMany('App\JobModel\Jobitem', 'subscriber');
    }

    /**
     * Set slug before saving in DB
     *
     * @param string $value value
     *
     * @access public
     *
     * @return string
     */
    public function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $temp = str_slug($value, '-');
            if (!User::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!User::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp . '-' . $i;
                }
                $temp = $new_slug;
            }
            $this->attributes['slug'] = $temp;
        }
    }

    /**
     * Store user
     *
     * @param \Illuminate\Http\Request $request           code
     * @param code                     $verification_code verification code
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function storeUser($request, $verification_code)
    {
        if (!empty($request)) {
            $this->first_name = filter_var($request['first_name'], FILTER_SANITIZE_STRING);
            $this->last_name = filter_var($request['last_name'], FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request['first_name'], FILTER_SANITIZE_STRING) . '-' .
                filter_var($request['last_name'], FILTER_SANITIZE_STRING);
            $this->email = filter_var($request['email'], FILTER_VALIDATE_EMAIL);
            $this->password = Hash::make($request['password']);
            $this->verification_code = $verification_code;
            $this->user_verified = 0;
            $this->assignRole($request['role']);
            if (!empty($request['locations'])) {
                $location = Location::find($request['locations']);
                $this->location()->associate($location);
            }
            $this->badge_id = null;
            $this->expiry_date = null;
            $this->save();
            $user_id = $this->id;
            $profile = new Profile();
            $profile->user()->associate($user_id);
            if (!empty($request['employees'])) {
                $profile->no_of_employees = intval($request['employees']);
            }
            if (!empty($request['department_name'])) {
                $department = Department::find($request['department_name']);
                $profile->department()->associate($department);
            }
            $profile->save();
            $role_id = Helper::getRoleByUserID($user_id);
            $package = Package::select('id', 'title', 'cost')->where('role_id', $role_id)->where('trial', 1)->get()->first();
            $trial_invoice = Invoice::select('id')->where('type', 'trial')->get()->first();
            if (!empty($package) && !empty($trial_invoice)) {
                DB::table('items')->insert(
                    [
                        'invoice_id' => $trial_invoice->id, 'product_id' => $package->id, 'subscriber' => $user_id,
                        'item_name' => $package->title, 'item_price' => $package->cost, 'item_qty' => 1,
                        "created_at" => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()
                    ]
                );
            }
            return $user_id;
        }
    }

    /**
     * Get user role type by user ID
     *
     * @param integer $user_id code
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public static function getUserRoleType($user_id)
    {
        if (!empty($user_id) && is_numeric($user_id)) {
            $role_id = DB::table('model_has_roles')->select('role_id')->where('model_id', $user_id)
                ->get()->pluck('role_id')->toArray();
            if (!empty($role_id)) {
                return DB::table('roles')->select('id', 'role_type', 'name')->where('id', $role_id[0])->get()->first();
            } else {
                return '';
            }
        }
    }

    /**
     * Get search results
     *
     * @param integer $type                   type
     * @param integer $keyword                keyword
     * @param integer $search_locations       search_locations
     * @param integer $search_employees       search_employees
     * @param integer $search_skills          search_skills
     * @param integer $search_hourly_rates    search_hourly_rates
     * @param integer $search_freelaner_types search_freelaner_types
     * @param integer $search_english_levels  search_english_levels
     * @param integer $search_languages       search_languages
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public static function getSearchResult(
        $type,
        $keyword,
        $search_locations,
        $search_employees,
        $search_skills,
        $search_hourly_rates,
        $search_freelaner_types,
        $search_english_levels,
        $search_languages
    ) {
        $json = array();
        $user_id = array();
        // print_r( $type);
        // exit();
        $user_by_role =  User::role($type)->select('id')->get()->pluck('id')->toArray();
      //  return $user_by_role;
        $users = !empty($user_by_role) ? User::whereIn('id', $user_by_role) : array();
        $filters = array();
        if (!empty($users)) {
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
                $locations = Location::select('id')->whereIn('slug', $search_locations)
                    ->get()->pluck('id')->toArray();
                if($type=='pro'){
                    $locations = ProLocation::select('id')->whereIn('slug', $search_locations)
                        ->get()->pluck('id')->toArray();
                }elseif($type=='candidate'){
                    $locations = JobLocation::select('id')->whereIn('slug', $search_locations)
                        ->get()->pluck('id')->toArray();
                }
               
                $users->whereIn('location_id', $locations);
            }
            if (!empty($search_employees)) {
                $filters['employees'] = $search_employees;
                $employees = Profile::whereIn('no_of_employees', $search_employees)->get();
                if($type=='pro'){
                    $employees = ProProfile::whereIn('no_of_employees', $search_employees)->get();
                }elseif($type=='candidate'){
                    $employees = JobProfile::whereIn('no_of_employees', $search_employees)->get();
                }
               
                foreach ($employees as $key => $employee) {
                    if (!empty($employee->user_id)) {
                        $user_id[] = $employee->user_id;
                    }
                }
                $users->whereIn('id', $user_id)->get();
            }
            if (!empty($search_skills)) {
                $filters['skills'] = $search_skills;

                $skills = Skill::whereIn('slug', $search_skills)->get();
                if($type=='pro'){
                    $skills = ProSkill::whereIn('slug', $search_skills)->get();
                }elseif($type=='candidate'){
                    $skills = JobSkill::whereIn('slug', $search_skills)->get();
                }
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
                    $user_id = Profile::select('user_id')->whereIn('user_id', $user_by_role)
                        ->whereBetween('hourly_rate', [$min, $max])->get()->pluck('user_id')->toArray();
                    if($type=='pro'){
                        $user_id = ProProfile::select('user_id')->whereIn('user_id', $user_by_role)
                            ->whereBetween('hourly_rate', [$min, $max])->get()->pluck('user_id')->toArray();
                    }elseif($type=='candidate'){
                        $user_id = JobProfile::select('user_id')->whereIn('user_id', $user_by_role)
                            ->whereBetween('hourly_rate', [$min, $max])->get()->pluck('user_id')->toArray();
                    } 
                }
                $users->whereIn('id', $user_id);
            }
            if (!empty($search_freelaner_types)) {
                $filters['freelaner_type'] = $search_freelaner_types;
                $freelancers = Profile::whereIn('freelancer_type', $search_freelaner_types)->get();
                if($type=='pro'){
                    $freelancers = ProProfile::whereIn('freelancer_type', $search_freelaner_types)->get();
                }elseif($type=='candidate'){
                    $freelancers = JobProfile::whereIn('freelancer_type', $search_freelaner_types)->get();
                }
                foreach ($freelancers as $key => $freelancer) {
                    if (!empty($freelancer->user_id)) {
                        $user_id[] = $freelancer->user_id;
                    }
                }
                $users->whereIn('id', $user_id)->get();
            }
            if (!empty($search_english_levels)) {
                $filters['english_level'] = $search_english_levels;
                $freelancers = Profile::whereIn('english_level', $search_english_levels)->get();
                if($type=='pro'){
                    $freelancers = ProProfile::whereIn('english_level', $search_english_levels)->get();
                }elseif($type=='candidate'){
                    $freelancers = JobProfile::whereIn('english_level', $search_english_levels)->get();
                }
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
            if ($type = 'freelancer' || $type=='pro' || $type=='candidate') {
                $users = $users->orderByRaw('-badge_id DESC')->orderBy('expiry_date', 'DESC');
            } else {
                $users = $users->orderBy('created_at', 'DESC');
            }
            $users = $users->paginate(8)->setPath('');
        }
        foreach ($filters as $key => $filter) {
            $pagination = $users->appends(
                array(
                    $key => $filter
                )
            );
        }
        $json['users'] = $users;
        return $json;
    }

    /**
     * Save dispute.
     *
     * @param string $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function saveDispute($request)
    {
        $user = User::find(Auth::user()->id);
        DB::table('disputes')->insert(
            [
                'proposal_id' => $request['proposal_id'], 'user_id' => $user->id,
                'reason' => $request['reason'], 'description' => $request['description'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        return 'success';
    }

    //coupon.................
    public function followers()
    {
        return $this->belongsToMany(User::class, 'coupon_followers', 'leader_id', 'follower_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'coupon_followers', 'follower_id', 'leader_id')->withTimestamps();
    }

    public function coupon()
    {
        return $this->hasMany('App\Coupon');
    }
    public function discussion()
    {
        return $this->hasMany('App\Discussion');
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    //learn user....................................................................

    public function deposit()
    {
        return $this->hasMany('App\Model\Deposit', 'user_id');
    }

    public function wallets()
    {
        return $this->hasMany('App\Model\Wallet', 'user_id')->default();
    }
}
