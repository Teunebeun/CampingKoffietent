function readURL(input, imgId) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#' + imgId).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
