$('table tr').click(function (e) {
    let clickedElement = $(this).find(e.target).get()[0];

    while (clickedElement.nodeName != "TD" && clickedElement.nodeName != "TH") {
        clickedElement = clickedElement.parentNode;
    }

    if (!clickedElement.classList.contains("no-link")) {
        let href = $(this).find("a").attr("href");
        if (href) {
            window.location = href;
        }
    }
});
