@extends('pro.back-end.master')
@section('content')
	<div class="wt-haslayout wt-dbsectionspace la-manage-jobs-holder">
		<div class="manage-jobs float-left">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="wt-dashboardbox">
						<div class="wt-dashboardboxtitle">
							<h2>{{ trans('lang.manage_job') }}</h2>
						</div>
						<div class="wt-dashboardboxcontent wt-jobdetailsholder">
							@if (!empty($job_details) && $job_details->count() > 0)
								<div class="wt-freelancerholder">
									<div class="wt-tabscontenttitle">
										<h2>{{ trans('lang.posted_jobs') }}</h2>
									</div>
									<div class="wt-managejobcontent">
										@foreach ($job_details as $job)
											@php
												$image = '';
												$duration  =  \App\ProModel\ProHelper::getJobDurationList($job->duration);
												$user_name = $job->employer->first_name.' '.$job->employer->last_name;
												$proposals = \App\ProModel\ProProposal::where('job_id', $job->id)->where('status', '!=', 'cancelled')->get();
												$employer_img = \App\ProModel\ProProfile::select('avater')->where('user_id', $job->employer->id)->first();
												$image = !empty($employer_img->avater) ? '/uploads/users/'.$job->employer->id.'/'.$employer_img->avater : '';
												$verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
											@endphp
											<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
												@if (!empty($job->is_featured) && $job->is_featured === 'true')
													<span class="wt-featuredtag"><img src="{{{ asset('images/featured.png') }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style"></span>
												@endif
												<div class="wt-userlistingcontent">
													<div class="wt-contenthead">
														@if (!empty($user_name) || !empty($job->title) )
															<div class="wt-title">
																@if (!empty($user_name))
																	<a href="{{{ url('Pro/profile/'.$job->employer->slug) }}}">
																	@if ($verified_user === 1)
																		<i class="fa fa-check-circle"></i>&nbsp;
																	@endif
																	{{{ $user_name }}}</a>
																@endif
																@if (!empty($job->title))
																	<h2><a href="{{{ url('Pro/job/'.$job->slug) }}}">{{{ $job->title }}}</a></h2>
																@endif
															</div>
														@endif
														@if (!empty($job->price) ||
															!empty($job->location->title)  ||
															!empty($job->project_type) ||
															!empty($job->duration)
															)
															<ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
																@if (!empty($job->price))
																	<li><span class="wt-dashboraddoller"><i>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}</i> {{{ $job->price }}}</span></li>
																@endif
																@if (!empty($job->location->title))
																	<li><span><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{ trans('lang.img') }}"> {{{ $job->location->title }}}</span></li>
																@endif
																@if (!empty($job->project_type))
																	<li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> {{ trans('lang.type') }} {{{ $job->project_type }}}</a></li>
																@endif
																@if (!empty($job->duration))
																	<li><span class="wt-dashboradclock"><i class="far fa-clock"></i> {{ trans('lang.duration') }} {{{ $duration }}}</span></li>
																@endif
															</ul>
														@endif
													</div>
													<div class="wt-rightarea">
														<div class="wt-btnarea">
															<a href="{{{ url('Pro/job/'.$job->slug) }}}" class="wt-btn">{{ trans('lang.view_detail') }}</a>
															<a href="{{{ url('Pro/job/edit-job/'.$job->slug) }}}" class="wt-btn">{{ trans('lang.edit_job') }}</a>
															@if ($proposals->count() > 0)
																<a href="{{{ url('Pro/employer/dashboard/job/'.$job->slug.'/proposals') }}}" class="wt-btn">{{ trans('lang.view_proposals') }}</a>
															@endif
														</div>
														<div class="wt-hireduserstatus">
															<h4>{{{ $proposals->count() }}}</h4><span>Proposals</span>
															@if ($proposals->count() > 0)
																<ul class="wt-hireduserimgs">
																	@foreach ($proposals as $proposal)
																		@php
																			$profile = \App\User::find($proposal->freelancer_id)->profile;
																			$user_image = !empty($profile) ? $profile->avater : '';
																			$profile_image = !empty($user_image) ? '/uploads/users/'.$proposal->freelancer_id.'/'.$user_image : 'images/user-login.png';
																		@endphp
																		<li><figure><img src="{{{ asset($profile_image) }}}" alt="{{ trans('lang.profile_img') }}" class="mCS_img_loaded"></figure></li>
																	@endforeach
																</ul>
															@endif
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</div>
								@if (method_exists($job_details,'links'))
									{{ $job_details->links('pagination.custom') }}
								@endif
							@else
								@include('errors.no-record')
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
