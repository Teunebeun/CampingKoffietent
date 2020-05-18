let currentlySelected = null;
let allDonationID = ['A'];

let activityTable = $('#select-initiative-container .table tr');
let activityPageNum = 1;
let campingbazenTable = $('#select-campingbazen-container .table tr');
let campingbazenPageNum = 1;
let applicationsTable = $('#select-application-container .table tr');
let applicationsPageNum = 1;
let fotosTable = $('#select-fotos-container .table tr');
let fotosPageNum = 1;

createPaginateButtons('activities');
paginateTable('activities', 1);

createPaginateButtons('campingbazen');
paginateTable('campingbazen', 1);

if (applicationsTable.length !== 0) {
    createPaginateButtons('applications');
    paginateTable('applications', 1);
}

function selectMenu(name) {
    let isActive = false;
    if (name === 'select-donation') {
        $('#donationSaveBtn')[0].setAttribute('onclick', 'saveDonation()');
    }

    if (name === 'select-activityform') {
        if (currentlySelected != null) {
            currentlySelected.style.display = "none";
        }
        currentlySelected = document.getElementById(name + "-container");
        currentlySelected.style.display = "block";
    } else {
        if (currentlySelected != null) {
            currentlySelected.style.display = "none";

            let btnClasses = document.getElementsByClassName("gg-arrow-right-selected");
            if (btnClasses[0] != null && btnClasses[0].classList !== undefined) {
                isActive = btnClasses[0].id === name;
                btnClasses[0].classList.replace("gg-arrow-right-selected", "gg-arrow-right");
            }

        }
        if (!isActive) {
            currentlySelected = document.getElementById(name + "-container");
            currentlySelected.style.display = "block";

            if (document.getElementById(name) != null) {
                document.getElementById(name).classList.replace("gg-arrow-right", "gg-arrow-right-selected");
            }
        } else {
            currentlySelected = null;
        }
    }
}

$('input[type="radio"]').on('change', function (e) {
    // set left container details for initiative
    let initiativeTitle = e.target.getAttribute('value');
    let labelText = $('#selectedInitiative')[0];
    let jsonFile = JSON.parse(initiativeTitle);
    labelText.classList.remove("null-selected");
    labelText.innerHTML = jsonFile['name'];

    if (jsonFile['id'] != 1) {
        let penElement = document.createElement('a');
        penElement.className = 'gg-pen';
        penElement.href = "javascript:void(0)";
        penElement.setAttribute('onclick', 'selectMenu(\'select-activityform\')');
        labelText.appendChild(penElement);
    }

    // set right container for activity form
    let activityName = $('#select-activityform-container #activityName')[0];
    let activityImage = $('#select-activityform-container #js-image-onscreen')[0];
    let activityDetails = $('#select-activityform-container #activityDetails')[0];
    activityName.value = jsonFile['name'];
    activityImage.src = jsonFile['picture'];
    activityDetails.value = jsonFile['description'];
});

