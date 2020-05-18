document.addEventListener('DOMContentLoaded', addToolTips);

function addToolTips() {
    let cells = document.getElementsByTagName('td');
    Array.from(cells).forEach(function(item) {
        if(!item.classList.contains('no-link')) {
            let content = item.textContent;
            item.setAttribute('title', content);
        }
    });
}
