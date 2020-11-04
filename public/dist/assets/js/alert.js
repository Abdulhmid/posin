function swal_alert(el, custom_msg, method, token) {

    custom_msg = custom_msg || "Are You Sure To Delete ?";
    method = method || "get";

    msg = custom_msg;
    swal({
            title: msg,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes!',
            closeOnConfirm: true
        },
        function (isConfirm) {
            if (isConfirm) {
                if (method == "get") {
                    location.replace(el);
                } else {

                    $.ajax({
                        url: el.href,
                        type: 'post',
                        data: {_method: 'delete', _token: token},
                        success: function (result) {
                            $(".alert").remove();

                            $(".box-body").prepend(
                                '<div class="no-print alert alert-dismissable autohide full-alert">' +
                                '<div class="callout callout-success">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                                '<h4><i class="fa fa-info"></i> ' + result.message + '</h4>' +
                                '</div>' +
                                '</div> '
                            );

                            $('.autohide').delay(5000).fadeOut('slow');

                            $('table').DataTable().ajax.reload();
                        }
                    });
                }

            }
        });
}