$('input[type="checkbox"]').on('change', function (e) {
    if (e.target.parentNode.parentNode.id === 'select-repeat-container' ||
        e.target.parentNode.parentNode.id === 'select-donation-container') {
        return;
    }
    $('.selectedCampingbazen .label-text .null-selected').remove();
    let campingbaasJson = JSON.parse(e.target.getAttribute('value'));
    let labelDiv = $('.selectedCampingbazen .label-text')[0];

    if (e.target.checked) {
        let baasDiv = document.createElement('div');
        baasDiv.className = 'baas';
        baasDiv.id = campingbaasJson['id'];
        if (typeof campingbaasJson['vacancy_id'] === 'undefined') {
            baasDiv.id = "camp-" + campingbaasJson['id'];
        } else {
            baasDiv.id = "app-" + campingbaasJson['id'];
        }

        let linkElement = document.createElement('a');
        linkElement.setAttribute('href', 'javascript:void(0)');
        linkElement.onclick = function (e) {
            deleteFunction(this);
        };
        let deleteElement = document.createElement('i');
        deleteElement.className = 'gg-delete';
        deleteElement.id = campingbaasJson['firstname'];

        let nameElement = document.createElement('label');
        nameElement.className = 'selectedCampingbazen-item';
        nameElement.innerHTML = campingbaasJson['firstname']
            + ' '
            + (campingbaasJson['middlename'] == null ? '' : campingbaasJson['middlename'])
            + ' '
            + (campingbaasJson['lastname'] == null ? '' : campingbaasJson['lastname']);

        linkElement.appendChild(deleteElement);
        baasDiv.appendChild(linkElement);
        baasDiv.appendChild(nameElement);
        labelDiv.appendChild(baasDiv);
    } else {
        if (typeof campingbaasJson['vacancy_id'] === 'undefined') {
            labelDiv.querySelector("#camp-" + campingbaasJson['id']).remove();
        } else {
            labelDiv.querySelector("#app-" + campingbaasJson['id']).remove();
        }
        checkCampingbazenEmpty(labelDiv);
    }
});

$('#is-repeated').on('change', function (e) {
    if (e.target.checked) {
        $('#repeatAmount').prop('readonly', false);
        $('#max-btn').prop('disabled', false);
    } else {
        $('#repeatAmount').prop('readonly', true);
        $('#max-btn').prop('disabled', true);

    }
});

$('#donation-is_money').on('change', function (e) {
    let el = $('#donationItem');
    if (e.target.checked) {
        el.prop('readonly', true);
        el.prop('value', 'Euro');
    } else {
        el.prop('readonly', false);
        el.prop('value', '');
    }
});

function maxBtnHandler() {
    $('#repeatAmount').prop('value', 99);
}

function deleteFunction(self) {
    self.parentNode.remove();
    let inputName = self.parentNode.id;
    let test;
    if (inputName.split('-')[0] === 'camp') {
        test = $('#select-campingbazen-container .table tr .select-container .campingbaasSwitch [id=\'' + inputName.split('-')[1] + "\']");
    } else {
        test = $('#select-application-container .table tr .select-container .applicationSwitch [id=\'' + inputName.split('-')[1] + "\']");
    }
    test[0].checked = false;
    checkCampingbazenEmpty();
}

function checkCampingbazenEmpty() {
    let labelDiv = $('.selectedCampingbazen .label-text')[0];
    if (labelDiv.querySelector('.baas') == null) {
        let nullLabel = document.createElement('label');
        nullLabel.className = 'null-selected';
        nullLabel.classList.add('label-text');
        nullLabel.innerHTML = 'Voeg een campingbaas toe';

        labelDiv.appendChild(nullLabel);
    }
}

function createPaginateButtons(tableName) {
    let paginateTable = getTable(tableName);
    let filteredTable = paginateTable.toArray().filter(row => row.className === 'searched');
    let numberOfButtons = Math.ceil(filteredTable.length / 8);
    let paginateRow = paginateTable.toArray().pop().querySelector("ul");
    let prevButton = paginateRow.querySelector("#paginate-prev").parentNode;
    let nextButton = paginateRow.querySelector("#paginate-next").parentNode;

    paginateRow.textContent = '';
    paginateRow.appendChild(prevButton);

    if (numberOfButtons !== 1) {
        paginateRow.style.display = "block";
        for (let $i = 1; $i <= numberOfButtons; $i++) {
            let newButton = document.createElement('li');
            newButton.className = "page-item";

            let newLink = document.createElement('a');
            newLink.className = "page-link";
            newLink.id = "paginate-" + $i;
            newLink.href = "javascript:void(0)";
            newLink.setAttribute("onclick", "paginateTable(\'" + tableName + "\', " + $i + ")");
            newLink.innerHTML = $i.toString();

            newButton.appendChild(newLink);

            paginateRow.appendChild(newButton);
        }
    } else {
        paginateRow.style.display = "none";
    }
    paginateRow.appendChild(nextButton);
}

