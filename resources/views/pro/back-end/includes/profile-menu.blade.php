<nav id="wt-profiledashboard" class="wt-usernav">
        <ul>
            @if ($role === 'admin')
                <li>
                    <a href="{{{ route('allJobs') }}}">
                        <i class="ti-briefcase"></i>
                        <span>{{ trans('lang.all_jobs') }}</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{{ route('reviewOptions') }}}">
                        <i class="ti-check-box"></i>
                        <span>{{ trans('lang.review_options') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{{ route('userListing') }}}">
                        <i class="ti-user"></i>
                        <span>{{ trans('lang.manage_users') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{{ route('emailTemplates') }}}">
                        <i class="ti-email"></i>
                        <span>{{ trans('lang.email_templates') }}</span>
                    </a>
                </li> --}}
                <li class="menu-item-has-children">
                    <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                    <a href="{{{  url('Pro/admin/pages') }}}">
                        <i class="ti-layers"></i>
                        <span>{{ trans('lang.pages') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{{ url('Pro/admin/pages') }}}">{{ trans('lang.all_pages') }}</a></li>
                        <li><a href="{{{ route('pro_createPage') }}}">{{ trans('lang.add_pages') }}</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{{ route('pro_createPackage') }}}">
                        <i class="ti-package"></i>
                        <span>{{ trans('lang.packages') }}</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{{ route('adminPayouts') }}}">
                        <i class="ti-money"></i>
                        <span>{{ trans('lang.payouts') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{{ route('homePageSettings') }}}">
                        <i class="ti-home"></i>
                        <span>{{ trans('lang.home_page_settings') }}</span>
                    </a>
                </li> --}}
                {{-- <li class="menu-item-has-children">
                    <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                    <a href="{{{ url('Pro/admin/profile') }}}">
                        <i class="ti-settings"></i>
                        <span>{{ trans('lang.settings') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{{ url('Pro/admin/profile') }}}">{{ trans('lang.acc_settings') }}</a></li>
                        <li><a href="{{{ url('Pro/admin/settings') }}}">{{ trans('lang.general_settings') }}</a></li>
                        <li><a href="{{{ route('pro_resetPassword') }}}">{{ trans('lang.reset_pass') }}</a></li>
                    </ul>
                </li> --}}
                <li class="menu-item-has-children">
                    <span class="wt-dropdowarrow"><i class="ti-layers"></i></span>
                    <a href="{{{ route('pro_categories') }}}">
                        <i class="ti-layers"></i>
                        <span>{{ trans('lang.cats') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{{ route('pro_skills') }}}">{{ trans('lang.skills') }}</a></li>
                        <li><a href="{{{ route('pro_categories') }}}">{{ trans('lang.job_cats') }}</a></li>
                        <li><a href="{{{ route('pro_departments') }}}">{{ trans('lang.dpts') }}</a></li>
                        <li><a href="{{{ route('pro_languages') }}}">{{ trans('lang.langs') }}</a></li>
                        <li><a href="{{{ route('pro_locations') }}}">{{ trans('lang.locations') }}</a></li>
                        <li><a href="{{{ route('pro_badges') }}}">{{ trans('lang.badges') }}</a></li>
                    </ul>
                </li>
            @endif
            @if ($role === 'employer' || $role === 'pro' )
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
                    <a href="javascript:void(0);">
                        <i class="ti-settings"></i>
                        <span>{{ trans('lang.settings') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{{ url('Pro/'.$role.'/profile') }}}">{{ trans('lang.profile_settings') }}</a></li>
                        <li><a href="{{{ route('manageAccount') }}}">{{ trans('lang.acc_settings') }}</a></li>
                    </ul>
                </li>
                @if ($role === 'employer')
                    <li>
                        <a href="{{{ route('employerPostJob') }}}">
                            <i class="ti-pencil-alt"></i>
                            <span>{{{ trans('lang.post_job') }}}</span>
                        </a>
                    </li>
                    <li class="menu-item-has-children page_item_has_children">
                        <a href="javascript:void(0);">
                            <i class="ti-announcement"></i>
                            <span>{{ trans('lang.jobs') }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{{ route('employerManageJobs') }}}">{{ trans('lang.manage_job') }}</a></li>
                            <li><a href="{{{ url('Pro/employer/jobs/completed') }}}">{{ trans('lang.completed_projects') }}</a></li>
                            <li><a href="{{{ url('Pro/employer/jobs/hired') }}}">{{ trans('lang.ongoing_projects') }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="javascript:void(0);">
                            <i class="ti-file"></i>
                            <span>{{ trans('lang.invoices') }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{{ url('Pro/employer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
                            <li><a href="{{{ url('Pro/employer/project/invoice') }}}">{{ trans('lang.project_inv') }}</a></li>
                        </ul>
                    </li>
                @elseif ($role === 'pro')
                    <li class="menu-item-has-children page_item_has_children">
                        <a href="{{{ route('jobs') }}}">
                            <i class="ti-briefcase"></i>
                            <span>{{ trans('lang.all_projects') }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{{ url('Pro/freelancer/jobs/completed') }}}">{{ trans('lang.completed_projects') }}</a></li>
                            <li><a href="{{{ url('Pro/freelancer/jobs/cancelled') }}}">{{ trans('lang.cancelled_projects') }}</a></li>
                            <li><a href="{{{ url('Pro/freelancer/jobs/hired') }}}">{{ trans('lang.ongoing_projects') }}</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{{ route('pro_showFreelancerProposals') }}}">
                            <i class="ti-bookmark-alt"></i>
                            <span>{{ trans('lang.proposals') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{{ route('pro_getFreelancerPayouts') }}}">
                            <i class="ti-money"></i>
                            <span>{{ trans('lang.payouts') }}</span>
                        </a>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="javascript:void(0);">
                            <i class="ti-file"></i>
                            <span>{{ trans('lang.invoices') }}</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="{{{ url('Pro/freelancer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
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
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('profile-logout-form').submit();">
                    <i class="lnr lnr-exit"></i>
                    {{{trans('lang.logout')}}}
                </a>
                <form id="profile-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </nav>
