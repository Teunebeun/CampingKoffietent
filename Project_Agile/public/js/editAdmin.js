let hiddenInput = document.getElementById("imageValue");
let image =  document.getElementById("profile_picture");
const regex = /(\/img\/user\/).*/;
let src;
if (image.src.match(regex) != null) {
    src = image.src.match(regex)[0];
}
hiddenInput.value = src;


let divs = document.querySelectorAll(".label_edit");

divs.forEach(function (div) {
    div.querySelector(".edit").addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        let input = div.querySelector('.input');
        input.removeAttribute("readonly");
        input.focus();
        input.addEventListener("blur", function (event) {
            event.preventDefault();
            input.setAttribute('readonly', 'readonly');
        });
    }, false);
});
