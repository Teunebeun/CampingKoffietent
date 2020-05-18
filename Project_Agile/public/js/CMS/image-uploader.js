createNewInput();

function addPicture(singleImage) {
    let newRow = document.createElement('tr');
    let leftCell = document.createElement('td');
    let rightCell = document.createElement('td');

    leftCell.className = 'no-link delete-container';
    let label = document.createElement('label');
    label.className = 'switch';
    let btn = document.createElement('i');
    btn.className = 'gg-delete';
    btn.onclick = function () {
        let parentRow = this.parentNode.parentNode.parentNode;
        let idName = parentRow.querySelector('a').innerHTML;
        let allInputs = $('input:file');
        for (let i = 0; i < allInputs.length; i++) {
            if (allInputs[i].files.length > 0) {
                if (allInputs[i].files[0].name === idName) {
                    allInputs[i].remove();
                }
            }
        }
        parentRow.remove();
    };
    label.appendChild(btn);
    leftCell.appendChild(label);

    let link = document.createElement('a');
    link.innerHTML = singleImage['name'];
    link.setAttribute('href', 'javascript:void(0)');
    link.onclick = function () {
    };
    rightCell.appendChild(link);

    newRow.appendChild(leftCell);
    newRow.appendChild(rightCell);
    $('#select-fotos-container .table').append(newRow);
}

function createNewInput() {
    let field = document.createElement('input');
    field.type = 'file';
    field.name = 'pictures[]';
    field.accept = 'image/*';
    field.onchange = function () {
        this.hidden = true;
        addPicture(this.files[0]);
        createNewInput();
    };
    $('#cheese')[0].appendChild(field);
}

$('.old-image').on('click', function () {
    this.parentNode.parentNode.parentNode.remove();
});
