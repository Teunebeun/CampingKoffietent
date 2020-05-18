let video = document.getElementById("insta-vid");
let button = document.getElementById("insta-vid-button");
let content = document.getElementById("insta-content");
let videoOverlay = document.getElementById("insta-vid-overlay");


content.addEventListener("click", goToInsta);
if(button != null){
    button.addEventListener("click", play);
}


function play(){
    if(video.paused) {
        video.play();
        videoOverlay.style.visibility = "hidden";
    }
    else {
        video.pause();
        videoOverlay.style.visibility = "visible";
    }
}

function goToInsta(){
    let url = "https://www.instagram.com/" + document.getElementById("insta-username").textContent;
    window.open(url , "_blank")
}
