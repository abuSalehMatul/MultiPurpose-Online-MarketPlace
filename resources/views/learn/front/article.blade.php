@extends('layout')

@section('content')
    <style>
        .videoWrapper {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 25px;
            height: 0;
        }

        .videoWrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            autoplay:false;
            autostart:false
        }
    </style>


    <!--Main container-->
    @include('partials.menubar')
    <div class="container pad-80-20">
        <div class="row">
            @if(count($topics) > 0)

                <div class="col-sm-9 width-60">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" >

                            <div class="videoWrapper" id="embeded-video" 	>

                            </div>
                            <h3 id="embeded_title"></h3>
                            
                            <p id="embeded-details"></p>

                        </div>

                    </div>
                </div>

                <div class="col-sm-3 width-40">
                    <a  class="nav-tabs-dropdown btn btn-block btn-primary panel-heading-custom">Playlist</a>
                    <ul id="nav-tabs-wrapper" class="nav nav-tabs nav-pills nav-stacked well do-nicescrol">
                        @foreach($topics as $k=>$data)
                            <li @if($k==0)class="active" id="active_id" @endif>
                                <a href="#vtab{{$data->id}}" data-embedecode="{{$data->video}}" data-videoId="{{$data->id}}" data-details="{{$data->details}}" data-embededtitle="{{$data->title}}" data-id="{{$data->id}}" class="stop-video" data-toggle="tab" >{{$data->title}}</a></li>
                        @endforeach
                    </ul>
                </div>


            @else
                <div class="col-sm-12">
                    <h1 class="text-center no-result">No Topics Found !!</h1>
                </div>

            @endif



        </div>

    </div>



    @include('partials.subscribe')
@stop


@section('script')
    <script>


        $(window).load(function () {
            var $selector = $('#active_id').children('a');
            var embededcode = $selector.data('embedecode');
            var embededtitle = $selector.data('embededtitle');
            var details = $selector.data('details');


            $(".do-nicescrol").niceScroll({
                cursorcolor:"#{{$basic->color}}",
            });

            $('#embeded-video').html(embededcode);
            $('#embeded_title').text(embededtitle);
            $('#embeded-details').html(details);
        })
        $(document).ready(function () {
            setTimeout(function () {
                var height = $('#embeded-video').css('height');
                var heights = height.slice(0,-2) - 50;
                $('#nav-tabs-wrapper').css('max-height',heights+'px');
            },1000);
            $(document).on('click','.stop-video',function () {
                var embededcode = $(this).data('embedecode');
                var embededtitle = $(this).data('embededtitle');
                var details = $(this).data('details');

                $('#embeded-video').html(embededcode);
                $('#embeded_title').text(embededtitle);
                $('#embeded-details').html(details);

            });
        });
    </script>
@stop