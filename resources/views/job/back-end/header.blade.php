@if (Schema::hasTable('pages') || Schema::hasTable('site_managements'))
    @php
        $get_switching=Session::get('get_swithcing');
        $settings = array();
        $pages = App\Page::all();
        $setting = \App\JobModel\JobSiteManagement::getMetaValue('settings');
        $logo = !empty($setting[0]['logo']) ? Helper::getHeaderLogo($setting[0]['logo']) : '/images/logo.png';
        $inner_header = !empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' ? 'wt-headervtwo' : '';
    @endphp
@endif
@php
     if(Auth::user()->hasRole('admin')){
        Auth::user()->syncRoles('admin');
    }
   elseif($get_switching=='selling'){
         Auth::user()->syncRoles('candidate');
    }elseif($get_switching=='buying'){
        Auth::user()->syncRoles('job_employer');
    }
    else{
        Auth::user()->syncRoles('candidate');
    }
    
    
@endphp
<header id="wt-header" class="wt-header wt-haslayout {{$inner_header}}">
    <div class="wt-navigationarea">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @auth
                        {{ Helper::displayEmailWarning() }}
                    @endauth
                    @if (!empty($logo) || Schema::hasTable('site_managements'))
                        <strong class="wt-logo"><a href="{{{ url('/') }}}"><img src="{{{ asset($logo) }}}" alt="{{{ trans('Logo') }}}"></a></strong>
                    @endif
                    @if (!empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' && Route::getCurrentRoute()->uri() != 'home')
                        <search-form
                        :placeholder="'{{ trans('lang.looking_for') }}'"
                        :freelancer_placeholder="'{{ trans('lang.search_filter_list.candidate') }}'"
                        :employer_placeholder="'{{ trans('lang.search_filter_list.company') }}'"
                        :job_placeholder="'{{ trans('lang.search_filter_list.circular') }}'"
                        :no_record_message="'{{ trans('lang.no_record') }}'"
                        >
                        </search-form>
                    @endif
                    <div class="wt-rightarea">
                        <nav id="wt-nav" class="wt-nav navbar-expand-lg">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="lnr lnr-menu"></i>
                            </button>
                            <div class="collapse navbar-collapse wt-navigation" id="navbarNav">
                                <ul class="navbar-nav">
                                    @if (!empty($pages) || Schema::hasTable('pages'))
                                        @foreach ($pages as $key => $page)
                                            @php
                                                $page_has_child = App\Page::pageHasChild($page->id); $pageID = Request::segment(2);
                                                $show_page = \App\JobModel\JobSiteManagement::where('meta_key', 'show-page-'.$page->id)->select('meta_value')->pluck('meta_value')->first();
                                            @endphp
                                            @if ($page->relation_type == 0 && $show_page == 'true')
                                                <li class="{{!empty($page_has_child) ? 'menu-item-has-children page_item_has_children' : '' }} @if ($pageID == $page->slug ) current-menu-item @endif">
                                                    <a href="{{url('page/'.$page->slug)}}">{{{$page->title}}}</a>
                                                    @if (!empty($page_has_child))
                                                        <ul class="sub-menu">
                                                            @foreach($page_has_child as $parent)
                                                                @php $child = App\Page::getChildPages($parent->child_id);@endphp
                                                                <li class="@if ($pageID == $child->slug ) current-menu-item @endif">
                                                                    <a href="{{url('page/'.$child->slug.'/')}}">
                                                                        {{{$child->title}}}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                    <li>
                                        <a href="{{url('search-results?type=freelancer')}}">
                                            {{{ trans('lang.view_candidate') }}}
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="{{url('search-results?type=job_employer')}}">
                                            {{{ trans('lang.view_company') }}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('search-results?type=job')}}">
                                            {{{ trans('lang.browse_circular') }}}
                                        </a>
                                    </li>
                                    @if(!Auth::user()->hasRole('admin'))
                                     <li>
                                        <a href="{{url('switch_to/'.'buying/'.'job')}}">{{{ trans('lang.switch to company')}}}</a>
                                    </li>
                                    <li>
                                        <a href="{{url('switch_to/'.'selling/'.'job')}}">{{{ trans('lang.switch to candidate')}}}</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </nav>

                        @auth
                            @php
                                $user = !empty(Auth::user()) ? Auth::user() : '';
                                $role = !empty($user) ? $user->getRoleNames()->first() : array();
                                $profile = \App\User::find($user->id)->profile;
                                $user_image = !empty($profile) ? $profile->avater : '';
                                $employer_job = \App\JobModel\JobJob::select('status')->where('user_id', Auth::user()->id)->first();
                                $profile_image = !empty($user_image) ? '/uploads/users/'.$user->id.'/'.$user_image : 'images/user-login.png';
                            @endphp
                                <div class="wt-userlogedin">
                                    <figure class="wt-userimg">
                                        <img src="{{{ asset($profile_image) }}}" alt="{{{ trans('lang.user_avatar') }}}">
                                    </figure>
                                    <div class="wt-username">
                                        <h3>{{{ Helper::getUserName(Auth::user()->id) }}}</h3>
                                        <span>{{{ !empty(Auth::user()->job_profile->tagline) ? str_limit(Auth::user()->job_profile->tagline, 26, '') : Auth::user()->getRoleNames()->first() }}}</span>
                                    </div>
                                    @include('job.back-end.includes.profile-menu')
                                </div>
                        @endauth
                        @if (!empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' && Route::getCurrentRoute()->uri() != 'home')
                            <div class="wt-respsonsive-search"><a href="javascript:;" class="wt-searchbtn"><i class="fa fa-search"></i></a></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
