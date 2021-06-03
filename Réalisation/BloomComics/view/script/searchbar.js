/*
 * User: Samuel Meyer
 * Date: 31.05.2021
 */

/**
 * This function is design display or not different artwork as type selector value.
 */
function type_filter() {
    Array.prototype.forEach.call(card = document.getElementsByClassName('card'), element => {
        if (!element.childNodes[3].childNodes[5].innerHTML.includes(document.getElementById('type_selector').value)) element.style.display = 'none';
        else element.style.display = 'inline-block';
    });
}

function search(text) {
    Array.prototype.forEach.call(card = document.getElementsByClassName('card'), element => {
        if (
            search_title(text, element) ||
            search_editor(text, element)
        ) element.style.display = 'inline-block';
        else element.style.display = 'none';
    });
}

function search_title(text, element) {
        var valid = true;
        Array.prototype.forEach.call(text, char => {
            if (
                !element.attributes.editor.value.includes(char.toUpperCase()) &&
                !element.attributes.editor.value.includes(char.toLowerCase())
            ) valid = false;
        });
        if (!element.childNodes[3].childNodes[5].innerHTML.includes(document.getElementById('type_selector').value)) valid = false;
        return valid;
}

function search_editor(text, element) {
    var valid = true;
    Array.prototype.forEach.call(text, char => {
        if (
            !element.childNodes[3].childNodes[1].innerHTML.includes(char.toUpperCase()) &&
            !element.childNodes[3].childNodes[1].innerHTML.includes(char.toLowerCase())
        ) valid = false;
    });
    return valid;
}

/**
 * This function is design display or not different artwork as category selector value.
 */
function category_filter() {
    Array.prototype.forEach.call(card = document.getElementsByClassName('card'), element => {
        if (!element.attributes.categories.value.includes(document.getElementById('category_selector').value)) element.style.display = 'none';
        else element.style.display = 'inline-block';
    });
}