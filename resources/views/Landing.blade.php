<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/fontawesome/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>KCE</title>
</head>
<body class="container">
    <div class="card col-md-10 col-sm-12">
        <div class="card-title col-md-12">
           <h3 class="text-center"> Welcome to KCE.</h3>
        </div>
        <nav class="nav navbar-default float-right">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </nav>
        <style>
            .box{
                height: 100px;
                padding:10px;
                margin:20px;
                background: greenyellow;
                color:white;
                font-weight: 800;
                float: left;
            }
        </style>
        <div class="card-body">
            
            <div class="col-md-3 box">
                <a href="{{url('freelancer-dashboard')}}">
                    Freelancer
                </a> 
            </div>
            <div class="col-md-3 box">
                <a href="{{url('pro')}}">
                 Pro
                </a>
                
            </div>
            <div class="col-md-3 box">
                <a href="{{url('job')}}">Job</a>
               
            </div>
            <div class="col-md-3 box">
                <a href="{{url('/coupon-dashboard')}}">
                    Community
                </a>
                
            </div>
            <div class="col-md-3 box">
                <a href="{{url('/learn-and-grow')}}"> Study and Grow</a>
               
            </div>
            <div class="box col-md-3">
                <a href="{{url('chores/view')}}">Chores</a>
            </div>
             <div class="col-md-3 box">
               Scolarship
            </div>
        </div>
    </div>
</body>
</html>