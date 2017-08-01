
/*
    Ui interaction code
*/

$('#browser-tab-btn').click(function(){
    $('#editor-tab').hide();
    $('#browser-tab').show();
    $('#screenshotBoard').show();
});
$('#editor-tab-btn').click(function(){
    $('#browser-tab').hide();
    $('#editor-tab').show();
    $('#screenshotBoard').hide();
});

var selectedItem = $('input[name=item]:checked', '#select-item-form').val();

$('#select-item-form').change(function(){
    selectedItem = $('input[name=item]:checked', '#select-item-form').val();
});

$('.jscolor').change(function(e){
    var strokeColor = $(e.target).val();
    drawSVG.setColor('#'+strokeColor);
});
