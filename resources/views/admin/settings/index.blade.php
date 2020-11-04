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
            <div>
                <form action="{{ url(GlobalHelper::indexUrl().'/post') }}" method="post" role="form" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                    <div class="form-group">    
                        <label for="background" class="control-label">Warna Background</label>
                        <input class="form-control" name="background" type="text" id="background">
                    </div>                   
                    <div class="pull-left">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-file" style="margin-right:5px"></i> Simpan
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </form><br/>
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
    </script>

@stop