@if(isset($comments))
	@foreach($comments as $comment)
		<div class="media">
			<div class="media-left mr-3">
				<a href="{{url('profile/'.$comment->user_id)}}" title="{{$comment->users->is_admin ? 'Admin' : 'User'}}"><img src="{{asset('images/user/'.$comment->users->image)}}" class="img-fluid media-object" alt="Admin"></a>
			</div>
			<div class="media-body">
				<h6 class="media-heading"><a href="{{url('profile/'.$comment->user_id)}}" title="{{$comment->users->name}}">{{$comment->users->name}}</a> - <span>{{$comment->created_at->diffForHumans()}}</span></h6>
				<p>{!!$comment->body!!}</p>
				@auth
					<div class="media-reply"><a class="reply-btn" data-value="{{$comment->id}}" href="#" title="Reply"><i class="fa fa-reply"></i> Reply</a></div>
				@else
					<div class="media-reply"><a class="reply-btn1" data-toggle="modal" data-target="#login" href="#" title="Reply"><i class="fa fa-reply"></i> Reply</a></div>
				@endauth
				@if($comment->replies()->count()>0)
					@include('theme.childcomment', ['comments' => $comment->replies])
				@endif
			</div>
		</div>
	@endforeach
@endif