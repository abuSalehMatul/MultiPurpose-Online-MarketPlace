@extends('coupon.layouts.admin')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text">Site Settings</h4>
    @if ($general_settings)
      {!! Form::model($general_settings, ['method' => 'PATCH', 'action' => ['SettingsController@general_update', $general_settings->id], 'files' => true]) !!}
        <div class="row admin-form-block z-depth-1">
          <h6 class="admin-form-text" style="margin-bottom: 20px;">General Settings</h6>
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('w_name') ? ' has-error' : '' }}">
                {!! Form::label('w_name', 'Project Name') !!}
                <p class="inline info"> - Please enter your website name</p>
                {!! Form::text('w_name', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('w_name') }}</small>
            </div>
            <div class="form-group{{ $errors->has('w_title') ? ' has-error' : '' }}">
              {!! Form::label('w_title', 'Website Title') !!}
                <p class="inline info"> - Please enter your website Title</p>              
              {!! Form::text('w_title', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('w_title') }}</small>
            </div>
            <div class="form-group{{ $errors->has('w_email') ? ' has-error' : '' }}">
                {!! Form::label('w_email', 'Contact Email') !!}
                <p class="inline info"> - Please enter your website email</p>
                {!! Form::email('w_email', null, ['class' => 'form-control', 'placeholder' => 'eg: foo@bar.com']) !!}
                <small class="text-danger">{{ $errors->first('w_email') }}</small>
            </div>
            <div class="form-group{{ $errors->has('w_phone') ? ' has-error' : '' }}">
                {!! Form::label('w_phone', 'Contact Phone') !!}
                <p class="inline info"> - Please enter your contact number</p>
                {!! Form::text('w_phone', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('w_phone') }}</small>
            </div>
            <div class="form-group{{ $errors->has('w_address') ? ' has-error' : '' }}">
                {!! Form::label('w_address', 'Contact Address') !!}
                <p class="inline info"> - Please enter your contact address</p>
                {!! Form::text('w_address', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('w_address') }}</small>
            </div>
            <div class="form-group{{ $errors->has('w_time') ? ' has-error' : '' }}">
                {!! Form::label('w_time', 'Contact Time') !!}
                <p class="inline info"> - Please enter your contact timing</p>
                {!! Form::text('w_time', null, ['class' => 'form-control', 'placeholder' => 'eg: 10AM - 7PM']) !!}
                <small class="text-danger">{{ $errors->first('w_time') }}</small>
            </div>
             <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }} currency-symbol-block">
              {!! Form::label('currency', 'Currency') !!}
              <p class="inline info"> - Please select currency</p>
                <div class="input-group">
                  {!! Form::text('currency', null, ['class' => 'form-control currency-icon-picker']) !!}
                  <span class="input-group-addon simple-input"><i class="glyphicon glyphicon-menu-down"></i></span>
                </div>
              <small class="text-danger">{{ $errors->first('currency') }}</small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }} input-file-block">
                  {!! Form::label('logo', 'Website Logo') !!} - <p class="inline info">Max Size: 250*92</p>
                  {!! Form::file('logo', ['class' => 'input-file', 'id'=>'logo']) !!}
                  <label for="logo" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Website Logo">
                    <i class="icon fa fa-check"></i>
                    <span class="js-fileName">Choose a File</span>
                  </label>
                  <p class="info">Choose a logo</p>
                  <small class="text-danger">{{ $errors->first('logo') }}</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="image-block">
                  <img src="{{asset('coupon/images/'.$general_settings->logo)}}" class="img-responsive" alt="" width="150">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('favicon') ? ' has-error' : '' }} input-file-block">
                  {!! Form::label('favicon', 'Website favicon') !!} - <p class="inline info">Size: 32x32</p>
                  {!! Form::file('favicon', ['class' => 'input-file', 'id'=>'favicon']) !!}
                  <label for="favicon" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Website Favicon">
                    <i class="icon fa fa-check"></i>
                    <span class="js-fileName">Choose a File</span>
                  </label>
                  <p class="info">Choose a favicon</p>
                  <small class="text-danger">{{ $errors->first('favicon') }}</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="image-block">
                  <img src="{{asset('coupon/images/favicon/' . $general_settings->favicon)}}" class="img-responsive" alt="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('preloader') ? ' has-error' : '' }} input-file-block">
                  {!! Form::label('preloader', 'Website Preloader') !!} - <p class="inline info">Max Size: 250*92</p>
                  {!! Form::file('preloader', ['class' => 'input-file', 'id'=>'preloader']) !!}
                  <label for="preloader" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Website Preloader">
                    <i class="icon fa fa-check"></i>
                    <span class="js-fileName">Choose a File</span>
                  </label>
                  <p class="info">Choose a preloader</p>
                  <small class="text-danger">{{ $errors->first('preloader') }}</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="image-block">
                  <img src="{{asset('coupon/images/'.$general_settings->preloader)}}" class="img-responsive" alt="" width="150">
                </div>
              </div>
            </div>
             <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }}">
                {!! Form::label('keywords', 'Website Keywords') !!}
                <p class="inline info"> - Please enter keywords for SEO</p>
                {!! Form::text('keywords', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('keywords') }}</small>
            </div>
             <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }}">
                {!! Form::label('desc', 'Website Description') !!}
                <p class="inline info"> - Please enter website description</p>
                {!! Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 5]) !!}
                <small class="text-danger">{{ $errors->first('desc') }}</small>
            </div>
          </div>
          <div class="col-md-12"> 
            <button type="submit" class="btn btn-block btn-success">Save Settings</button>
            <div class="clear-both"></div>
          </div>
        </div>
        <div class="row admin-form-block z-depth-1">
          <div class="col-md-8">  
            <h6 class="admin-form-text" style="margin-bottom: 20px;">Footer Settings</h6>
          </div>          
          <div class="col-md-4" style="text-transform: uppercase;"> 
            <div class="bootstrap-checkbox form-group{{ $errors->has('footer_layout') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-md-7">
                  <h5 class="bootstrap-switch-label">Footer Layout</h5>
                </div>
                <div class="col-md-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('footer_layout', 1, ($general_settings->footer_layout == 1 ? true : false), ['class' => 'bootswitch', 'id' => 'FooterCheckBox', "data-on-text"=>"Layout 1", "data-off-text"=>"Layout 2", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('footer_layout') }}</small>
              </div>
            </div>
          </div>
          <div class="col-md-6">  
            <div class="row lay-one">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('footer_logo') ? ' has-error' : '' }} input-file-block">
                  {!! Form::label('footer_logo', 'Footer Logo') !!} - <p class="inline info">Size: 168x63</p>
                  {!! Form::file('footer_logo', ['class' => 'input-file', 'id'=>'footer_logo']) !!}
                  <label for="footer_logo" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Footer Logo">
                    <i class="icon fa fa-check"></i>
                    <span class="js-fileName">Choose a File</span>
                  </label>
                  <p class="info">Choose a logo</p>
                  <small class="text-danger">{{ $errors->first('footer_logo') }}</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="image-block">
                  <img src="{{asset('coupon/images/' . $general_settings->footer_logo)}}" class="img-responsive" alt="">
                </div>
              </div>
            </div>
            <div class="form-group{{ $errors->has('f_title1') ? ' has-error' : '' }} lay-zero">
              {!! Form::label('f_title1', 'Footer Widget 1 Title') !!}
              {!! Form::text('f_title1', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('f_title1') }}</small>
            </div>          
            <div class="form-group{{ $errors->has('f_title2') ? ' has-error' : '' }}">
              {!! Form::label('f_title2', 'Footer Widget 2 Title') !!}
              {!! Form::text('f_title2', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('f_title2') }}</small>
            </div>          
            <div class="form-group{{ $errors->has('f_title3') ? ' has-error' : '' }}">
              {!! Form::label('f_title3', 'Footer Widget 3 Title') !!}
              {!! Form::text('f_title3', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('f_title3') }}</small>
            </div>          
            <div class="form-group{{ $errors->has('f_title4') ? ' has-error' : '' }}">
              {!! Form::label('f_title4', 'Footer Widget 4 Title') !!}
              {!! Form::text('f_title4', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('f_title4') }}</small>
            </div>
            <div class="form-group{{ $errors->has('footer_text') ? ' has-error' : '' }} lay-one">
              {!! Form::label('footer_text', 'Footer Text') !!}
              <p class="inline info"> - Please enter footer 'About' text</p>
              {!! Form::textarea('footer_text', null, ['class' => 'form-control','rows' => 4]) !!}
              <small class="text-danger">{{ $errors->first('footer_text') }}</small>
            </div>
            <div class="form-group{{ $errors->has('copyright') ? ' has-error' : '' }}">
              {!! Form::label('copyright', 'Copyright Text') !!}
              <p class="inline info"> - Please enter copyright text</p>
              {!! Form::text('copyright', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('copyright') }}</small>
            </div>  
          </div>
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('m_text') ? ' has-error' : '' }}">
              {!! Form::label('m_text', 'Mailchimp Text') !!}
                <p class="inline info"> - Please enter about mailchimp</p>
              {!! Form::text('m_text', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('m_text') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('playstore_link') ? ' has-error' : '' }}">
              {!! Form::label('playstore_link', 'Playstore URL') !!}
                <p class="inline info"> - Please enter playstore url</p>
              {!! Form::text('playstore_link', null, ['class' => 'form-control', 'placeholder' => 'https://www.playstore.com/']) !!}
              <small class="text-danger">{{ $errors->first('playstore_link') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('app_link') ? ' has-error' : '' }}">
              {!! Form::label('app_link', 'App Store URL') !!}
                <p class="inline info"> - Please enter your app store url</p>
              {!! Form::text('app_link', null, ['class' => 'form-control', 'placeholder' => 'https://www.appstore.com/']) !!}
              <small class="text-danger">{{ $errors->first('app_link') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('is_mailchimp') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_mailchimp', 'Footer Mailchimp') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_mailchimp', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_mailchimp') }}</small>
              </div>
            </div>     
            <div class="form-group{{ $errors->has('is_playstore') ? ' has-error' : '' }} switch-main-block">
                <div class="row">
                  <div class="col-xs-4">
                    {!! Form::label('is_playstore', 'Footer Playstore Icon') !!}
                  </div>
                  <div class="col-xs-5 pad-0">
                    <label class="switch">                
                      {!! Form::checkbox('is_playstore', 1, null, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
                <div class="col-xs-12">
                  <small class="text-danger">{{ $errors->first('is_playstore') }}</small>
                </div>
            </div>
            <div class="form-group{{ $errors->has('is_app_icon') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_app_icon', 'Footer App Icon') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_app_icon', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_app_icon') }}</small>
              </div>
            </div> 
          </div>
          <div class="col-md-12"> 
            <button type="submit" class="btn btn-block btn-success">Save Settings</button>
            <div class="clear-both"></div>
          </div>
        </div>
        <div class="row admin-form-block z-depth-1">
          <h6 class="admin-form-text" style="margin-bottom: 20px;">Home Page</h6>
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('btn_title') ? ' has-error' : '' }}">
              {!! Form::label('btn_title', 'Home Banner Button Title') !!}
              <p class="inline info"> - Please enter home banner button name</p>
              {!! Form::text('btn_title', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('btn_title') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('btn_link') ? ' has-error' : '' }}">
                {!! Form::label('btn_link', 'Home Banner Button Link') !!}
              <p class="inline info"> - Please enter home banner button link</p>
                {!! Form::text('btn_link', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('btn_link') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('btn_title2') ? ' has-error' : '' }}">
                {!! Form::label('btn_title2', 'Home Banner Second Button Title') !!}
              <p class="inline info"> - Please enter home banner button name</p>
                {!! Form::text('btn_title2', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('btn_title2') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('btn_link2') ? ' has-error' : '' }}">
                {!! Form::label('btn_link2', 'Home Banner Second Button Link') !!}
              <p class="inline info"> - Please enter home banner button link</p>
                {!! Form::text('btn_link2', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('btn_link2') }}</small>
            </div> 
          </div>
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('is_feat_slider') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_feat_slider', 'Featured Slider') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_feat_slider', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_feat_slider') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('is_recent_deals') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_recent_deals', 'Recent Deals') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_recent_deals', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_recent_deals') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('is_category_block') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_category_block', 'Category Block') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_category_block', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_categorye_block') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('is_store_slider') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_store_slider', 'Store Slider') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_store_slider', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_store_slider') }}</small>
              </div>
            </div>    
            <div class="form-group{{ $errors->has('is_blog') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_blog', 'Recent Blogs') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_blog', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_blog') }}</small>
              </div>
            </div>
          </div>
          <div class="col-md-12"> 
            <button type="submit" class="btn btn-block btn-success">Save Settings</button>
            <div class="clear-both"></div>
          </div>
        </div>        
        <div class="row admin-form-block z-depth-1">
          <h6 class="admin-form-text" style="margin-bottom: 20px;">Other Settings</h6>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('navbar_img') ? ' has-error' : '' }} input-file-block">
                  {!! Form::label('navbar_img', 'Website Top Image') !!} - <p class="inline info">Size: 320*90</p>
                  {!! Form::file('navbar_img', ['class' => 'input-file', 'id'=>'navbar_img']) !!}
                  <label for="navbar_img" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Website Top Image">
                    <i class="icon fa fa-check"></i>
                    <span class="js-fileName">Choose a File</span>
                  </label>
                  <p class="info">Choose a website top Image</p>
                  <small class="text-danger">{{ $errors->first('navbar_img') }}</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="image-block">
                  <img src="{{asset('coupon/images/'.$general_settings->navbar_img)}}" class="img-responsive" alt="" width="150">
                </div>
              </div>
            </div>
            <div class="form-group{{ $errors->has('sidebar_abt') ? ' has-error' : '' }}">
                {!! Form::label('sidebar_abt', 'About Website For Sidebar') !!}
                <p class="inline info"> - Please enter website description</p>
                {!! Form::textarea('sidebar_abt', null, ['class' => 'form-control', 'rows' => 5]) !!}
                <small class="text-danger">{{ $errors->first('sidebar_abt') }}</small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('is_preloader') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_preloader', 'Preloader') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_preloader', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_preloader') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('is_gotop') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_gotop', 'Go To Top') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_gotop', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_gotop') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('inspect') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('inspect', 'Inspect Disable') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('inspect', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('inspect') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('right_click') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('right_click', 'Right Click Disable') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('right_click', 1, null, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('right_click') }}</small>
              </div>
            </div>
            <div class="bootstrap-checkbox form-group{{ $errors->has('blog_layout') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('blog_layout', 'Blog Layout') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('blog_layout', 1, ($general_settings->blog_layout == 1 ? true : false), ['class' => 'bootswitch', 'id' => 'BlogLayout', "data-on-text"=>"Layout 1", "data-off-text"=>"Layout 2", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('blog_layout') }}</small>
              </div>
            </div>
            <div class="bootstrap-checkbox form-group{{ $errors->has('blog_left') ? ' has-error' : '' }} blogleft">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('blog_left', 'Blog Sidebar') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('blog_left', 1, ($general_settings->blog_left == 1 ? true : false), ['class' => 'bootswitch', "data-on-text"=>"Left", "data-off-text"=>"Right", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('blog_left') }}</small>
              </div>
            </div>
          </div>
          <div class="col-md-12"> 
            <button type="submit" class="btn btn-block btn-success">Save Settings</button>
          </div>
        </div>
      {!! Form::close() !!}
    @endif
  </div>
