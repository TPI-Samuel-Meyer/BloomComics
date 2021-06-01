/*
 * User: Samuel Meyer
 * Date: 01.06.2021
 */

function newCategoryElement(id) {
    document.getElementById(`cat-id-${id}`).style.display = 'none';

    var category_box = document.createElement('span');
    category_box.id = `add-cat-${id}`;
    category_box.classList.add('category-box');

    var category = document.createElement('span');
    category.innerHTML = document.getElementById(`cat-id-${id}`).innerHTML;
    category.classList.add('category-name');
    category_box.appendChild(category);

    var vanished_input = document.createElement('input');
    vanished_input.name = "category["+ id +"]";
    vanished_input.style.display = 'none';
    category_box.appendChild(vanished_input);

    var exit = document.createElement('span');
    exit.classList.add('category-exit');
    exit.innerHTML = 'x';
    exit.addEventListener('click', function(){
        document.getElementById(`add-cat-${id}`).remove();
        document.getElementById(`cat-id-${id}`).style.display = 'block';
    });
    category_box.appendChild(exit);

    document.getElementById('category-list').appendChild(category_box);
}

