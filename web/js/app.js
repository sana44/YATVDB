$(document).ready(function() {
    $('.js-datepicker').datepicker({
        dateFormat: 'dd-mm-yy'
    });
});

$(document).ready(function(){
    $(window.location.hash).addClass('highlight');
});
