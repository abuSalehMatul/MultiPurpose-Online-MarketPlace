@extends('learn.layout')




@section('css')
<style>
    .menubar-m{
        
        display:none;
    }

</style>
@stop
@section('content')

@include('learn.partials.menubar')
    <section class="faq-section pad-t-b-40" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="faq">
                        <div class="container">
                            <div class="faq-content">
                                <h2 class="text-center text-uppercase">{{$page_title}}</h2>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="domainsTab">
                                        <div class="panel-group accordion" id="accordion4" >
                                            @foreach($faqs as $k => $f)
                                                <div class="panel panel-primary  active " >
                                                    <div class="panel-heading  panel-title-bg" role="tabpanel">

                                                        <h4 class="panel-title "> <a href="#domainsTabQ{{ $f->id }}"  role="button" data-toggle="collapse" data-parent="#accordion4"   aria-expanded="false"class="collapsed "> {{ $f->title }} <i class="fa fa-minus pull-right"></i> </a></h4>
                                                    </div>
                                                    <div id="domainsTabQ{{ $f->id }}" class="panel-collapse collapse @if($k == 0) in @endif" role="tabpanel" @if($k == 0) aria-expanded="true" @else  aria-expanded="false"  @endif   @if($k == 0) class="height-173" @else  class="height-173"@endif>
                                                        <div class="panel-body secondery">
                                                            {!!  $f->description !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@include('learn.partials.subscribe')
@stop