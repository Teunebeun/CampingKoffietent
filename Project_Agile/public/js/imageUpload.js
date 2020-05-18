document.getElementById('image_upload').onchange = function (evt) {
    let tgt = evt.target || window.event.srcElement,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {

        let fr = new FileReader();
        fr.onload = function () {
            if (isFileImage(files[0])) {
                document.getElementById('profile_picture').src = fr.result;
            } else {
                document.getElementById('image_upload').value = "";
            }
        };
        fr.readAsDataURL(files[0]);
    }

    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
};

function isFileImage(file) {
    return file && file['type'].split('/')[0] === 'image';
}


document.getElementById('clear-profile-picture').addEventListener('click', function (event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('image_upload').value = "";
    document.getElementById('profile_picture').src = "http://" + location.host + "/img/profile_picture_placeholder.svg";
    document.getElementById("imageValue").value = "";

});
