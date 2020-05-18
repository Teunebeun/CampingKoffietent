var elements = document.querySelectorAll('input,select,textarea');
var invalidListener = function(){ this.scrollIntoView(false); };

for(var i = elements.length; i--;)
    elements[i].addEventListener('invalid', invalidListener);