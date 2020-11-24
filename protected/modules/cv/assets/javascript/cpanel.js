var vue;

function onAddExperienceValidated(form, data, hasError) {
    if (!hasError) {
        $.ajax({
            "type": "POST",
            'dataType': 'json',
            "url": $('#experience-form').prop('action'),
            "data": form.serialize(),
            "beforeSend": function (xhr) {
                $('#experience-form input[type="submit"]').prop('disabled', true);
            },
            "always": function () {
                $('#experience-form input[type="submit"]').prop('disabled', false);
            },
            "success": function (json) {
                //var json = jQuery.parseJSON(result);
                if (json.status == 'success') {
                    $('#modal-common').html('').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    toastr.success(json.msg, '', {
                        "closeButton": true,
                        "newestOnTop": true,
                        "preventDuplicates": true,
                        "showDuration": "1000",
                    });
                    vue.fetchData(1);
                }
                else {
                    toastr.error(json.msg);
                }
            },
        });
    }
}
