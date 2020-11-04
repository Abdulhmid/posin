@extends('layouts.admin')

@section('style')
    <link href="{!! asset('plugins/sweet-alert/sweet-alert.css') !!} " rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .table thead th{
            /*background: #eb5b4f; */
            background: #7ddde1; 
        }
        .title-color{
            font-weight: bold;
            color: #a52f26;
        }

        .line-style{
            margin-top: 7px;
            margin-bottom: 7px;
            border: 0;
            border-top: 3px solid #3f4652;
        }

        #text-left{text-align: left;}
        #border-col{
            border: 2px solid #3f4652;
        }
        #col-border-left{
            border-left: 1px solid #d0c8c8;
            padding-left: 19px;
        }

        /* Loading */
        #divLoading
        {
            display : none;
        }

        #divLoading.hide
        {
            display : none;
        }

        #divLoading.show
        {
            display : block;
            position : fixed;
            z-index: 100;
            background-image : url('http://loadinggif.com/images/image-selection/3.gif');
            background-color:#666;
            opacity : 0.4;
            background-repeat : no-repeat;
            background-position : center;
            left : 0;
            bottom : 0;
            right : 0;
            top : 0;
        }
        #loadinggif.show
        {
            left : 50%;
            top : 50%;
            position : absolute;
            z-index : 101;
            width : 32px;
            height : 32px;
            margin-left : -16px;
            margin-top : -16px;
        }

    </style>
@endsection

@section('content')
<div class="row pos">
    <div id="divLoading"> 
    </div>
    <div class="col-md-12">
        <div class="well well-home">
            <form action="{{url('')}}/posReturn" id="posReturn" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <fieldset>
                                <legend style="margin-bottom: 20px;">
                                    Cari Barang
                                </legend>
                            </fieldset>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Masukkan Nama atau Kode:</label>
                                    <input type="text" name="code" class="form-control my-colorpicker1 colorpicker-element">
                                </div>
                                <div class="form-group">
                                    <button type="button" id="find" class="btn btn-info">Cari</button>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body" style="display:none;">
                                <fieldset>
                                    <legend style="margin-bottom: 20px;">
                                        Info
                                    </legend>
                                    <div class="messages">
                                        <li class="right" style=" list-style-type: none;">
                                            <div class="message show_total" style="border: 1px solid #9AC9F4;margin: 0px;width: auto;min-height: 75px;font-size: 15px;    padding: 10px 0px 9px 8px;background-color: rgba(5, 197, 205, 0.5);">
                                                <p class="grand_total">
                                                    <i>Form Pengembalian barang rusak atau cacat</i>
                                                </p>
                                            </div>
                                        </li>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <!-- <hr class="line-style"/> -->
                    <div class="col-md-12" style="padding-top: 24px;">
                        <input type="hidden" id="idList" value="">
                        <table id="table" class="table table-striped dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <!-- <th>Diskon</th> -->
                                    <th>QTY Barang yang dikembalikan</th>
                                    <th width="153px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                        <hr class="line-style" />
                    </div>
                    <div class="col-md-6" style="/*border-bottom: 1px solid #d0c8c8;*/">
                        <div class="form-group" style="padding-bottom: 0px;margin-bottom: 6px;">
                            <textarea class="form-control" id="additional_info" name="additional_info" style="height: 66px;" value="" placeholder="Ketarangan Tambahan"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6" id="col-border-left" style="border-bottom: 1px solid #d0c8c8;">
                        <div class="box">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-12">
                                <input type="hidden" id="keyTrans" value="">
                                <a href="{{url('return')}}" class="btn btn-default">Batalkan</a>
                                  <!-- <button type="button" id="print" class="btn btn-primary">Cetak</button> -->
                                  <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{!! asset('plugins/sweet-alert/sweet-alert.js') !!} " type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function($) {
            postEven();
            $("#find").click(function() {
                var key = $("input[name='code']").val();

               $.get("{!! url('/findReturn/') !!}/"+key)
                        .always(function () {
                           $("div#divLoading").addClass('show'); 
                        })
                        .fail(function () {
                            $("div#divLoading").removeClass('show');
                        })
                        .done(function (data) {
                            if (data['action']=="0") {
                                alert('Batas Pengembalian Sudah Habis');
                                $("div#divLoading").removeClass('show');
                                return false;
                            }else if(data['action']=="2"){
                                alert('Data tidak ada');
                                $("div#divLoading").removeClass('show');
                                return false;
                            }
                            addRowTable(data['data']);
                            $("div#divLoading").removeClass('show');
                        });

            });
        });

        $( document ).on( "click", ".delete_item", function( e ) {
            var jwb = confirm('Yakin Menghapus Item ini ? ');
            if(jwb){
                $(this).parent().fadeOut('slow', function() {
                    $(this).parent().remove();
                });
            }
        });  

        function addRowTable(data){
            $('#keyTrans').val('');
            $('#table tr:not(:first)').remove();
            $.each(data , function(i, val) { 
                $('#table').append('<tr>'+
                    '<td>'+'<input type="hidden" name="item[]" value="'+val.id_item+'">'+
                        '<input type="hidden" name="idrow[]" value="'+val.id+'">'+
                        '<input type="hidden" name="idtrans[]" value="'+val.id_trans+'">'+
                        '<button type="button" class="btn btn-danger" style="padding: 15px 6px;">'+
                            '<span class="sname" id="">'+val.item.name+'</span>'+
                        '</button></td>'+
                    // '<td><input type="hidden" name="discount[]" value="'+val.discount+'" class="discount_'+val.id_item+'" >'+val.discount+'</td>'+
                    '<input type="hidden" id="stok_'+val.id_item+'" value="'+'0'+'" class="stok">'+
                    '<td><input type="number" id="qty_'+val.id_item+'" min="0" value="0" class="qty form-control" name="qty[]" ></td>'+
                    '<td>'+
                        '<button type="button" id="linkdelete" data-id="'+val.id_item+'" class="delete_item btn btn-flat btn-danger btn-sm" '+ 
                           'data-toggle="tooltip" data-original-title="Edit">'+
                           '<i class="fa fa-trash"></i> Delete'+
                        '</button>'+
                    '</td>'+
                '</tr>');
            });
        }

        function postEven(){
            $('form#posReturn').submit(function(event) {
                event.preventDefault(); 

                if ($('#additional_info').val()=="") {
                    alert('Keterangan tidak boleh kosong');
                    return false;
                }

                var form = $(this);
                $.ajax({
                  type: form.attr('method'),
                  url: form.attr('action'),
                  data: form.serialize()
                }).always(function(data) {
                    $("div#divLoading").addClass('show');
                }).done(function(data) {
                    $('#keyTrans').val(data);
                    clearDefault();
                    $("div#divLoading").removeClass('show');
                    console.log(data);
                }).fail(function(data) {

                });
            });
        }

        function clearDefault(){
            $('#table tr:not(:first)').remove();
        }

        $("#print").click(function() {
            var key = $('#keyTrans').val();
            var url = "{!! url('') !!}"+"/posPdf/"+key;
            window.open(url, "_blank");
        })

    </script>
@stop