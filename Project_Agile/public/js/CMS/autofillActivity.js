if (typeof initiative !== 'undefined') {
    document.getElementById('name').value = initiative.title;
    document.getElementById('description').innerText = initiative.description;
}
