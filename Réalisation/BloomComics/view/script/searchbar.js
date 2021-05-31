/*
 * User: Samuel Meyer
 * Date: 31.05.2021
 */

/**
 * This function is design display or not different articles as type selector value.
 */
function type_filter() {
    Array.prototype.forEach.call(card = document.getElementsByClassName('card'), element => {
        if (!element.childNodes[3].childNodes[5].innerHTML.includes(document.getElementById('type_selector').value)) element.style.display = 'none';
        else element.style.display = 'inline-block';
        console.log(element);
    });
}

function search(text) {
    Array.prototype.forEach.call(card = document.getElementsByClassName('card'), element => {
        var valid = true;
        Array.prototype.forEach.call(text, char => {
            if (
                !element.attributes.editor.value.includes(char.toUpperCase()) &&
                !element.attributes.editor.value.includes(char.toLowerCase())
            ) valid = false;
        });
        if (valid) element.style.display = 'inline-block';
        else element.style.display = 'none';
        if (!element.childNodes[3].childNodes[5].innerHTML.includes(document.getElementById('type_selector').value)) element.style.display = 'none';
    });
}

function search_editor(text) {
    Array.prototype.forEach.call(card = document.getElementsByClassName('card'), element => {
        var valid = true;
        Array.prototype.forEach.call(text, char => {
            if (
                !element.childNodes[3].childNodes[1].innerHTML.includes(char.toUpperCase()) &&
                !element.childNodes[3].childNodes[1].innerHTML.includes(char.toLowerCase())
            ) valid = false;
        });
        if (valid) element.style.display = 'inline-block';
        else element.style.display = 'none';
        if (!element.childNodes[3].childNodes[5].innerHTML.includes(document.getElementById('type_selector').value)) element.style.display = 'none';
    });
}