$(document).ready(function(){
    console.log('image-upload-init');
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-update').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image-input").change(function(){
        readURL(this); console.log('test');
        $('.image-upload-submit').removeClass('hidden');
    });

});