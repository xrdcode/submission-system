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
                        onsuccess.call(this, data);
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
    $(form).find('.has-error').removeClass('has-error');
    $(form).find('.help-block').remove();
    $.each(data.errors, function(errName,errVal) {
        var target = $('[name^=' + errName + ']');
        $.each(errVal, function(i, val) {
            if ($(target).closest(".form-group").find("span.select2").length > 0) {
                $(target).closest(".form-group").removeClass('has-error').addClass('has-error').find('.form-control-feedback').remove();
                $(target).closest(".form-group").find("span.select2").after(generateHelpBlock(val));
            } else if ($(target).closest('.input-group').length > 0) {
                $(target).closest('.form-group').removeClass('has-error').addClass('has-error').find('.form-control-feedback').remove();
                $(target).closest('.input-group').after(generateHelpBlock(val));
            } else {
                $(target).closest('.form-group').removeClass('has-error').addClass('has-error').find('.form-control-feedback').remove();
                $(target).after(generateHelpBlock(val));
            }
        });
    });
}

function showAlert(message, type, title, timeout, callback) {
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

    if(isFunction(callback)) {
        callback.call(this);
    }
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


/**
 * Must btn and have data-action
 * @param btnid
 */
function toggleActivate(btnid, onsuccess, onerror) {
    $('body').on('click', btnid, function(e) {
        e.preventDefault();
        var me = $(this);
        $.ajax({
            url: $(me).data('action'),
            method: 'post',
            data: { data: $(me).data('id') },
            dataType: 'json',
            success: function(dt) {
                if(isFunction(onsuccess)) {
                    onsuccess.call(this, dt);
                } else {
                    showAlert("Toggle activation success", "success", "Success:");
                }
            },
            error: function(xHr) {
                if(isFunction(onerror)) {
                    onsuccess.call(this, xHr);
                } else {
                    showAlert("Oooops.. something when wrong..", "danger", "Error:");
                }
            }
        });
    });
}

/**
 * Must btn and have data-action
 * @param btnid
 */
function toggleDelete(btnid, onsuccess, onerror) {
    $('body').on('click', btnid, function(e) {
        e.preventDefault();
        var me = $(this);
        //BootstrapDialog.confirm("<p>re you sure you want delete this data permanently?</p>", function(result) {
        BootstrapDialog.confirm({
            title: "Warning !",
            type: BootstrapDialog.TYPE_WARNING,
            size: BootstrapDialog.SIZE_SMALL,
            message: "Are you sure you want delete this data?",
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: $(me).attr('href'),
                        method: 'post',
                        data: { data: $(me).data('id') },
                        dataType: 'json',
                        success: function(dt) {
                            if(isFunction(onsuccess)) {
                                onsuccess.call(this, dt);
                            } else {
                                showAlert("Data has been deleted", "success", "Success:");
                            }
                        },
                        error: function(xHr) {
                            if(isFunction(onerror)) {
                                onsuccess.call(this, xHr);
                            } else {
                                showAlert("Oooops.. something when wrong..", "danger", "Error:");
                            }
                        }
                    });
                }
            }
        });

    });
}

/**
 * Must btn and have data-action
 * @param btnid
 */
function toggleRecover(btnid, onsuccess, onerror) {
    $('body').on('click', btnid, function(e) {
        e.preventDefault();
        var me = $(this);
        //BootstrapDialog.confirm("<p>re you sure you want delete this data permanently?</p>", function(result) {
        BootstrapDialog.confirm({
            title: "Warning !",
            type: BootstrapDialog.TYPE_WARNING,
            size: BootstrapDialog.SIZE_SMALL,
            message: "Are you sure you want recover this data?",
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: $(me).attr('href'),
                        method: 'post',
                        data: { data: $(me).data('id') },
                        dataType: 'json',
                        success: function(dt) {
                            if(isFunction(onsuccess)) {
                                onsuccess.call(this, dt);
                            } else {
                                showAlert("Data has been recovered", "success", "Success:");
                            }
                        },
                        error: function(xHr) {
                            if(isFunction(onerror)) {
                                onsuccess.call(this, xHr);
                            } else {
                                showAlert("Oooops.. something when wrong..", "danger", "Error:");
                            }
                        }
                    });
                }
            }
        });

    });
}

/**
 * Must btn and have data-action
 * @param btnid
 */
function toggleUndo(btnid, onsuccess, onerror) {
    $('body').on('click', btnid, function(e) {
        e.preventDefault();
        var me = $(this);
        //BootstrapDialog.confirm("<p>re you sure you want delete this data permanently?</p>", function(result) {
        BootstrapDialog.confirm({
            title: "Warning !",
            type: BootstrapDialog.TYPE_WARNING,
            size: BootstrapDialog.SIZE_SMALL,
            message: "Are you sure you want undo this action?",
            callback: function(result) {
                if(result) {
                    $.ajax({
                        url: $(me).data('action'),
                        method: 'post',
                        data: { data: $(me).data('id') },
                        dataType: 'json',
                        success: function(dt) {
                            if(isFunction(onsuccess)) {
                                onsuccess.call(this, dt);
                            } else {
                                showAlert("Undoing action success", "success", "Success:");
                            }
                        },
                        error: function(xHr) {
                            if(isFunction(onerror)) {
                                onsuccess.call(this, xHr);
                            } else {
                                showAlert("Oooops.. something when wrong..", "danger", "Error:");
                            }
                        }
                    });
                }
            }
        });

    });
}

