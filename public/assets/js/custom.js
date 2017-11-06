$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( "#beg_work" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $('._actionBtn').on('click', function (elem) {
        var action = $(this).attr('data-action');
        var value = $(this).attr('data-val');
        elem.preventDefault();

        if (action === 'delete') {
            actionDelete(action, value);
        }
    });

    // For button delete employee
    function actionDelete(action, value) {
        var conf = confirm('Do you really want to delete the entry?');
        if (!conf) return;
        action = '/' + action;
        $.ajax(action, {
            type: 'DELETE',
            data: {'id': value},
            success: function (data) {
                location.href = data.model;
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    $('#_deletePhoto').on('click', function(elem) {
        var id = $('input#id').attr('value');
        if (! id) return;
        elem.preventDefault();
        $.ajax('/employee_delPhoto', {
            type: 'post',
            data: {id:id},
            success: function (data) {
                if (data) {
                    console.log(data);
                    $('img.img-thumbnail').attr('src', 'http://via.placeholder.com/100x100');
                }
            }
        });
    });

});