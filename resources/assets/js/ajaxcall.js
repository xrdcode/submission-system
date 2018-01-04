/*
    id = id form
    onsuccess & onerror
 */
function ajaxSaveUpdate(id, onsuccess, onerror) {
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

                    // Custom Call Back

                    if(isFunction(onsuccess)) {
                        onsuccess.call(this);
                    }

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

function showAlert(message, type, title, timeout) {
    if(typeof timeout === 'undefined') timeout = 5000;
    $.notify({
        title: title,
        message : message,
        mouse_over : 'pause'
    },{
        type : type,
        newest_on_top : false,
        delay: timeout
    });
}

function generateHelpBlock(val) {
    return '<span class="help-block">' +
        '<strong>' + val + '</strong>' +
        '</span>';
}

function generateErrorLoginDOM(val) {
    return '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' + '<span class="help-block">';
}

function isFunction(v) {
    if(isDefined(v)) if(v instanceof Function) return true;
    return false;
}

function isDefined(v) {
    if(typeof v  !== "undefined") return true;
    return false;
}

function ajaxAuth(formid) {

    $(formid).on('submit', function(e) {
        e.preventDefault();

        var me = $(this);

        var u = $(this).attr('action');
        $.ajax({
            url : u,
            method : 'POST',
            data : $(me).find("input").serialize(),
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    location.reload();
                }
            },
            error: function (xHr) {
                if(xHr.status == 422) {
                    var resp = $.parseJSON(xHr.responseText);
                    $(me).find('.has-error').removeClass('has-error');
                    $(me).find('.form-control-feedback').remove();
                    $.each(resp, function(errName,errVal) {
                        var target = $('[name=' + errName + ']');
                        $(target).closest('.form-group').removeClass('has-error').addClass('has-error').find('.form-control-feedback').remove();
                        $(target).after(generateErrorLoginDOM());
                        showAlert(errVal.toString(),"warning", "", 1000);
                    });

                } else {
                    showAlert("Oooops.. something when wrong..", "danger", "Error:");
                }
            },

        })
    });
}

function authAlert(arrval) {

}