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
$(document).ready(function() {

});

function setupDateRange(idfrom, idto) {
    $(idfrom).datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        setDate: new Date(),
    });

    $(idto).datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        setDate: new Date(),
    });

    dateRangeEvent(idfrom, idto);
}

function dateRangeEvent(idfrom, idto) {
    $(idfrom).on("changeDate", function (e) {
        $(idto).data("datepicker").setStartDate(e.date);
    });
    $(idto).on("changeDate", function (e) {
        $(idfrom).data("datepicker").setEndDate(e.date);
    });
}
//# sourceMappingURL=ssmath.js.map
