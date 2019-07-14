@extends('coupon.layouts.theme')
@section('main-content')
<!-- forum -->
	<section id="forum" class="forum-main-block">
		<div class="container">
			<div class="forum-page-header">
				<div class="row">
					<div class="col-md-6">
						<div class="forum-page-heading-block">
							<h5 class="forum-page-heading">{{$forumcategory->title}} Forum</h5>
						</div>
						<!-- breadcrumb -->
						<div id="breadcrumb" class="breadcrumb-main-block">
							<div class="breadcrumb-block">
								<ol class="breadcrumb">
				          <li><a href="{{url('/')}}" title="Home">Home</a></li>
				          <li><a href="{{url('forum')}}" title="Forums">Forums</a></li>
				          <li class="active">{{$forumcategory->title}}</li>
								</ol>
							</div>
						</div>
						<!-- breadcrumb end -->
					</div>
					<div class="col-lg-4 col-md-5 ml-lg-auto ml-md-auto">
						<div class="forum-search-block text-right">
							<form class="forum-search" action="#" method="GET">
								<input id="forum-searchbox" type="search" value="" placeholder="Search" class="forum-search-input form-control" autocomplete="off">
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="forum-block">
				@if(isset($forum_dtl) && count($forum_dtl)>0)
					<table id="forum-table" class="nowrap forum-table table table-bordered display">
						<thead class="thead-dark">
					    <tr>
					      <th class="post-cl-width" scope="col">Posts</th>
					      <th scope="col">Rating</th>
						    @if($forumcategory->category != 'g')
					      	<th scope="col">Category</th>
						      <th scope="col">Merchant</th>
						    @endif
						    <th scope="col">Views</th>
					      <th scope="col">By</th>
					    </tr>
					  </thead>
					  <tbody>
						  @foreach($forum_dtl as $key => $item)
						    <tr>
						      <th scope="row">
						      	<div class="row">
											<div class="col-lg-1 col-md-2 d-none d-lg-block d-md-block">
						      			<div class="forum-user-img">
						      				<a href="{{url('profile/'.$item->user_id)}}" title="{{$item->user->name}}"><img src="{{asset('coupon/images/user/'.$item->user->image)}}" alt="User"></a>
						      			</div>
						      		</div>
						      		<div class="col-lg-9 col-md-10">
						      			<a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" class="post-title" title="Post Title">{{str_limit($item->title,50)}}</a>
						      			<div class="post-date">{{$item->created_at->diffForHumans()}}</div>
						      		</div>
						      		<div class="col-md-2 d-none d-lg-block pad-0">
						      			@if($item->is_featured)
						      				<div class="post-tag"><span>Featured</span></div>
						      			@endif
						      		</div>
						      	</div>
						      </th>
						      <td>
						      	<div class="rating">
	                    <div class="set-rating" data-rateyo-rating="{{$item->rating}}"></div>
	                  </div>
						      </td>
						      @if($forumcategory->category != 'g')
							      <td><a href="{{url('category-dtl/'.$item->category->slug)}}" title="{{$item->category->title}}">{{$item->category->title}}</a></td>
							      <td><a href="{{url('store-dtl/'.$item->store->slug)}}" title="{{$item->store->title}}">{{$item->store->title}}</a></td>
							    @endif
						      <td><div class="post-views">{{$item->views()->count()}}</div></td>
						      <td><a href="{{url('profile/'.$item->user_id)}}" class="post-by" title="{{$item->user->name}}">{{strtok($item->user->name,' ')}}</a></td>
						    </tr>
						  @endforeach
						</tbody>
					</table>
				@endif
			</div>
			<div class="forum-footer">
				<div class="row">
					{{-- <div class="col-lg-4 col-md-8">
						<nav aria-label="forum-pagination">
						  <ul class="pagination">
				        {{ $forum_dtl->links() }}                    
				      </ul>
						</nav>
					</div> --}}
					<div class="col-lg-2 ml-lg-auto col-md-4">
						<div class="new-topic-btn">
							<a href="{{url('submit')}}" title="Post New Topic" class="btn btn-primary">Post New Topic</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- end forum -->
@endsection