function filterTable(tableName, searchButton) {
    let searchText = searchButton.previousElementSibling.value.toLowerCase();

    getTable(tableName).toArray().forEach(function (entry) {
        if (entry.className !== 'not-clickable' && entry.querySelector('th') == null) {
            if (searchText === '' || /^\s+$/.test(searchText)) {
                entry.className = "searched";
            } else {
                if (entry.querySelector('a').innerText.toLowerCase().includes(searchText)) {
                    entry.className = "searched";
                } else {
                    entry.className = null;
                    entry.style.display = "none";
                }
            }
        }
    });

    createPaginateButtons(tableName);
    paginateTable(tableName, 1);
}

function paginateTable(tableName, pageNum) {
    setPageNum(tableName, pageNum);
    let tb = getTable(tableName);
    let filteredTable = tb.toArray().filter(row => row.className === 'searched');

    tb.find('.disabled').each(function () {
        this.classList.remove('disabled');
    });

    tb.find('.active').each(function () {
        this.classList.remove('active');
    });

    if (pageNum === 1) {
        tb.find('#paginate-prev').addClass('disabled');
    }

    if (pageNum === Math.ceil(filteredTable.length / 8)) {
        tb.find('#paginate-next').addClass('disabled');
    }

    tb.find('#paginate-' + pageNum).addClass('active disabled');

    let $x = 0;
    filteredTable.forEach(function (i) {
        let lastRow = (pageNum * 8) - 1;
        let firstRow = lastRow - 8;
        if ($x <= lastRow && $x > firstRow) {
            i.style.display = "table-row";
            if ($x % 2 === 0) {
                i.style.background = "white";
            } else {
                i.style.background = "#F2F2F2";
            }
        } else {
            i.style.display = "none";
        }
        $x++;
    });
}

function paginateTablePrevious(tableName) {
    let pn = getPageNum(tableName);
    if (pn > 1) {
        paginateTable(tableName, pn - 1);
    }
}

function paginateTableNext(tableName) {
    let pn = getPageNum(tableName);
    let tb = getTable(tableName).toArray().filter(row => row.className === 'searched');
    if (pn < Math.ceil(tb.length / 8)) {
        paginateTable(tableName, pn + 1);
    }
}

function getTable(tableName) {
    switch (tableName) {
        case ('activities'):
            return activityTable;
        case ('campingbazen'):
            return campingbazenTable;
        case('applications'):
            return applicationsTable;
        case('fotos'):
            return fotosTable;
        default:
            console.log("Couldn't get table" + tableName);
            return null;
    }
}

function getPageNum(tableName) {
    switch (tableName) {
        case ('activities'):
            return activityPageNum;
        case ('campingbazen'):
            return campingbazenPageNum;
        case('applications'):
            return applicationsPageNum;
        case('fotos'):
            return fotosPageNum;
        default:
            console.log("Couldn't get pageNum" + tableName);
            return null;
    }
}

function setPageNum(tableName, pageNum) {
    switch (tableName) {
        case ('activities'):
            activityPageNum = pageNum;
            break;
        case ('campingbazen'):
            campingbazenPageNum = pageNum;
            break;
        case('applications'):
            applicationsPageNum = pageNum;
            break;
        case('fotos'):
            fotosPageNum = pageNum;
            break;
        default:
            console.log("Couldn't set pageNum" + tableName);
            break;
    }
}

function saveVacancy() {
    let vacancyTitle = document.getElementById('vacancyTitle').value;
    let label = $("#vacancy-name")[0];
    if (vacancyTitle === '') {
        label.innerHTML = 'Voeg een vacature toe';
        label.classList.add('null-selected');
    } else {
        label.innerHTML = vacancyTitle;
        label.classList.remove("null-selected");
    }
    selectMenu('select-vacancy');
}

