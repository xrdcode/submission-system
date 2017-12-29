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
                } else {
                    showValidationError(data, me);
                }
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



function generateHelpBlock(val) {
    return '<span class="help-block">' +
        '<strong>' + val + '</strong>' +
        '</span>';
}