@extends('layouts.admin')

@section('style')
    <link href="{!! asset('plugins/datatables/dataTables.bootstrap.css') !!} " rel="stylesheet" type="text/css"/>
    <link href="{!! asset('plugins/sweet-alert/sweet-alert.css') !!} " rel="stylesheet" type="text/css"/>
    <link href="{!! asset('plugins/datepicker/datepicker3.css') !!}" rel="stylesheet" type="text/css"/>
@stop

@section('content')
<div class="row pos">
    <div class="col-md-3 box-report-title">
        <div class="box-body ">
            <div class="form-group" style="display:none">
                <label for="type" class="control-label">Tipe Laporan</label>
                <select class="form-control select2" id="type" name="type">
                    <option value="income" selected="selected">Laporan Pendapatan</option>
                </select>  
            </div>
            <div class="form-group">
                <label for="filterBy" class="control-label">Tampilkan Berdasarkan</label>
                <select class="form-control select2" id="filterBy" name="filterBy">
                    <option value="yearly">Tahunan</option>
                    <option value="monthly">Bulanan</option>
                    <!-- <option value="daily" selected="">Harian</option> -->
                </select>  
            </div>
            <div class="filterMonth" style="display:none;">
                <div class="row">
                    <div class="col-md-6">
                        <label for="monthY" class="control-label">Tahun</label>
                        <input type="text" class="form-control" id="bulYear"> 
                    </div>
                    <div class="col-md-6">
                        <label for="monthW" class="control-label">Bulan</label>
                        <select class="form-control" class="bulMonth" id="bulMonth">
                                @foreach(GlobalHelper::getMonth() as $key => $value)
                                    <option value="{{sprintf("%02d", $key)}}"
                                        {!! sprintf("%02d", $key)==date('m')?'selected':'' !!}>
                                        {!! $value !!}
                                    </option>
                                @endforeach
                        </select> 
                    </div>
                </div>
            </div>
            <div class="filterWeek" style="display:none;">
                <label for="week" class="control-label">Mingguan</label>
                <input type="text" class="form-control week" name="week" 
                    value="{{Carbon\Carbon::now()->subDay(6)->format('d/m/Y')}}-{{Carbon\Carbon::now()->format('d/m/Y')}}"> 
            </div>
            <div class="filterYear" style="display:none;">
                <label for="year" class="control-label">Tahun</label>
                <input type="text" class="form-control year" id="year" name="year" value="{{date('Y')}}"> 
            </div>
            <div class="filterDay">
                <label for="day" class="control-label">Hari</label>
                <input type="text" class="form-control day" name="day" value="{{date('d-m-Y')}}"> 
            </div>
            <br/>
            <div>
                <button class="btn btn-block" id="find">CARI</button>
            </div>
        </div>
    </div>
    <div class="col-md-9 box-report">
        <div class="box-body ">
            <div id="cmsNotifications">
                <div class="alert" id="cmsDefaultNotification" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
            <div class="box-header" style="display:none">
                <div class="row">
                    <div class="col-xs-6">
                        <h3 class="box-title">{!! $title !!}</h3>
                    </div>
                    <div class="col-xs-6">
                        <div class="pull-right">
                            <a href="{!! url(GLobalHelper::indexUrl().'/xls') !!}" class="btn btn-success">
                                <i class="fa fa-plus"></i> Cetak
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="table-responsive"> -->
            <div class="row">
                <div class="col-md-11">
                    <div class="boxed-app__header">
                        <div class="pull-left">
                            <h2 class="heading">Laporan <span id="text-pendapatan-title-table"> Pendapatan </span> </h2>
                            <label><span id="date-table">{!! date("l, d F Y") !!}</span></label>
                        </div>
                        <a href="#" id="excel" style="margin: 16px -31px;" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> Cetak
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div id="error-table" style="display: none">
                        <p class="text-center text-danger">
                            <i class="fa fa-exclamation-circle"></i> Terjadi Kesalahan, coba ulangi lagi.
                        </p>
                    </div>
                    <div id="" class="">
                        <span class="loadingTable" style="margin-left: 50%;">
                            <i class="fa fa-spinner fa-2x fa-pulse"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Pendapatan</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<br/><br/>
