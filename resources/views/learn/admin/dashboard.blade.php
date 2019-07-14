@extends('learn.admin.layout.master')

@section('body')

    @php
        $subscriber = App\Model\LearnSubscriber::count();
        $category = App\Model\Mining::count();
        $subCategory = App\Model\Unit::count();
        $topics = App\Model\PricingPlan::count();
    @endphp
    <div class="row">

        <div class="col-md-6 col-lg-3">
            <a href="{{url('admin/category')}}" class="text-decoration">
                <div class="widget-small warning coloured-icon"><i class="icon fa fa-th fa-3x"></i>
                    <div class="info">
                        <h5>Category</h5>
                        <p><b>{{$category}}</b></p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{route('admin.unit')}}" class="text-decoration">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-tree fa-3x"></i>
                    <div class="info">
                        <h5>Sub-Category</h5>
                        <p><b>{{$subCategory}} </b></p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{route('plan.all')}}" class="text-decoration">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-newspaper fa-3x"></i>
                    <div class="info">
                        <h4>Topics</h4>
                        <p><b>{{$topics}} </b></p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{route('manage.subscribers')}}" class="text-decoration">
                <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-up fa-3x"></i>
                    <div class="info">
                        <h4>Subscribers </h4>
                        <p><b>{{$subscriber}} </b></p>
                    </div>
                </div>
            </a>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Article </h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                </div>
            </div>
        </div>
    </div>

    @php


    $sell =  \App\Model\PricingPlan::whereYear('created_at', '=', date('Y'))->get()->groupBy(function($d) {
          return $d->created_at->format('F');
       });
       $monthly_sell = [];
       $month = [];
       foreach ($sell as $key => $value) {
        $monthly_sell[] = count($value);
        $month[] = $key;
       }
    @endphp



@endsection

@section('script')
    <script type="text/javascript" src="{{asset('learn/assets/admin/js/chart.js')}}"></script>
    <script type="text/javascript">
        var data = {
            labels:  {!! json_encode($month) !!},
            datasets: [
                {
                    label: "My Second dataset",
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: {!! json_encode($monthly_sell) !!},
                }
            ]
        };


        var ctxl = $("#lineChartDemo").get(0).getContext("2d");
        var lineChart = new Chart(ctxl).Line(data);

    </script>

@stop

