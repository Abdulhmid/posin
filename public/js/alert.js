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
                            notif_error("Deleted Success");
                            $('table').DataTable().ajax.reload();
                        }
                    });
                }

            }
        });
}

function notif_success(msg)
{
    new PNotify({
        title: 'Success Message',
        text: msg,
        type: 'success'
    });
}

function notif_error(msg)
{
    new PNotify({
        title: 'Error Message',
        text: msg,
        type: 'error'
    });
}

function notif_info(msg)
{
    new PNotify({
        title: 'Information Message',
        text: msg,
        type: 'info'
    });
}

function notif_warning(msg)
{
    new PNotify({
        title: 'Warning Message',
        text: msg
    });
}
