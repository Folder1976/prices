$(document).ready(function() {
    $('#designer-info').click(function() {
        $('#block-' + $(this).attr('id')).slideToggle(250);
        $('#block-' + $(this).attr('id')+"-cut").toggleClass('hide');
        $(this).toggleClass('hide');
    });
})