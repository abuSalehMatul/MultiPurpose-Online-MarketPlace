@extends('coupon.layouts.admin', [
  'page_header' => 'Admin'
])

@section('content')
  <div class="content-main-block mrg-t-40">
  	<h4 class="admin-form-text">Dashboard</h4>
    <div class="row">
    	<div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/user')}}" class="small-box z-depth-1 hoverable bg-aqua default-color">
          <div class="inner">
            <h3>{{$users_count}}</h3>
            <p>Total Users</p>
          </div>
          <div class="icon">
            <i class="material-icons">people_outline</i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/category')}}" class="small-box z-depth-1 hoverable bg-red danger-color">
          <div class="inner">
            <h3>{{$category_count}}</h3>
            <p>Total Category</p>
          </div>
          <div class="icon">
            <i class="material-icons">card_membership</i>
          </div>
        </a>
      </div>      
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/store')}}" class="small-box z-depth-1 hoverable bg-green warning-color">
          <div class="inner">
            <h3>{{$store_count}}</h3>
            <p>Total Store</p>
          </div>
          <div class="icon">
            <i class="material-icons">card_giftcard</i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/coupon')}}" class="small-box z-depth-1 hoverable bg-green success-color">
          <div class="inner">
            <h3>{{$coupon_count}}</h3>
            <p>Total Coupons</p>
          </div>
          <div class="icon">
            <i class="material-icons">monetization_on</i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/coupon')}}" class="small-box z-depth-1 hoverable bg-yellow secondary-color">
          <div class="inner">
            <h3>{{$deal_count}}</h3>
            <p>Total Deals</p>
          </div>
          <div class="icon">
            <i class="material-icons">flight</i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/discussion')}}" class="small-box z-depth-1 hoverable bg-aqua pink darken-2">
          <div class="inner">
            <h3>{{$discussion_count}}</h3>
            <p>Total Discussion</p>
          </div>
          <div class="icon">
            <i class="material-icons">attach_money</i>
          </div>
        </a>
      </div>
    </div>
  </div>
@endsection
