@extends('layouts.admin')
@section('style')
    <link href="{!! asset('plugins/tag-it/jquery.tagit.css') !!}" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('plugins/tag-it/tagit.ui-zendesk.css') !!}" rel="stylesheet" type="text/css"/>
    <link href="{!! asset('plugins/sweet-alert/sweet-alert.css') !!}" rel="stylesheet" type="text/css"/>
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
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript"></script>
    <script src="{!! asset('plugins/tag-it/tag-it.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('plugins/ezdz/jquery.ezdz.min.js') !!}" type="text/javascript"></script>   
    <script src="{!! asset('js/alert.js') !!} " type="text/javascript"></script>
    <script src="{!! asset('plugins/sweet-alert/sweet-alert.js') !!} " type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            @if(GLobalHelper::actionUrl() == "edit")
                $("#module_name").keypress(function(e){ 
                    e.preventDefault(); 
                });
                $('#tagType').tagit({
                    readOnly : true
                });
            @endif

            $('#module_name').keyup(function(){
                this.value = this.value.toLowerCase();
            });

            $('#tagType').tagit({
                showAutocompleteOnFocus : true,
                placeholderText: "Function Name",
                onTagClicked: function(event, ui) {
                    swal({   
                        title: "Change Function",   
                        text: "Only Use Comma (,)",   
                        type: "input",   
                        showCancelButton: true,   
                        closeOnConfirm: false,   
                        animation: "slide-from-top"
                    }, 
                    function(inputValue){   
                        if (inputValue === false) return false;      
                        if (inputValue === "") {     
                            swal.showInputError("Can't Empty!");     
                            return false   
                        } 
                        swal("Success!", "Function : " + inputValue, "success");
                        $("#tagType").tagit("removeAll");
                        var arrayList = inputValue.split(','); 
                        $.each( arrayList, function( index, value ){
                            $("#tagType").tagit("createTag", value);
                        });

                    });
                    jQuery('.sweet-alert input[type=text]:first' ).val($("#tagType").val());
                }
            });
            $('#tagTypeAlias').tagit({
                showAutocompleteOnFocus : true,
                placeholderText: "Function Alias Name",
                onTagClicked: function(event, ui) {
                    swal({   
                        title: "Change Alias Function",   
                        text: "Must use comma (,)",   
                        type: "input",   
                        showCancelButton: true,   
                        closeOnConfirm: false,   
                        animation: "slide-from-top",   
                        inputPlaceholder: "Write something"
                    }, 
                    function(inputValue){   
                        if (inputValue === false) return false;      
                        if (inputValue === "") {     
                            swal.showInputError("Can't Empty!");     
                            return false   
                        } 
                        swal("Success!", "Alias Function : " + inputValue, "success");
                        $("#tagTypeAlias").tagit("removeAll");
                        var arrayList = inputValue.split(','); 
                        $.each( arrayList, function( index, value ){
                            $("#tagTypeAlias").tagit("createTag", value);
                        });

                    });
                    jQuery('.sweet-alert input[type=text]:first' ).val($("#tagTypeAlias").val());
                }
            }); 

            $("input#module_name").on({
                keydown: function(e) {
                  if (e.which === 32)
                    return false;
                },
                change: function() {
                  this.value = this.value.replace(/\s/g, "");
                }
            });

            $( "form" ).submit(function( event ) {
                var function_name = ($("#tagType").val() == "" ? 0 : ($("#tagType").val()).split(',').length ) ;
                var function_alias = ($("#tagTypeAlias").val() == "" ? 0 : ($("#tagTypeAlias").val()).split(',').length ) ;

                if (function_name != function_alias) {
                    sweetAlert("Oops...", "Alias Name must same with Function Name Total!", "error");
                    return false;
                }else{
                    return true;
                }
            });           
        });
    </script>
@stop