@extends('layouts.admin')
@section('style')
    <link href="{!! asset('plugins/tag-it/jquery.tagit.css') !!}" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('plugins/tag-it/tagit.ui-zendesk.css') !!}" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('plugins/sweet-alert/sweet-alert.css') !!}" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('plugins/iCheck/all.css') !!} " rel="stylesheet" type="text/css"/>
@stop
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
            {!! Form::open(['url'=>GLobalHelper::indexUrl().'/storeAcl', 
                        'class'=>'form-horizontal']) !!}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Menu</th>
                        @foreach($roles as $key => $value)
                            <th> {!! $value['role']['name'] !!}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <td></td>
                        @foreach($roles as $key => $value)
                            <td>
                                <div class="col-xs-4 icheckbox" style="padding-bottom:1px">
                                    <input type="checkbox" name="check_module" data-role="{!! $key !!}"
                                           title="Choose All To Role {!! $value['name'] !!} ">
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($modules as $valueModule)

                        <tr class="success">
                            <td><b>Modul: {!! $valueModule->module_name_alias !!}</b></td>
                            @foreach($roles as $key => $value)
                                <td>
                                    <div class="col-xs-4 icheckbox" style="padding-bottom:1px">
                                        <input type="checkbox" name="check_sub_module" data-role="{!! $key !!}"
                                               data-module="{!! $valueModule->module_id !!}"
                                               title="Pilih Semua untuk Grup {!! $value['name'] !!} di Modul {!! $valueModule->module_name_alias !!}">
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                        @foreach(AclHelper::takeFunction($valueModule->module_id) as $key => $valuefunction)
                            <?php $functioName = AclHelper::takeNumberFunction($valueModule->module_id, $key); ?>
                            <tr>
                                <td><b>Fungsi : </b> {!! ucfirst($valuefunction) !!}</td>
                                @foreach($roles as $key => $value)
                                    <td>
                                        <div class="col-xs-4 icheckbox" style="padding-bottom:1px">
                                            <input type="checkbox"
                                                   class="role_{!! $key !!} role_{!! $key !!}_module_{!! $valueModule->module_id !!}"
                                                   name="function{!! $value->id.$valueModule->module_id.$functioName !!}"
                                                    {!! AclHelper::takePermissionFunction($value->id, $valueModule->module_id, $functioName) !!}
                                            >
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>

                </table>
            </div>

            <div class="clearfix"></div>
            <div class="box-footer">
                <div class="pull-right">
                    <button class="btn btn-danger" type="button" id="reset" style="display: none;">
                        <i class="fa fa-refresh" style="margin-right:5px"></i> Back
                    </button>
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-file" style="margin-right:5px"></i> Save
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
            {!! Form::close() !!}
        </div>
        <br/><br/>
    </div>
</div>
@endsection
@section('script')
    <script src="{!! asset('plugins/jqueryui/jquery-ui.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('plugins/sweet-alert/sweet-alert.js') !!} " type="text/javascript"></script>
    <script src="{!! asset('js/alert.js') !!} " type="text/javascript"></script>
    <script type="text/javascript" src="{!! asset('plugins/iCheck/icheck.min.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var checkModule = $("input[name='check_module']");
            var checkSubModule = $("input[name='check_sub_module']");
            var checks = $("input[type='checkbox']");

            checks.not(checkSubModule).not(checkModule).iCheck({
                checkboxClass: 'icheckbox_square-green',
                increaseArea: '20%'
            });

            checkModule.on('ifCreated', function (event) {
                        if (this.title) {
                            $(this).parent().attr('title', $(this).attr('title'));
                        }
                    })
                    .iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        increaseArea: '20%'
                    })
                    .on('ifChanged', function (event) {
                        var id = $(this).data('role');
                        var targets = checks.filter(".role_" + id);
                        if (event.currentTarget.checked) {
                            targets.iCheck('check');
                        } else {
                            targets.iCheck('uncheck');
                        }

                    });

            checkSubModule.on('ifCreated', function (event) {
                        if (this.title) {
                            $(this).parent().attr('title', $(this).attr('title'));
                        }
                    })
                    .iCheck({
                        checkboxClass: 'icheckbox_flat-green',
                        increaseArea: '20%'
                    })
                    .on('ifChanged', function (event) {
                        var role = $(this).data('role');
                        var module = $(this).data('module');
                        var targets = checks.filter(".role_" + role + "_module_" + module);
                        if (event.currentTarget.checked) {
                            targets.iCheck('check');
                        } else {
                            targets.iCheck('uncheck');
                        }

                    });

        });


    </script>
@stop