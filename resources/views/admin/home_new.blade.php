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
            <form action="{{url('')}}/posAction" id="posAction" method="POST">
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
                                    <input type="text" id="typehead" class="form-control my-colorpicker1 colorpicker-element">
                                </div>
                                <div class="form-group">
                                <button class="btn btn-info">Tambah</button>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body">
                                <fieldset>
                                    <legend style="margin-bottom: 20px;">
                                        Total Pembayaran
                                    </legend>
                                    <div class="messages">
                                        <li class="right" style=" list-style-type: none;">
                                            <div class="message show_total" style="border: 1px solid #9AC9F4;margin: 0px;width: auto;min-height: 75px;font-size: 80px;    padding: 10px 0px 9px 8px;background-color: rgba(5, 197, 205, 0.5);">
                                                <p class="grand_total">0</p>
                                            </div>
                                        </li>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <hr class="line-style"/>
                    <div class="col-md-12" style="padding-top: 24px;">
                        <input type="hidden" id="idList" value="">
                        <table id="table" class="table table-striped dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Price</th>
                                    <th>Diskon</th>
                                    <th>QTY</th>
                                    <th width="153px">Subtotal</th>
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
                            <textarea class="form-control" name="additional_info" style="height: 66px;" value="" placeholder="Ketarangan Tambahan"></textarea>
                        </div>
                        <div class="form-group">
                                <fieldset>
                                    <legend style="margin-bottom: 1px;">
                                        Total Kembali
                                    </legend>
                                    <div class="messages">
                                        <li class="right" style=" list-style-type: none;">
                                            <div class="message show_total" style="border: 1px solid #9AC9F4;margin: 0px;width: auto;min-height: 75px;font-size: 80px;    padding: 10px 0px 9px 8px;background-color: rgba(5, 197, 205, 0.5);">
                                                <p class="money_back">0</p>
                                            </div>
                                        </li>
                                    </div>
                                </fieldset>
                        </div>
                    </div>
                    <div class="col-md-6" id="col-border-left" style="border-bottom: 1px solid #d0c8c8;">
                        <div class="box">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label id="text-left" class="control-label col-md-3">TOTAL AKHIR</label>
                                <div class="col-md-9">
                                  <input type="number" min="0" class="form-control" id="totaly" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="text-left" class="control-label col-md-3">DIBAYARKAN</label>
                                <div class="col-md-9">
                                  <input type="number" min="0" class="form-control" id="paytotal" placeholder="Uang yang dibayarkan">
                                </div>
                            </div>
                            <hr class="line-style"/>
                            <div class="form-group">
                                <div class="col-md-12">
                                <input type="hidden" id="keyTrans" value="">
                                  <button type="button" class="btn btn-default">Batalkan</button>
                                  <button type="button" id="print" class="btn btn-primary">Cetak</button>
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
    <script src="{!! asset('plugins/typeahead/typeahead.bundle.min.js') !!}" type="text/javascript"></script> 
    <script type="text/javascript">
        var itemId = [];
        $(document).on("keyup change",".qty",function(event){
            event.preventDefault();
            var qty         = $(this).val(),
                lastChar    = qty.slice(-1),
                id          = $(this).attr('id'),
                idKey       = id.split('_'),
                price       = $('.price_'+idKey[1]).val(),
                tempGT      = $('.grand_total').text();

            $('.subtotal_'+idKey[1]).text(parseInt(price)*parseInt(qty));
            $('.subtotalText_'+idKey[1]).val(parseInt(price)*parseInt(qty));

            var arrayData = $("#idList").val().split(",");
                sum = 0;
            $.each( arrayData, function( index, value ){
                sum += parseInt($(".subtotal_"+value).text().replace(/,/g, ''), 10);
            });
            $('.grand_total').text((sum != "NaN" ? sum : "0") );
            $('#totaly').val((sum != "NaN" ? sum : "0"));

        });

        $(document).on("keyup change","#paytotal",function(event){
            var value = $(this).val(),
                totally = $('#totaly').val();
                sumValue = parseInt(value) - parseInt(totally);

            $('.money_back').text((sumValue != "NaN" ? sumValue : "0"));
        });

        $(document).ready(function($) {
            postEven();
            var engine = new Bloodhound({
                prefetch: '{{url("")}}/find',
                remote: {
                    url: '{{url("")}}/find?q=%QUERY%',
                    wildcard: '%QUERY%',
                    'cache': false
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                nameContains: $('#typehead').val(),
                local: engine
            });

            $("#typehead").typeahead({
                hint: true,
                highlight: true,
                minLength: 0
            }, {
                source: engine.ttAdapter(),
                async:true,
                name: 'objects',
                displayKey: 'value',

                templates: {
                    empty: [
                        '<div style="width: 537px;" class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        $('#print').prop('disabled',true);
                        return '<a class="list-group-item">' + data.name + '</a>'
                    }
                }
            });

            $('#typehead').bind('typeahead:select', function(ev, suggestion) {
                var diskon = 0;
                if (suggestion.stock === null) {
                    sweetAlert("Oops...", "Stok di Gudang tidak habis!", "error");
                    return false;                    
                }

                var stock = suggestion.stock.stok;
                if (stock < 1) {
                    sweetAlert("Oops...", "Stok di Gudang tidak habis!", "error");
                    return false;
                };

                if ($.inArray(suggestion.id, itemId) < 0) {
                    $('#table').append('<tr>'+
                            '<td>'+'<input type="hidden" name="item[]" value="'+suggestion.id+'">'+
                                '<button type="button" class="btn btn-danger" style="padding: 15px 6px;">'+
                                    '<span class="sname" id="">'+suggestion.name+'</span>'+
                                '</button></td>'+
                            '<td><input type="hidden" class="price_'+suggestion.id+'" value="'+suggestion.pricelist.selling_price+'" >'+suggestion.pricelist.selling_price+'</td>'+
                            '<td><input type="hidden" name="discount[]" value="'+diskon+'" class="discount_'+suggestion.id+'" >'+diskon+'</td>'+
                            '<input type="hidden" id="stok_'+suggestion.id+'" value="'+stock+'" class="stok">'+
                            '<td><input type="number" id="qty_'+suggestion.id+'" min="0" value="0" class="qty form-control" name="qty[]" ></td>'+
                            '<td><input type="hidden" name="amount[]" class="subtotalText_'+suggestion.id+'">'+
                            '<label id="subtotal" class="subtotal_'+suggestion.id+'">0</label></td>'+
                            '<td>'+
                                '<button type="button" id="linkdelete" data-id="'+suggestion.id+'" class="delete_item btn btn-flat btn-danger btn-sm" '+ 
                                   'data-toggle="tooltip" data-original-title="Edit">'+
                                   '<i class="fa fa-trash"></i> Delete'+
                                '</button>'+
                            '</td>'+
                        '</tr>');
                    itemId.push(suggestion.id);
                }
                $("#idList").val(itemId);
            });

        });

        $( document ).on( "click", ".delete_item", function( e ) {
            var jwb = confirm('Yakin Menghapus Item ini ? ');
            if(jwb){
                $(this).parent().fadeOut('slow', function() {
                    $(this).parent().remove();
                    itemId.splice( $.inArray($(this).attr("data-id"),itemId) ,1 );
                });
            }
        });   

        function postEven(){
            // $('#print').attr('disabled',false);
            $('form#posAction').submit(function(event) {
                event.preventDefault(); 
                var form = $(this);
                $.ajax({
                  type: form.attr('method'),
                  url: form.attr('action'),
                  data: form.serialize()
                }).always(function(data) {
                    $("div#divLoading").addClass('show');
                }).done(function(data) {
                    $('#keyTrans').val(data['id_trans']);
                    clearDefault();
                    itemId = [];
                    $("div#divLoading").removeClass('show');
                    $('#print').removeAttr('disabled');
                    $('#print').attr('disabled',false);
                }).fail(function(data) {

                });
            });
        }

        function postEvenValidation(){

        }

        function clearDefault(){
            $('#table tr:not(:first)').remove();
            $('.money_back').text("0");
            $('.grand_total').text("0");
            $('#totaly').val("0");
            $('#paytotal').val("0");
        }

        $("#print").click(function() {
            var key = $('#keyTrans').val();
            var url = "{!! url('') !!}"+"/posPdf/"+key;
            window.open(url, "_blank");
        })

    </script>
@stop