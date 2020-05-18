let button = document.getElementById('add-other-site-button');
let otherSitesContainer = document.getElementsByClassName("other-sites-container")[0];

button.addEventListener("click", addOtherSite);
makeDeleteListeners();


function makeDeleteListeners() {
    let deleteButtons = document.querySelectorAll(".other-delete");
    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener("click", deleteOtherSite);
    }
}

function addOtherSite() {
    let otherSite = document.createElement("div");
    otherSite.className = "other-site";
    otherSite.innerHTML = getOtherSiteHTML();
    otherSitesContainer.appendChild(otherSite);
    makeDeleteListeners();
    window.scrollTo(0,document.body.scrollHeight);
}

function deleteOtherSite() {
    let a = this.parentNode.parentNode;
    a.parentNode.removeChild(a);
}

function getOtherSiteHTML() {
    return `<div class="other-site-name-container">
                <p class="input-header"> Naam - Nieuw:</p>
                <button class="delete-btn other-site-button other-delete" type="button"> x </button>
            </div>

            <input class="input"
                   type="text"
                   maxlength="60"
                   placeholder="Voeg naam toe"
                   name="otherSitesName[]"
                   required/>

            <p class="input-header"> Link - Nieuw:</p>
            <input class="input"
                   type="url"
                   maxlength="200"
                   placeholder="Voeg link toe"
                   name="otherSitesLink[]"
                   required/>
            <br><br>`;
}




