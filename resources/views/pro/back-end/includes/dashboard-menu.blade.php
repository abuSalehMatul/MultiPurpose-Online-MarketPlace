@auth
    <div id="wt-sidebarwrapper" class="wt-sidebarwrapper">
        <div id="wt-btnmenutoggle" class="wt-btnmenutoggle">
            <span class="menu-icon">
                <em></em>
                <em></em>
                <em></em>
            </span>
        </div>
        @php
            $user = !empty(Auth::user()) ? Auth::user() : '';
            $role = !empty($user) ? $user->getRoleNames()->first() : array();
            $profile = \App\User::find($user->id)->profile;
            $setting = \App\ProModel\ProSiteManagement::getMetaValue('footer_settings');
            $copyright = !empty($setting) ? $setting['copyright'] : 'Worketic All Rights Reserved';
        @endphp
        <div id="wt-verticalscrollbar" class="wt-verticalscrollbar">
            <div class="wt-companysdetails wt-usersidebar">
                <figure class="wt-companysimg">
                    <img src="{{{ asset(Helper::getUserProfileBanner($user->id, 'small')) }}}" alt="{{{ trans('lang.profile_banner') }}}">
                </figure>
                <div class="wt-companysinfo">
                    <figure><img src="{{{ asset(Helper::getProfileImage($user->id)) }}}" alt="{{{ trans('lang.profile_photo') }}}"></figure>
                    <div class="wt-title">
                        <h2>
                            <a href="{{{ $role != 'admin' ? url('Pro/'.$role.'/dashboard') : 'javascript:void()' }}}">
                                {{{ !empty(Auth::user()) ? Helper::getUserName(Auth::user()->id) : 'No Name' }}}
                            </a>
                        </h2>
                        <span>{{{ !empty(Auth::user()->pro_profile->tagline) ? str_limit(Auth::user()->pro_profile->tagline, 26, '') : Auth::user()->getRoleNames()->first() }}}</span>
                    </div>
                    @if ($role === 'employer'  || $role=='admin')
                        <div class="wt-btnarea"><a href="{{{ url(route('pro_employerPostJob')) }}}" class="wt-btn">{{{ trans('lang.post_job') }}}</a></div>
                    @elseif ($role === 'pro' || $role=='admin')
                        <div class="wt-btnarea"><a href="{{{ url(route('pro_showUserProfile', ['slug' => Auth::user()->slug])) }}}" class="wt-btn">{{{ trans('lang.view_profile') }}}</a></div>
                    @endif
                </div>
            </div>
            <nav id="wt-navdashboard" class="wt-navdashboard">
                <ul>
                    @if ($role === 'admin')
                        <li>
                            <a href="{{{ route('pro_allJobs') }}}">
                                <i class="ti-briefcase"></i>
                                <span>{{ trans('lang.all_jobs') }}</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{{ route('pro_reviewOptions') }}}">
                                <i class="ti-check-box"></i>
                                <span>{{ trans('lang.review_options') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('pro_userListing') }}}">
                                <i class="ti-user"></i>
                                <span>{{ trans('lang.manage_users') }}</span>
                            </a>
                        </li> --}}
                        {{-- <li>
                            <a href="{{{ route('pro_emailTemplates') }}}">
                                <i class="ti-email"></i>
                                <span>{{ trans('lang.email_templates') }}</span>
                            </a>
                        </li> --}}
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-layers"></i>
                                <span>{{ trans('lang.pages') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('pro_pages') }}}">{{ trans('lang.all_pages') }}</a></li>
                                <li><hr><a href="{{{ route('pro_createPage') }}}">{{ trans('lang.add_pages') }}</a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="{{{ route('pro_createPackage') }}}">
                                <i class="ti-package"></i>
                                <span>{{ trans('lang.packages') }}</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{{ route('pro_adminPayouts') }}}">
                                <i class="ti-money"></i>
                                <span>{{ trans('lang.payouts') }}</span>
                            </a>
                        </li> --}}
                        {{-- <li>
                            <a href="{{{ route('pro_homePageSettings') }}}">
                                <i class="ti-home"></i>
                                <span>{{ trans('lang.home_page_settings') }}</span>
                            </a>
                        </li> --}}
                        {{-- <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-settings"></i>
                                <span>{{ trans('lang.settings') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('pro_adminProfile') }}}">{{ trans('lang.acc_settings') }}</a></li>
                                <li><hr><a href="{{{ url('Pro/admin/settings') }}}">{{ trans('lang.general_settings') }}</a></li>
                                <li><hr><a href="{{{ route('resetPassword') }}}">{{ trans('lang.reset_pass') }}</a></li>
                            </ul>
                        </li> --}}
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-layers"></i>
                                <span>{{ trans('lang.cats') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('pro_skills') }}}">{{ trans('lang.skills') }}</a></li>
                                <li><hr><a href="{{{ route('pro_categories') }}}">{{ trans('lang.job_cats') }}</a></li>
                                <li><hr><a href="{{{ route('pro_departments') }}}">{{ trans('lang.dpts') }}</a></li>
                                <li><hr><a href="{{{ route('languages') }}}">{{ trans('lang.langs') }}</a></li>
                                <li><hr><a href="{{{ route('pro_locations') }}}">{{ trans('lang.locations') }}</a></li>
                                <li><hr><a href="{{{ route('badges') }}}">{{ trans('lang.badges') }}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if ($role === 'employer' || $role === 'pro'  )
                        <li>
                            <a href="{{{ url('Pro/'.$role.'/dashboard') }}}">
                                <i class="ti-desktop"></i>
                                <span>{{ trans('lang.dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('message') }}}">
                                <i class="ti-envelope"></i>
                                <span>{{ trans('lang.msg_center') }}</span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-settings"></i>
                                <span>{{ trans('lang.settings') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ url('Pro/'.$role.'/profile') }}}">{{ trans('lang.profile_settings') }}</a></li>
                                <li><hr><a href="{{{ route('pro_manageAccount') }}}">{{ trans('lang.acc_settings') }}</a></li>
                            </ul>
                        </li>
                        @if ($role === 'employer')
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-announcement"></i>
                                    <span>{{ trans('lang.jobs') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="{{{ route('pro_employerManageJobs') }}}">{{ trans('lang.manage_job') }}</a></li>
                                    <li><hr><a href="{{{ url('Pro/employer/jobs/completed') }}}">{{ trans('lang.completed_jobs') }}</a></li>
                                    <li><hr><a href="{{{ url('Pro/employer/jobs/hired') }}}">{{ trans('lang.ongoing_jobs') }}</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-file"></i>
                                    <span>{{ trans('lang.invoices') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="{{{ url('Pro/employer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
                                    <li><hr><a href="{{{ url('Pro/employer/project/invoice') }}}">{{ trans('lang.project_inv') }}</a></li>
                                </ul>
                            </li>
                        @elseif ($role === 'pro')
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-briefcase"></i>
                                    <span>{{ trans('lang.all_projects') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="{{{ url('Pro/freelancer/jobs/completed') }}}">{{ trans('lang.completed_projects') }}</a></li>
                                    <li><hr><a href="{{{ url('Pro/freelancer/jobs/cancelled') }}}">{{ trans('lang.cancelled_projects') }}</a></li>
                                    <li><hr><a href="{{{ url('Pro/freelancer/jobs/hired') }}}">{{ trans('lang.ongoing_projects') }}</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{{ route('pro_showFreelancerProposals') }}}">
                                    <i class="ti-bookmark-alt"></i>
                                    <span> {{ trans('lang.proposals') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{{ route('pro_getFreelancerPayouts') }}}">
                                    <i class="ti-money"></i>
                                    <span> {{ trans('lang.payouts') }}</span>
                                </a>
                            </li>
                            <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-file"></i>
                                    <span>{{ trans('lang.invoices') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><hr><a href="{{{ url('Pro/freelancer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
                                </ul>
                            </li>
                        @endif
                        <li>
                            <a href="{{{ url('Pro/dashboard/packages/'.$role) }}}">
                                <i class="ti-package"></i>
                                <span>{{ trans('lang.packages') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ url('Pro/'.$role.'/saved-items') }}}">
                                <i class="ti-heart"></i>
                                <span>{{ trans('lang.saved_items') }}</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();">
                            <i class="lnr lnr-exit"></i>{{{trans('lang.logout')}}}
                        </a>
                        <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </nav>
            <div class="wt-navdashboard-footer">
                <span>{{{ $copyright }}}</span>
                <span class="version-area">{{ config('app.version') }}</span>
            </div>
        </div>
    </div>
@endauth
