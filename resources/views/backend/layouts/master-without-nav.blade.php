<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{env('APP_NAME')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon"  href="{{asset('assets/images/favicon.ico')}}">

        @include('backend.layouts.head')
  </head>

@yield('body')
    
@yield('content')

@include('backend.layouts.footer-script')    
            </div>
        </div>
    </body>
</html>