@endsection
@section('script')
    <script src="{!! asset('plugins/datatables/jquery.dataTables.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('plugins/datatables/dataTables.bootstrap.js') !!} " type="text/javascript"></script>
    <script src="{!! asset('plugins/sweet-alert/sweet-alert.js') !!} " type="text/javascript"></script>
    <script src="{!! asset('dist/assets/js/alert.js') !!} " type="text/javascript"></script>
    <script src="{!! asset('plugins/datepicker/bootstrap-datepicker.js') !!}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            defaultJs();
            datatable(getParameter());
            $('#find').on('click', function() {
                datatable(getParameter());
            });

            $('#excel').on('click', function() {
                window.open(
                  '{!! URL::to(GlobalHelper::indexUrl()."/excel?")!!}'+getParameter(),
                  '_blank'
                );
            });
        });

        function defaultJs(){

            var value = $("#filterBy").val(),
                fY    = $('.filterYear'),
                fM    = $('.filterMonth'),
                fW    = $('.filterWeek'),
                fD    = $('.filterDay');

            if (value=="yearly") {
                fY.show();fM.hide();fW.hide();fD.hide();
            }else if(value=="monthly"){
                fY.hide();fM.show();fW.hide();fD.hide();
            }

            $('.day,.year,.week').keypress(function(e) {
                return false;
            })

            $('.day').datepicker({
              autoclose: true,
              format: "dd-mm-yyyy",
              endDate: '+0d'
            })
            $('.year,#bulYear').datepicker({
              autoclose: true,
              format: "yyyy",
              viewMode: "years", 
              minViewMode: "years",
              endDate: '+0d'
            })

            $('.week').datepicker({
                autoclose: true,
                format :'dd/mm/yyyy',
                endDate: '+0d',
                forceParse :false
            }).on("changeDate", function(e) {
                var date = e.date;
                startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
                endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+6);
                $('.week').datepicker('update', startDate);
                $('.week').val((startDate.getMonth() + 1) + '/' + startDate.getDate() + '/' +  startDate.getFullYear() + ' - ' + (endDate.getMonth() + 1) + '/' + endDate.getDate() + '/' +  endDate.getFullYear());
            })

            $("select#filterBy").click(function () {
                var value = $(this).val(),
                    fY    = $('.filterYear'),
                    fM    = $('.filterMonth'),
                    fW    = $('.filterWeek'),
                    fD    = $('.filterDay');

                if (value=="yearly") {
                    fY.show();fM.hide();fW.hide();fD.hide();
                }else if(value=="monthly"){
                    fY.hide();fM.show();fW.hide();fD.hide();
                }else if(value=="weekly"){
                    fY.hide();fM.hide();fW.show();fD.hide();
                }else if(value=="daily"){
                    fY.hide();fM.hide();fW.hide();fD.show();
                }

            });
        }

        function getParameter() {
            var params = {
                filter_type : $("#type").val(),
                filter_by : $("#filterBy").val(),
                year     : $("#year").val(),
                bulYear  : $("#bulYear").val(),
                bulMonth : $("#bulMonth").val()
            };
            return $.param(params);
        }

        function datatable(param) {
            var loading = $(".loadingTable");
            var target = $("#table");
            var error = $("#error-table");
            
            loading.show();
            error.hide();
            target.hide();
            return oTable = $(target).DataTable({
                "dom": '<"tableHeader"<"row"<"col-md-6"f><"col-md-6"p>>><"newProcessing"r>t<"tableFooter"<"row"<"col-md-4"l><"col-md-4"i><"col-md-4"p>>>',
                "bPaginate": false,
                "bLengthChange": true,
                "bFilter": false,
                "bSort": false,
                "bInfo": false,
                "bAutoWidth": true,
                "processing": false,
                "bDestroy": true,
                "serverSide": true,
                "ajax": "{!! url(GLobalHelper::indexUrl().'/datatable?') !!}"+param,
                fnDrawCallback: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                    var data = $('[data-toggle="popover"]');
                    data.popover();
                    data.on('show.bs.popover', function () {
                        data.popover('hide');
                    })

                    /* event */
                    target.show();
                }
            });
        }
    </script>

@stop