/**
 * This function for instant edit on a detail field, ex. on table.
 * attributes component need :
 * 1 label with click-edit class
 * 1 input/select/etc with hide-n-seek class which contain data-action=<posturl> & data-id=<id> or you
 * can just adding custom callback
 *
 * Default : initHideNseek(null, null, null);
 *
 * @param onclicklabel
 * @param onfocusout
 * @param callback
 */
function initHideNseek(onclicklabel, onfocusout, callback) {

    $('body').on('click','.click-edit',function(e) {
        if(!isFunction(onclicklabel)) {
            $(this).hide();
            $(this).closest("td").find('.hide-n-seek').show();
            $(this).closest("td").find('.hide-n-seek').trigger('focus');
        } else {
            onclicklabel.call(this);
        }
    });


    $('body').on('focusout','.hide-n-seek', function() {
        if(isFunction(onfocusout)) {
            onfocusout.call(this);
        } else {
            $(this).hide();
            $(this).closest("td").find('.click-edit').show();
        }
    });

    $('body').on('change','input.hide-n-seek, textarea.hide-n-seek, select.hide-n-seek', function () {
        if(!isFunction(callback)) {
            var action = $(this).data('action');
            var id = $(this).data('id');
            var postData = $(this).serializeArray();
            var me = $(this);
            postData.push({name: "id", value: id});
            $.ajax({
                url: action,
                dataType: 'json',
                method: 'post',
                data: postData,
                success: function(data) {
                    var table = $(me).closest('table').DataTable()
                    table.draw();
                },
                error: function(xhr) {
                    var table = $(me).closest('table').DataTable();
                    table.draw();
                }

            });
        } else {
            callback.call(this);
        }
    });
}



//////////////// * USER ACTION * ////////////////////

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
                    $.each(resp, function (errName, errVal) {
                        var target = $('[name=' + errName + ']');
                        console.log($(target).closest('.input-group').length);
                        if ($(target).closest('.input-group').length > 0) {
                            $(target).closest('.form-group').removeClass('has-error').addClass('has-error').find('.form-control-feedback').remove();
                            $(target).closest('.input-group').after(generateErrorLoginDOM());
                        } else {
                            $(target).closest('.form-group').removeClass('has-error').addClass('has-error').find('.form-control-feedback').remove();
                            $(target).after(generateErrorLoginDOM());

                        }
                        showAlert(errVal.toString(), "warning", "", 1000);
                    });
                } else if(xHr.status == 423) {
                    var resp = $.parseJSON(xHr.responseText);
                    showAlert(resp.email, "warning", "Locked: ")
                } else {
                    showAlert("Oooops.. something when wrong..", "danger", "Error:");
                }
            },

        })
    });
}

function userSaveUpload(id, onsuccess, onerror) {
    $(id).submit(function(e) {
        e.preventDefault();

        var me = $(this);
        var formData = new FormData($(this)[0]);

        $(me).find('.has-error').removeClass('has-error');
        $(me).find('.help-block').remove();

        $.ajax({
            type: 'post',
            url: $(this).attr("action"),
            data: formData,
            contentType: false,
            processData: false,
            success: function(data, textStatus, jqXHR) {
                data = jqXHR.responseJSON;
                if(!data.errors) {

                    if($(me).closest('.modal').length > 0) {
                        $(me).closest('.modal').modal('hide');
                    }

                    if(isFunction(onsuccess)) {
                        onsuccess.call(this, data);
                    }
                } else {
                    showValidationError(data, me)
                }
            },
            error: function(xHr) {
                if(isFunction(onerror)) {
                    onerror.call(this, xHr);
                } else {
                    showAlert("Oooops.. something when wrong..", "danger", "Error:");
                }
            }
        });

    });
}

function loadListOption(selectid) {
    if($(selectid).data("need") !== undefined && $(selectid).data("need") !== "" ) {
        console.log($(selectid).data("need"));
        var src = $(selectid).data("need");
        $("body").on("change", src,function() {
            var id = $(this).val();
            console.log(id);
            var me = $(selectid);
            var url= $(selectid).data("src") + "/" + id;
            me.html("");
            $.get(url, function(dt) {
                $.map(dt, function(val, i) {
                    me.append("<option value='"+ i +"'>" + val + "</option>")
                });
            });
        });
        $($(selectid).data('need')).trigger("change");
    } else {
        $(selectid).ready(function(e) {
            var me = $(selectid);
            me.html("");
            var url= $(selectid).data("src");
            $.get(url, function(dt) {
                $.map(dt, function(val, i) {
                    me.append("<option value='"+ i +"'>" + val + "</option>")
                });
            });
        });
    }
}

function ajaxSignUp(formid) {
    $(formid).on('submit', function(e) {
        e.preventDefault();

        var me = $(this);

        var u = $(this).attr('action');
        $.ajax({
            url : u,
            method : 'POST',
            data : $(me).find("input, textarea").serialize(),
            dataType: 'json',
            success: function (response) {
                if(response) {
                    location.href = response.redirect;
                }
            },
            error: function (xHr) {
                console.log(xHr);
                if(xHr.status == 422) {
                    var resp = $.parseJSON(xHr.responseText);
                    $(me).find('.has-error').removeClass('has-error');
                    $(me).find('.form-control-feedback').remove();
                    $.each(resp, function(errName,errVal) {
                        var target = $('[name^=' + errName + ']');
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