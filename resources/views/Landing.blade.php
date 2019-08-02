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
            
            <div class="col-md-3 box" onclick="showpin('freelancer')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" value="freelancer">
                <a  >
                {{-- <a href="{{url('freelancer-dashboard')}}" > --}}
                    Freelancer
                </a> 
            </div>
            <div class="col-md-3 box" onclick="showpin('pro')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <a >
                 Pro
                </a>
                
            </div>
            <div class="col-md-3 box" onclick="showpin('job')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <a >Job</a>
               
            </div>
            <div class="col-md-3 box" onclick="showpin('community')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <a >
                    Community
                </a>
                
            </div>
            <div class="col-md-3 box" onclick="showpin('study')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <a> Study and Grow</a>
               
            </div>
            <div class="box col-md-3" onclick="showpin('chore')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <a >Chores</a>
            </div>
             <div class="col-md-3 box" onclick="showpin('scolarship')">
               Scolarship
            </div>
        </div>



<!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('verification_user')}}" id="from" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="pin">PIN</label>
                            <input type="text" id="pin" class="form-control" name="pin" >
                            <small id="warning" class="text-danger" style="display:none">PIN is needed to authentic access. please configure your pin before access</small>
                        </div>
                        <input type="hidden" name="verification" value="pin">
                        <input type="hidden" name="type" value="" id="type">
                        <div class="form-group">
                            <label for="">See AS a guest</label>
                            <input type="checkbox" value="guest" name="guest" >
                        </div>
                        <div class="form-group">
                            <input  type="submit" class="form-control bg-danger">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{url('reset_pin')}}" type="button" class="btn btn-primary">Reset PIN</a>
                </div>
                </div>
            </div>
            </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        var type;
        function showpin(data){
            type=data;
             document.getElementById("type").setAttribute('value',data);
                $.ajax({
                url: "{{ url('verification_user_ajax') }}",
                type: 'get',
               
                success: function(result){
                    console.log(result);
                    if(result=='true'){
                        $('#warning').hide();
                    }else{
                        $('#warning').show();
                    }
                }
                });
        }
        
        
    </script>
</body>
</html>