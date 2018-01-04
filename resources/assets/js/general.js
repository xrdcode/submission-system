$(document).ready(function() {
    $(document).ajaxStart(function() {
        $('button, .btn').prop('disabled', true);
    });

    $(document).ajaxComplete(function() {
        $('button, .btn').prop('disabled', false);
    })
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