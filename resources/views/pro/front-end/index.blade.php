@extends('pro.front-end.master')
@push('stylesheets')
    <link href="{{ asset('css/prettyPhoto.css') }}" rel="stylesheet">
@endpush
@section('title'){{ config('app.name') }} @stop
@section('description', 'This is description tag')
@section('content')
    @php
        $categories = App\ProModel\ProCategory::latest()->get()->take(8);
        $skills = App\ProModel\ProSkill::latest()->get()->take(8);
        $locations = App\ProModel\ProLocation::latest()->get()->take(8);
        $languages = App\Language::latest()->get()->take(8);
    @endphp
    <div id="home" class="la-home-page">
        @if (Session::has('not_verified'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('not_verified') }}}'" v-cloak></flash_messages>
            </div>
            @php session()->forget('not_verified'); @endphp
        @endif
        <div class="wt-haslayout wt-bannerholder" style="background-image:url({{{ asset(Helper::getHomeBanner('image')) }}})">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="wt-bannerimages">
                            <figure class="wt-bannermanimg" data-tilt>
                                <img src="{{{ asset(Helper::getHomeBanner('inner_image')) }}}" alt="{{{ trans('lang.img') }}}">
                            </figure>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="wt-bannercontent">
                            <div class="wt-bannerhead">
                                <div class="wt-title">
                                    <h1>
                                        <span>{{{ Helper::getHomeBanner('title') }}}</span>
                                        {{{ Helper::getHomeBanner('subtitle') }}}
                                    </h1>
                                </div>
                                <div class="wt-description">
                                    <p>{{{ Helper::getHomeBanner('description') }}}</p>
                                </div>
                            </div>
                            <search-form
                            :widget_type="'home'"
                            :placeholder="'{{ trans('lang.looking_for') }}'"
                            :freelancer_placeholder="'{{ trans('lang.search_filter_list.freelancer') }}'"
                            :employer_placeholder="'{{ trans('lang.search_filter_list.employers') }}'"
                            :job_placeholder="'{{ trans('lang.search_filter_list.jobs') }}'"
                            :no_record_message="'{{ trans('lang.no_record') }}'"
                            >
                            </search-form>
                            <div class="wt-videoholder">
                                <div class="wt-videoshow">
                                    <a data-rel="prettyPhoto[video]" href="{{{ Helper::getHomeBanner('video_url') }}}"><i class="fa fa-play"></i></a>
                                </div>
                                <div class="wt-videocontent">
                                    <span>{{{  Helper::getHomeBanner('video_title') }}}<em>{{{ Helper::getHomeBanner('video_description') }}}</em></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($categories)
            && $categories->count() > 0
            && Helper::getHomeSection('show_cat_section') == 'true')
            <section class="wt-haslayout wt-main-section">
                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                            <div class="wt-sectionhead wt-textcenter">
                                <div class="wt-sectiontitle">
                                    <h2>{{{ Helper::getHomeSection('cat_sec_title') }}}</h2>
                                    <span>{{{ Helper::getHomeSection('cat_sec_subtitle') }}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="wt-categoryexpl">
                            @foreach ($categories as $category)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 float-left">
                                    <div class="wt-categorycontent">
                                        <figure><img src="{{{ asset(Helper::getCategoryImage($category->image)) }}}" alt="{{{ $category->title }}}"></figure>
                                        <div class="wt-cattitle">
                                            <h3><a href="{{{url('Pro/search-results?type=job&category%5B%5D='.$category->slug)}}}">{{{ $category->title }}}</a></h3>
                                        </div>
                                        <div class="wt-categoryslidup">
                                            @if (!empty($category->abstract))
                                                <p>{{{ $category->abstract }}}</p>
                                            @endif
                                            <a href="{{{url('Pro/search-results?type=job&category%5B%5D='.$category->slug)}}}">{{ trans('lang.explore') }} <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($categories->count() > 9)
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                                    <div class="wt-btnarea">
                                        <a href="{{{ route('categoriesList') }}}" class="wt-btn">{{ trans('lang.view_all') }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if (Helper::getHomeSection('show_section') == 'true')
            <section class="wt-haslayout wt-main-section wt-paddingnull wt-bannerholdervtwo" style="background-image:url({{{ asset(Helper::getHomeSection('background_image')) }}})">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="wt-companydetails">
                                <div class="wt-companycontent">
                                    <div class="wt-companyinfotitle">
                                        <h2>{{{ Helper::getHomeSection('left_title') }}}</h2>
                                    </div>
                                    <div class="wt-description">
                                        <p>{{{  Helper::getHomeSection('left_description')  }}}</p>
                                    </div>
                                    <div class="wt-btnarea">
                                        <a href="{{{ Helper::getHomeSection('left_url') }}}" class="wt-btn">{{ trans('lang.join_now') }}</a>
                                    </div>
                                </div>
                                <div class="wt-companycontent">
                                    <div class="wt-companyinfotitle">
                                        <h2>{{{ Helper::getHomeSection('right_title') }}}</h2>
                                    </div>
                                    <div class="wt-description">
                                        <p>{{{ Helper::getHomeSection('right_description') }}}</p>
                                    </div>
                                    <div class="wt-btnarea">
                                        <a href="{{{ Helper::getHomeSection('right_url') }}}" class="wt-btn">{{ trans('lang.join_now') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if (Helper::getHomeSection('show_app_section') == 'true')
            <section class="wt-haslayout wt-main-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <figure class="wt-mobileimg">
                                <img src="{{{ asset(Helper::getAppSection('image')) }}}" alt="{{{ trans('lang.img') }}}">
                            </figure>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 float-left">
                            <div class="wt-experienceholder">
                                <div class="wt-sectionhead">
                                    <div class="wt-sectiontitle">
                                        <h2>{{{ Helper::getAppSection('title') }}}</h2>
                                        <span>{{{ Helper::getAppSection('subtitle')  }}}</span>
                                    </div>
                                    <div class="wt-description">
                                        @php echo htmlspecialchars_decode(stripslashes(Helper::getAppSection('description'))); @endphp
                                    </div>
                                    <ul class="wt-appicon">
                                        <li>
                                            <a href="{{ Helper::getAppSection('android_url') }}">
                                                <figure><img src="{{{ asset('images/android.png') }}}" alt="{{{ trans('lang.img') }}}"></figure>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{  Helper::getAppSection('ios_url') }}">
                                                <figure><img src="{{{ asset('images/ios.png') }}}" alt="{{{ trans('lang.img') }}}"></figure>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if ($skills->count() > 0
            || $categories->count() > 0
            || $locations->count() > 0
            || $languages->count() > 0)
            <section class="wt-haslayaout wt-main-section wt-footeraboutus">
                <div class="container">
                    <div class="row">
                        @if ($skills->count() > 0)
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="wt-widgetskills">
                                    <div class="wt-fwidgettitle">
                                        <h3>{{ trans('lang.by_skills') }}</h3>
                                    </div>
                                    @if (!empty($skills))
                                        <ul class="wt-fwidgetcontent">
                                            @foreach ($skills as $skill)
                                                <li><a href="{{{url('Pro/search-results?type=job&skills%5B%5D='.$skill->slug)}}}">{{{ $skill->title }}}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if ($categories->count() > 0)
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="wt-footercol wt-widgetcategories">
                                    <div class="wt-fwidgettitle">
                                        <h3>{{ trans('lang.by_cats') }}</h3>
                                    </div>
                                    @if (!empty($categories))
                                        <ul class="wt-fwidgetcontent">
                                            @foreach ($categories as $category)
                                                <li><a href="{{{url('Pro/search-results?type=job&category%5B%5D='.$category->slug)}}}">{{{ $category->title }}}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if ($locations->count() > 0)
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="wt-widgetbylocation">
                                    <div class="wt-fwidgettitle">
                                        <h3>{{ trans('lang.by_locs') }}</h3>
                                    </div>
                                    @if (!empty($locations))
                                        <ul class="wt-fwidgetcontent">
                                            @foreach ($locations as $location)
                                                <li><a href="{{{url('Pro/search-results?type=job&locations%5B%5D='.$location->slug)}}}">{{{ $location->title }}}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if ($languages->count() > 0)
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="wt-widgetbylocation">
                                    <div class="wt-fwidgettitle">
                                        <h3>{{ trans('lang.by_lang') }}</h3>
                                    </div>
                                    @if (!empty($languages))
                                        <ul class="wt-fwidgetcontent">
                                            @foreach ($languages as $language)
                                                <li><a href="{{{url('Pro/search-results?type=job&languages%5B%5D='.$language->slug)}}}">{{{ $language->title }}}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/tilt.jquery.js') }}"></script>
    <script src="{{ asset('js/prettyPhoto.js') }}"></script>
    <script>
        jQuery("a[data-rel]").each(function () {
            jQuery(this).attr("rel", jQuery(this).data("rel"));
        });
        jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
            animation_speed: 'normal',
            theme: 'dark_square',
            slideshow: 3000,
            autoplay_slideshow: false,
            social_tools: false
        });
        var popupMeta = {
            width: 400,
            height: 400
        }
    </script>
@endpush
