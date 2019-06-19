<?php

namespace App\Http\Controllers;

use App\Match;
use App\PlanLog;
use App\PricingPlan;
use App\Trx;
use App\Wallet;
use App\WithdrawLog;
use App\WithdrawMethod;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Session;
use Image;
use App\Gateway;
use App\GeneralSettings;
use App\Deposit;


use App\BetInvest;
use App\BetOption;
use App\BetQuestion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }



}
