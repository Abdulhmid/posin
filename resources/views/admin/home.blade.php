@extends('layouts.admin')

@section('style')
    <link href="{!! asset('plugins/sweet-alert/sweet-alert.css') !!} " rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .table thead th{
            background: #eb5b4f; 
        }
        .title-color{
            font-weight: bold;
            color: #a52f26;
        }
    </style>
@endsection

@section('content')
<div class="row pos">
    <div class="col-md-12">
        <div class="well well-home">
            <div class="row">
                <div class="col-xs-6">
                    <h1 class="box-title"> DAFTAR BELANJA</h1>
                </div>
                <div class="col-xs-6">
                    <div class="pull-right">
                        <h1 class="box-title"> NAMA TOKO</h1>
                    </div>
                </div>
            </div>
            <div class="box-body">  
                <form method="POST" action="/post" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input type="text" id="idList" value="">
                    <div class="form-group">
                        <div id="the-basics">
                            <!-- <input class="form-control typeahead" name="name" type="text" value="" id="name" placeholder="Cari Produk Berdasarkan Kode atau Nama"> -->
                            <input id="name" name="name" type="text" style="width:534px;" class="form-control typeahead" placeholder="Cari Produk Berdasarkan Kode atau Nama..." autocomplete="off" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <table id="table" class="table table-striped dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th width="213px">Photo</th>
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
                        <hr/>
                        <table id="table" class="table table-striped dataTable no-footer">
                            <thead>
                                <tr>
                                    <th rowspan="5">Total Bayar : </th>
                                    <th width="153px"><p class="grand_total">0</p></th>
                                    <th width="153px"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-xs-4" style="padding: 0;">
                                        <div class="btn-group-vertical btn-block">
                                            <button type="button" style="height: 87px;border-radius: 0px; font-size: 50px;font-family: serif;" class="btn btn-default btn-block btn-flat" id="reset">Batal</button>
                                        </div>
                                    </div>
                                    <div class="col-xs-4" style="padding: 0;">
                                        <div class="btn-group-vertical btn-block">
                                            <button type="submit" style="height: 87px;border-radius: 0px; font-size: 50px;font-family: serif;" class="btn btn-posale btn-block btn-flat" id="reset">Bayar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{!! asset('plugins/sweet-alert/sweet-alert.js') !!} " type="text/javascript"></script>
    <script src="{!! asset('plugins/typeahead/typeahead.bundle.min.js') !!}" type="text/javascript"></script> 
    <script type="text/javascript">

        $( document ).on( "click", ".delete_item", function( e ) {
            var jwb = confirm('Yakin Menghapus Item ini ? ');
            if(jwb){
                $(this).parent().fadeOut('slow', function() {
                    $(this).parent().remove();
                });
            }else{
                alert('batal dihapus');
            }
        });   

        $(document).on("keyup change",".qty",function(event){
            event.preventDefault();
            var qty         = $(this).val(),
                lastChar    = qty.slice(-1),
                id          = $(this).attr('id'),
                idKey       = id.split('_'),
                price       = $('.price_'+idKey[1]).val(),
                tempGT      = $('.grand_total').text();

            $('.subtotal_'+idKey[1]).text(parseInt(price)*parseInt(qty));

            sum = 0;
            $("#subtotal").each(function(index,val) {
                console.log(index);
                console.log(val);
                sum += parseInt($(this).text());
            });
            $('.grand_total').text((sum != "NaN" ? sum : "0") );

        });

        $(document).ready(function($) {

            var engine = new Bloodhound({
                prefetch: '/find',
                remote: {
                    url: '/find?q=%QUERY%',
                    wildcard: '%QUERY%',
                    'cache': false
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                nameContains: $('.typeahead').val(),
                local: engine
            });

            $(".typeahead").typeahead({
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
                        return '<a class="list-group-item">' + data.name + '</a>'
                    }
                }
            });

            $('.typeahead').bind('typeahead:select', function(ev, suggestion) {
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

                var itemId = [];

                if ($.inArray(suggestion.id, itemId) < 0) {
                    $('#table > tbody:last-child').append('<tr>'+
                            '<td>'+ 
                                '<button type="button" class="btn btn-danger" style="padding: 15px 6px;">'+
                                    '<span class="sname" id="">'+suggestion.name+'</span>'+
                                '</button></td>'+
                            '<td>'+
                                '<a class="thumbnail" href="#">'+
                                    '<img class="img-responsive" src="http://placehold.it/400x300" alt="">'+
                                '</a>'+
                            '</td>'+
                            '<td><input type="hidden" class="price_'+suggestion.id+'" value="'+suggestion.pricelist.selling_price+'" >'+suggestion.pricelist.selling_price+'</td>'+
                            '<td><input type="hidden" value="" class="discount_'+suggestion.id+'" >'+diskon+'</td>'+
                            '<input type="hidden" id="stok_'+suggestion.id+'" value="'+stock+'" class="stok">'+
                            '<td><input type="number" id="qty_'+suggestion.id+'" min="0" value="0" class="qty form-control" name="qty[]" ></td>'+
                            '<td><label id="subtotal" class="subtotal_'+suggestion.id+'">0</label></td>'+
                            '<td>'+
                                '<button type="button" id="linkdelete" class="delete_item btn btn-flat btn-danger btn-sm" '+ 
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

    </script>
@stop