@endsection
@section('custom-script')
  <script>
    $(document).ready(function () {
      var loadstate = $('#FooterCheckBox').bootstrapSwitch('state');
      if(loadstate == false){                                   
        $(".lay-zero").hide();
        $(".lay-one").show();
      }
      else{ 
        $(".lay-zero").show();
        $(".lay-one").hide();
      }
      $('#FooterCheckBox').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state == false){                                   
          $(".lay-zero").hide();
          $(".lay-one").show();
        }
        else{ 
          $(".lay-zero").show();
          $(".lay-one").hide();
        }
      });

      var blogstate = $('#BlogLayout').bootstrapSwitch('state');
      if(blogstate == false){                                  
        $(".blogright").show();
      }
      else{
        $(".blogright").hide();
      }
      $('#BlogLayout').on('switchChange.bootstrapSwitch', function (event, state) {
        if(state == false){                                  
          $(".blogleft").show();
        }
        else{
          $(".blogleft").hide();
        }
      });

      $('.currency-icon-picker').iconpicker({
        title: 'Currency Symbols',
        icons: ['fa fa-dollar', 'fa fa-euro', 'fa fa-gbp', 'fa fa-ils', 'fa fa-inr', 'fa fa-krw', 'fa fa-money', 'fa fa-rouble', 'fa fa-try'],
        selectedCustomClass: 'label label-primary',
        mustAccept: false,
        placement: 'topRight',
        showFooter: false,
        hideOnSelect: true
      });
    });
  </script>
@endsection
