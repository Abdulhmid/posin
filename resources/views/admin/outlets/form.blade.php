@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div id="cmsNotifications">
            <div class="alert" id="cmsDefaultNotification" style="display: none;">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        </div>
        <div class="box-header">
            <div class="row">
                <div class="col-xs-6">
                    <h3 class="box-title">{!! str_contains(Request::segment(2), 'create') ? 'Add' : 'Change' !!} {!! $title !!}</h3>
                </div>
                <div class="col-xs-6">
                    <div class="pull-right">
                        <a href="{!! URL::to(GLobalHelper::indexUrl())!!}" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

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
@endsection