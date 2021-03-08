function checkform(formID) {
    var myForm = document.getElementById(formID);
    var allInputs = myForm.getElementsByTagName('input');
    var allSelects = myForm.getElementsByTagName('select');


    var input, i, select;

    for (i = 0; input = allInputs[i]; i++) {
        if (input.getAttribute('name') && !input.value) {
            input.setAttribute('name', '');
        }
    }
    for (i = 0; select = allSelects[i]; i++) {
        if (select.getAttribute('name') && !select.value) {
            select.setAttribute('name', '');
        }
    }
    let diachi = document.getElementById('inputAdressR').value;
    localStorage.setItem("diachi", diachi);
}
