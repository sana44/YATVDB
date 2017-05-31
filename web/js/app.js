$(document).ready(function() {
    $('.js-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});

$(document).ready(function(){
    $(window.location.hash).addClass('highlight');
});
