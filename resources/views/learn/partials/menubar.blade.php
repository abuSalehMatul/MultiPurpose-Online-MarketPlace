
<div class="menubar-m">
@php
    $articleCategory=App\Model\Mining::where('status',1)->get();
@endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <nav class="navbar navbar-default navbar-custom-bg">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse"
                                data-target=".js-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>


                    <div class="collapse navbar-collapse js-navbar-collapse">
                        <ul class="nav navbar-nav nav-position">
                            @foreach($articleCategory as $k => $data)

                                <li class="dropdown mega-dropdown @if( isset($cat_id) && $cat_id == $data->id ) open @elseif(!isset($cat_id) && $k == 0) open  @endif" id="cat_{{$data->id}}">
                                    <a href="#" class="dropdown-toggle"
                                       data-toggle="dropdown">{{$data->short_name or $data->name }}</a>
                                    <ul class="dropdown-menu mega-dropdown-menu row">

                                        @php
                                            $subCategory =  $data->subcategory()->get();
                                            $slug =  str_slug($data->name);
                                        @endphp

                                        @foreach($subCategory->chunk(1) as $cc)
                                            <li class="col-md-3 col-sm-6 col-xs-12">
                                                <ul>
                                                    @foreach($cc  as $c)
                                                    <li><a href="{{route('topics',[$c->id,$slug])}}">{{$c->title}}  </a></li>
                                                        @endforeach
                                                </ul>
                                            </li>
                                        @endforeach

                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>

            </div>
        </div>

    </div>

</div>