function deleteVacancy() {
    document.getElementById('vacancyTitle').value = null;
    document.getElementById('vacancyNumber').value = null;
    document.getElementById('vacancyDetails').value = null;

    let label = $("#vacancy-name")[0];
    label.innerHTML = 'Voeg een vacature toe';
    label.classList.add('null-selected');
    selectMenu('select-vacancy');
}

function saveDonation() {
    let allInput = $('#select-donation-container input, #select-donation-container textarea');
    let resultJson = {};

    let last = allDonationID[allDonationID.length - 1].charCodeAt(0);
    let newID = String.fromCharCode(last + 1);
    allDonationID.push(newID);
    resultJson['donationID'] = newID;

    for (let $i = 0; $i < allInput.length; $i++) {
        if (allInput[$i].getAttribute('name') === 'donation-title') {
            if (allInput[$i].value === '') {
                return;
            }
        }
        if (allInput[$i].getAttribute('name') !== 'donationID') {
            resultJson[allInput[$i].getAttribute('name')] = allInput[$i].value;
            allInput[$i].value = null;
        }
    }

    let div = document.createElement('div');
    div.className = 'don';

    let link = document.createElement('a');
    link.href = "javascript:void(0)";
    link.onclick = function (e) {
        deleteDonation(e);
    };

    let deleteBtn = document.createElement('i');
    deleteBtn.className = "gg-delete";
    link.appendChild(deleteBtn);
    div.appendChild(link);

    let label = document.createElement('label');
    label.className = "selectedDonation-item";
    label.innerHTML = resultJson['donation-title'];
    div.appendChild(label);

    let editBtn = document.createElement('a');
    editBtn.className = "gg-pen";
    editBtn.href = "javascript:void(0)";
    editBtn.onclick = function (e) {
        editDonation(e);
    };
    div.appendChild(editBtn);

    let input = document.createElement('input');
    input.type = "hidden";
    input.value = JSON.stringify(resultJson); // Ugly solution, but no solution looks nice
    input.name = "donation-items[]";
    input.id = "donitem-" + newID;
    div.appendChild(input);

    $('.selectedDonations .label-text')[0].classList.remove('null-selected');
    $('.selectedDonations .label-text')[0].appendChild(div);
    emptyDonationForm();
}

function emptyDonationForm() {
    let allInput = $('#select-donation-container input, #select-donation-container textarea');

    for (let $i = 0; $i < allInput.length; $i++) {
        allInput[$i].value = null;
    }

    selectMenu('select-donation');
}

function updateDonation() {
    let allInput = $('#select-donation-container input, #select-donation-container textarea');
    let targetInput = $('#donitem-' + $('#donationID')[0].value)[0];
    let resultJson = {};

    if (targetInput === undefined) {
        saveDonation();
        return;
    }

    for (let $i = 0; $i < allInput.length; $i++) {
        if (allInput[$i].getAttribute('name') === 'donation-title') {
            if (allInput[$i].value === '') {
                return;
            } else {
                targetInput.parentNode.querySelector('.selectedDonation-item').innerHTML = allInput[$i].value;
            }
        }
        resultJson[allInput[$i].getAttribute('name')] = allInput[$i].value;
        allInput[$i].value = null;
    }

    targetInput.value = JSON.stringify(resultJson);

    emptyDonationForm();
}

function editDonation(event) {
    if ($('#select-donation-container')[0].style.display === 'none') {
        selectMenu('select-donation');
    }
    $('#donationSaveBtn')[0].setAttribute('onclick', 'updateDonation()');

    let allInput = $('#select-donation-container input, #select-donation-container textarea');
    let JSONdata = JSON.parse(event.target.parentNode.querySelector('input[type="hidden"]').value);

    for (let $i = 0; $i < allInput.length; $i++) {
        allInput[$i].value = JSONdata[allInput[$i].getAttribute('name')];
    }
}

function deleteDonation(e) {
    if (e.target.parentNode.parentNode.parentNode.childElementCount === 1) {
        e.target.parentNode.parentNode.parentNode.classList.add('null-selected');
    }
    e.target.parentNode.parentNode.remove();
}
