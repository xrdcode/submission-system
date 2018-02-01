$(document).ready(function() {
    $.fn.select2.defaults.set( "theme", "bootstrap" );
    /// EVERY AJAX REQUEST PROTECT THE BUTTON
    $(document).ajaxStart(function() {
        $('button, .btn').prop('disabled', true);
    });

    $(document).ajaxComplete(function() {
        $('button, .btn').prop('disabled', false);
        $('.btn-disabled').prop('disabled', true);
    });

    // FORCE DISABLED BUTTON
    $('.btn-disabled').click(function(e) {
        e.preventDefault();
        return;
    });

    // TOOLTIP TOGGLE
    $('[data-toggle="tooltip"]').tooltip();

    $(".select2-multiple").select2({
        placeholder: "choose",
        width: "100%"
    });

    $(".select2-single").select2({
        placeholder: "choose",
        width: "100%"
    });

    $("table.dataTable").resize();
    $(window).resize(function () {
        $("table.dataTable").resize();
    });

});

function refreshTable(tableid) {
    var table = $(tableid).DataTable();
    table.draw();
}

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


///// CUSTOM FILE INPUT //////
$(function() {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                //if( log ) alert(log);
            }

        });
    });

});