@extends('layouts.admin')

@section('style')
    <link href="{!! asset('plugins/datatables/dataTables.bootstrap.css') !!} " rel="stylesheet" type="text/css"/>
    <link href="{!! asset('plugins/sweet-alert/sweet-alert.css') !!} " rel="stylesheet" type="text/css"/>
@stop

@section('content')
<div class="row pos">
    <div class="col-md-12">
        <div class="box-body">
            <div id="cmsNotifications">
                <div class="alert" id="cmsDefaultNotification" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-6">
                        <h3 class="box-title">{!! $title !!}</h3>
                    </div>
                    <div class="col-xs-6">
                        <div class="pull-right">
                            <a href="/home" class="btn btn-default">
                                <i class="fa fa-plus"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub-contene">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="boxed-app">
                        <div class="box-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger autohide">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ url('/me-store/'.Auth::user()->id) }}" method="post" role="form" accept-charset="UTF-8" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab_1" data-toggle="tab">Profil</a></li>
                                        <li><a href="#tab_2" data-toggle="tab">Password</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    {{-- <div class="form-group">
                                                        <label for="photo" class="control-label">Photo</label>    

                                                        <input class="form-control" id="file" onchange="readUrl(this)" style="display:none" name="photo" type="file">    

                                                        <div class="text-danger"></div>
                                                        <button class="btn btn-default" style="max-width:120px" id="upload" type="button" onclick="chooseFile()"><i class="fa fa-upload"></i> Browse</button>
                                                        <br>                        
                                                            <img id="preview_img" class="img img-thumbnail img-ava" src="{{ !empty($row->photo) ? asset(GLobalHelper::checkImage($row->photo)) : '' }}">        
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label for="parent" class="control-label">Email</label>    
                                                        <input class="form-control" id="email" name="email" type="text" value="{!! !empty($row->email) ? $row->email : '' !!}">  
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="parent" class="control-label">Name</label>    
                                                        <input class="form-control" id="name" name="name" type="text" value="{!! !empty($row->name) ? $row->name : '' !!}">  
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="tab-pane" id="tab_2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="password" class="control-label">Password</label>    
                                                        <input class="form-control" id="password" name="password" type="password" value=""> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password_confirmation" class="control-label">Password Confirmation</label>    
                                                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" value="">            
                                                    </div> 
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 
                                </div>
                                 
                                <div class="pull-left">
                                    {{-- <button class="btn btn-danger" type="button" id="reset">
                                        <i class="fa fa-refresh" style="margin-right:5px"></i> Clear
                                    </button> --}}
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-file" style="margin-right:5px"></i> Simpan
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </form>

                        </div>
                        {{-- End Form --}}
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{!! asset('plugins/datatables/jquery.dataTables.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('plugins/datatables/dataTables.bootstrap.js') !!} " type="text/javascript"></script>
    <script src="{!! asset('plugins/sweet-alert/sweet-alert.js') !!} " type="text/javascript"></script>
    <script src="{!! asset('dist/assets/js/alert.js') !!} " type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.10/i18n/Chinese-traditional.json'
                }
            });
        });

        function readUrl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview_img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function chooseFile()
        {
            $('#file').click();
        }

    </script>

@stop