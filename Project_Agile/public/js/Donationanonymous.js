function checkboxChanged(checkbox){
    if(checkbox.checked){
        DisableNames();
    }else{
        ShowNames();
    }
}

function ShowNames(){
    let names = GetNames();
    for(let i = 0; i < names.length; i ++){
        let span = names[i].getElementsByTagName('span')[0];
        span.style.opacity = "1";

        let input = names[i].getElementsByTagName('input')[0];
        input.required = true;
        input.readOnly = false;
        input.style.opacity = "1";
    }
}

function DisableNames(){
    let names = GetNames();
    for(let i = 0; i < names.length; i ++){
        let span = names[i].getElementsByTagName('span')[0];
        span.style.opacity = "0.5";

        let input = names[i].getElementsByTagName('input')[0];
        input.required = false;
        input.value = "";
        input.readOnly = true;
        input.style.opacity = "0.5";
    }
}

let GetNames = function(){
    return document.getElementsByClassName("name");
}

function addEuro(text){
    if(!text.value.includes("€") || text.value.length != 0){
        let input = "€" + text.value;
        text.value = input;
    }
}
