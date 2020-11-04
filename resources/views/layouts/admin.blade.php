
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>Selangkung | Admin home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="Coaster CMS v5.3.9">
    <meta name="_token" content="vcN4qhBQInPOumG2R5W0P4micwC9x60HKZJxQMSe">

    <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
    <link media="all" type="text/css" rel="stylesheet" href="{!!url('dist/assets/css')!!}/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="{!!url('dist/assets/app/css')!!}/main.css">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"> -->
    <link href="{!! asset('plugins/PNotify/pnotify.custom.min.css') !!} " rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .pos{
            margin-right: -103px;
            margin-left: -103px;
        }
        .btn-posale {
            color: #fff;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        /*.dropdown-menu{*/
            /*background: transparent url("http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png") no-repeat bottom center;*/
        /*}*/
    </style>
    @yield('style')

</head>

<body>

    @include('partials.top_menu')

    <div class="container" id="content-wrap">
        @yield('content')
    </div>
    
<footer class="footer" style="/*background-color: #05C5CD;*/ background-color: #a94442;" >
  <div class="container">
    <p style="color:#FFF;" class="text-muted">Place sticky footer content here.</p>
  </div>
</footer>

<!-- <script src="{!!url('plugins/jQuery')!!}/jquery1102.min.js"></script> -->
<script src="{!!url('dist/assets/jquery')!!}/jquery-1.12.0.min.js"></script>
<script src="{!!url('dist/assets/bootstrap')!!}/js/bootstrap.min.js"></script>
<script src="{!!url('dist/assets/app/js')!!}/versions.js"></script>
<script src="{!!url('dist/assets/js')!!}/main.js"></script>
<script src="{!!url('dist/assets/app/js')!!}/functions.js"></script>

<script src="{!! asset('plugins/PNotify/pnotify.custom.min.js') !!} " type="text/javascript"></script>
<script src="{!! asset('js/alert.js') !!} " type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        @if(Session::has('error'))
            notif_error("{!! Session::get('error') !!}");
        @endif
        @if(Session::has('message'))
            notif_success("{!! Session::get('message') !!}");
        @endif
        @if(Session::has('info'))
            notif_info("{!! Session::get('info') !!}");
        @endif
        @if(Session::has('warning'))
            notif_warning("{!! Session::get('warning') !!}");
        @endif
    });
</script>
@yield('script')

</body>

</html>
