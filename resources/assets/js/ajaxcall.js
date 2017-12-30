function ajaxSaveUpdate(id) {
    $(id).submit(function(e) {
        e.preventDefault();

        var me = $(this);

        $.ajax({
            type: 'post',
            url: $(this).attr("action"),
            data: $(this).find('input, select, textarea').serialize(),
            dataType: 'json',
            success: function(data) {
                if(!data.errors) {
                    $(me).find('.has-error').removeClass('has-error');
                    $(me).find('.help-block').remove();

                    if($(me).closest('.modal').length > 0) {
                        $(me).closest('.modal').modal('hide');
                    }
                    showAlert("Data has been saved !", "success", "Success:");
                } else {
                    showValidationError(data, me)

                }
            },
            error: function(xHr) {
                showAlert("Oooops.. something when wrong..", "danger", "Error:");
            }
        });

    });
}

function ajaxSaveWithPrompt() {

}

function showValidationError(data, form) {
    $(form).find('.has-error').remove();
    $(form).find('.help-block').remove();
    $.each(data.errors, function(errName,errVal) {
        var target = $('[name=' + errName + ']');
        $.each(errVal, function(i, val) {
            $(target).closest('.form-group').removeClass('has-error').addClass('has-error').find('.help-block').remove();
            $(target).after(generateHelpBlock(val));
        });
    });
}

function showAlert(message, type, title) {
    $.notify({
        title: title,
        message : message,
        mouse_over : 'pause'
    },{
        type : type,
        newest_on_top : true
    });
}

function generateHelpBlock(val) {
    return '<span class="help-block">' +
        '<strong>' + val + '</strong>' +
        '</span>';
}