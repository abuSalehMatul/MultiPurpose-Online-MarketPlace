<?php

/**
 * Class StripeController
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @version <PHP: 1.0.0>
 * @link    http://www.amentotech.com
 */
namespace App\Http\Controllers\Pro;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;
use App\ProModel\ProProposal;
use App\ProModel\ProJob;
use Auth;
use App\Invoice;
use DB;
use App\ProModel\ProPackage;
use Illuminate\Support\Facades\Mail;
use App\EmailTemplate;
use App\Mail\FreelancerEmailMailable;
use App\Mail\EmployerEmailMailable;
use App\ProModel\ProHelper;
use App\ProModel\ProItem;
use Carbon\Carbon;
use App\Message;

/**
 * Class StripeController
 *
 */
class ProStripeController extends Controller
{
    /**
     * Show the application paywith stripe.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithStripe()
    {
        return view('pro.back-end.paymentstripe');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithStripe(Request $request)
    {
        $current_year = Carbon::now()->format('Y');
        $validator = Validator::make(
            $request->all(),
            [
                'card_no' => 'required',
                'ccExpiryMonth' => 'required',
                'ccExpiryYear' => 'required',
                'cvvNumber' => 'required',
            ]
        );
        if ($request['ccExpiryYear'] < $current_year) {
            // Session::flash('error', trans('lang.valid_year'));
            // return Redirect::back()->withInput();
            $json['type'] = 'error';
            $json['message'] = trans('lang.valid_year');
            return $json;
        }
        $product_id = Session::has('product_id') ? session()->get('product_id') : '';
        $product_title = Session::has('product_title') ? session()->get('product_title') : '';
        $product_price = Session::has('product_price') ? session()->get('product_price') : 0;
        $type = Session::has('type') ? session()->get('type') : '';
        $user_id = Auth::user() ? Auth::user()->id : '';
        $input = $request->all();
        if ($validator->passes()) {
            $input = array_except($input, array('_token'));
            if (!empty(env('STRIPE_SECRET'))) {
                \Artisan::call('optimize:clear');
                $stripe = Stripe::make(env('STRIPE_SECRET'));
            } else {
                // Session::flash('error', trans('lang.empty_stripe_key'));
                // return Redirect::back();
                $json['type'] = 'error';
                $json['message'] = trans('lang.empty_stripe_key');
                return $json;
            }
            try {
                $token = $stripe->tokens()->create(
                    [
                        'card' => [
                            'number'    => $request->get('card_no'),
                            'exp_month' => $request->get('ccExpiryMonth'),
                            'exp_year'  => $request->get('ccExpiryYear'),
                            'cvc'       => $request->get('cvvNumber'),
                        ],
                    ]
                );
                if (!isset($token['id'])) {
                    // Session::flash('error', 'The Stripe Token was not generated correctly');
                    // return Redirect::back();
                    $json['type'] = 'error';
                    $json['message'] = 'The Stripe Token was not generated correctly';
                    return $json;
                }
                $payment_detail = $stripe->charges()->create(
                    [
                        'card' => $token['id'],
                        'currency' => 'USD',
                        'amount'   => $product_price,
                        'description' => trans('lang.add_in_wallet'),
                    ]
                );

                $customer = $stripe->customers()->create(
                    [
                        'email' => Auth::user()->email,
                    ]
                );

                if ($payment_detail['status'] == 'succeeded') {
                    $fee = !empty($payment_detail['application_fee_amount']) ? $payment_detail['application_fee_amount'] : 0;
                    $invoice = new Invoice();
                    $invoice->title = 'Invoice';
                    $invoice->price = $product_price;
                    $invoice->payer_name = filter_var($customer['name'], FILTER_SANITIZE_STRING);
                    $invoice->payer_email = filter_var($customer['email'], FILTER_SANITIZE_EMAIL);
                    $invoice->seller_email = 'test@email.com';
                    $invoice->currency_code = filter_var($payment_detail['currency'], FILTER_SANITIZE_STRING);
                    $invoice->payer_status = '';
                    $invoice->transaction_id = filter_var($payment_detail['id'], FILTER_SANITIZE_STRING);
                    $invoice->invoice_id = filter_var($payment_detail['source']['id'], FILTER_SANITIZE_STRING);
                    $invoice->customer_id = filter_var($customer['id'], FILTER_SANITIZE_STRING);
                    $invoice->shipping_amount = 0;
                    $invoice->handling_amount = 0;
                    $invoice->insurance_amount = 0;
                    $invoice->sales_tax = 0;
                    $invoice->payment_mode = filter_var('stripe', FILTER_SANITIZE_STRING);
                    $invoice->paypal_fee = $fee;
                    $invoice->paid = $payment_detail['paid'];
                    $product_type = $type;
                    $invoice->type = $product_type;
                    $invoice->save();
                    $invoice_id = DB::getPdo()->lastInsertId();
                    if ($type == 'package') {
                        $item = DB::table('pro_items')->select('id')->where('subscriber', $user_id)->first();
                        if (!empty($item)) {
                            $item = ProItem::find($item->id);
                        } else {
                            $item = new ProItem();
                        }
                    } else {
                        $item = new ProItem();
                    }
                    $item->invoice_id = filter_var($invoice_id, FILTER_SANITIZE_NUMBER_INT);
                    $item->product_id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);
                    $item->subscriber = $user_id;
                    $item->item_name = filter_var($product_title, FILTER_SANITIZE_STRING);
                    $item->item_price = $product_price;
                    $item->item_qty = filter_var(1, FILTER_SANITIZE_NUMBER_INT);
                    $item->save();
                    $last_order_id = session()->get('custom_order_id');
                    DB::table('orders')
                        ->where('id', $last_order_id)
                        ->update(['status' => 'completed']);
                    if (Auth::user()) {
                        if ($type == 'package') {
                            if (session()->has('product_id')) {
                                $package_item = \App\ProModel\ProItem::where('subscriber', $user_id)->first();
                                $id = session()->get('product_id');
                                $package = \App\ProModel\ProPackage::find($id);
                                $option = !empty($package->options) ? unserialize($package->options) : '';
                                $expiry = !empty($option) ? $package_item->created_at->addDays($option['duration']) : '';
                                $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
                                $user = \App\User::find($user_id);
                                if (!empty($package->badge_id) && $package->badge_id != 0) {
                                    $user->badge_id = $package->badge_id;
                                }
                                $user->expiry_date = $expiry_date;
                                $user->save();
                            }
                        } else if ($type == 'project') {
                            $proposal = ProProposal::find($product_id);
                            $proposal->hired = 1;
                            $proposal->status = 'hired';
                            $proposal->save();
                            $job = ProJob::find($proposal->job->id);
                            $job->status = 'hired';
                            $job->save();
                            // send message to freelancer
                            $message = new Message();
                            $user = User::find(intval(Auth::user()->id));
                            $message->user()->associate($user);
                            $message->receiver_id = intval($proposal->freelancer_id);
                            $message->body = trans('lang.hire_for'). ' ' .$job->title. ' ' .trans('lang.project');
                            $message->status = 0;
                            $message->save();
                        }
                    }
                    // send mail
                    if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                        if ($product_type == 'project') {
                            $proposal =  ProProposal::find($product_id);
                            $job = \App\ProModel\ProJob::find($proposal->job->id);
                            $freelancer = User::find($proposal->freelancer_id);
                            $employer = User::find($job->user_id);
                            if (!empty($freelancer->email)) {
                                $email_params = array();
                                $template = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_hire_freelancer')->get()->first();
                                if (!empty($template->id)) {
                                    $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                                    $email_params['project_title'] = $job->title;
                                    $email_params['hired_project_link'] = url('Pro/job/' . $job->slug);
                                    $email_params['name'] = ProHelper::getUserName($freelancer->id);
                                    $email_params['link'] = url('Pro/profile/' . $freelancer->slug);
                                    $email_params['employer_profile'] = url('Pro/profile/' . $employer->slug);
                                    $email_params['emp_name'] = ProHelper::getUserName($employer->id);
                                    Mail::to($freelancer->email)
                                        ->send(
                                            new FreelancerEmailMailable(
                                                'freelancer_email_hire_freelancer',
                                                $template_data,
                                                $email_params
                                            )
                                        );
                                }
                            }
                        } elseif ($product_type == 'package') {
                            $id = $product_id;
                            $item = DB::table('pro_items')->where('product_id', $id)->get()->toArray();
                            $package =  ProPackage::where('id', $item[0]->product_id)->first();
                            $user = User::find($item[0]->subscriber);
                            $role = $user->getRoleNames()->first();
                            $package_options = unserialize($package->options);
                            if (!empty($invoice)) {
                                if ($package_options['duration'] === 'Quarter') {
                                    $expiry_date = $invoice->created_at->addDays(4);
                                } elseif ($package_options['duration'] === 'Month') {
                                    $expiry_date = $invoice->created_at->addMonths(1);
                                } elseif ($package_options['duration'] === 'Year') {
                                    $expiry_date = $invoice->created_at->addYears(1);
                                }
                            }
                            if ($role === 'employer') {
                                if (!empty($user->email)) {
                                    $email_params = array();
                                    $template = DB::table('email_types')->select('id')->where('email_type', 'employer_email_package_subscribed')->get()->first();
                                    if (!empty($template->id)) {
                                        $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                                        $email_params['employer'] = ProHelper::getUserName($user_id);
                                        $email_params['employer_profile'] = url('Pro/profile/' . Auth::user()->slug);
                                        $email_params['name'] = $package->title;
                                        $email_params['price'] = $package->cost;
                                        $email_params['expiry_date'] = !empty($expiry_date) ? Carbon::parse($expiry_date)->format('M d, Y') : '';
                                        Mail::to(Auth::user()->email)
                                            ->send(
                                                new EmployerEmailMailable(
                                                    'employer_email_package_subscribed',
                                                    $template_data,
                                                    $email_params
                                                )
                                            );
                                    }
                                }
                            } elseif ($role === 'freelancer') {
                                if (!empty(Auth::user()->email)) {
                                    $email_params = array();
                                    $template = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_package_subscribed')->get()->first();
                                    if (!empty($template->id)) {
                                        $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                                        $email_params['freelancer'] = ProHelper::getUserName($user_id);
                                        $email_params['freelancer_profile'] = url('Pro/profile/' .  Auth::user()->slug);
                                        $email_params['name'] = $package->title;
                                        $email_params['price'] = $package->cost;
                                        $email_params['expiry_date'] = !empty($expiry_date) ? Carbon::parse($expiry_date)->format('M d, Y') : '';
                                        Mail::to(Auth::user()->email)
                                            ->send(
                                                new FreelancerEmailMailable(
                                                    'freelancer_email_package_subscribed',
                                                    $template_data,
                                                    $email_params
                                                )
                                            );
                                    }
                                }
                            }
                        }
                    }
                    /**
                     * Write Here Your Database insert logic.
                     */
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.money_not_add');
                    return $json;
                }
            } catch (Exception $e) {
                $json['type'] = 'error';
                $json['message'] = $e->getMessage();
                return $json;
            } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
                $json['type'] = 'error';
                $json['message'] = $e->getMessage();
                return $json;
            } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                $json['type'] = 'error';
                $json['message'] = $e->getMessage();
                return $json;
            }
        }
        session()->forget('product_id');
        session()->forget('product_title');
        session()->forget('product_price');
        session()->forget('custom_order_id');
        if (Auth::user()->getRoleNames()[0] == "employer") {
            if ($type == 'project') {
                $json['type'] = 'success';
                $json['message'] = trans('lang.freelancer_successfully_hired');
                $json['url'] = url('employer/jobs/hired');
                return $json;
            } else {
                $json['type'] = 'success';
                $json['message'] = trans('lang.thanks_subscription');
                $json['url'] = url('dashboard/packages/employer');
                return $json;
            }
        } else if (Auth::user()->getRoleNames()[0] == "freelancer") {
            $json['type'] = 'success';
            $json['message'] = trans('lang.thanks_subscription');
            $json['url'] = url('dashboard/packages/freelancer');
            return $json;
        }
    }
}
