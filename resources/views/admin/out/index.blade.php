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
                            <a href="{!! url(GLobalHelper::indexUrl()) !!}" class="btn btn-default">
                                <i class="fa fa-plus"></i> Kembali
                            </a>
                            <a href="{!! url(GLobalHelper::indexUrl().'/history') !!}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Lihat Riwayat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="table-responsive"> -->
            <div class="box-body">
                {{-- Form --}}
                {!! form_start($form) !!}
                {!! form_rest($form) !!}

                @include('partials.form_button')
                {!! form_end($form) !!}
            </div>
            <br/><br/>
        </div>
    </div>
</div>
@endsection
@section('script')

@stop