$(document).ready(function() {
    $('formlogin').on('submit', function(e) {
       e.preventDefault();
       var u = $(this).attr('action');
       $.ajax({
           url : u,
           method : 'POST',
           data : $("input", this).serialize(),
           success: function (response) {

           },
           error: function (xHr) {

           }
       })
    });
});