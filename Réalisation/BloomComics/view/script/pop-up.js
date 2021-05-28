/*
 * User: Samuel Meyer
 * Date: 18.05.2021
 */

/**
 * This function is designed to create a layer on the site interface.
 * @param {string} ppup_id : must be a chosen layer id.
 * @param {number} zIndex : must be the css layer position.
 * @return {element} layer : layer object.
 */
function create_layer(ppup_id, zIndex){
    var layer = document.createElement('div');

    layer.id = `${ppup_id}_layer`;
    layer.className = 'layer';
    layer.style.height = '100%';
    layer.style.backgroundColor = 'rgba(0, 0, 0, .5)';
    layer.style.left = 0;
    layer.style.position = 'absolute';
    layer.style.top = 0;
    layer.style.width = '100%';
    layer.style.zIndex = zIndex;

    return layer;
}

/**
 * This function is designed to create a layer on the site interface.
 * @param {string} id : must be a chosen pop-up id.
 * @param {string} title : must be pop-up title.
 * @param {string} text : must be pop-up descriptive text.
 * @param {number} zIndex : must be css pop-up zIndex value.
 * @return {element} ppup : pop-up object.
 */
function create_ppup(id, title, text, zIndex){
    // Set pop-up params values
    var ppup = document.createElement('div');
    ppup.id = id;
    ppup.className = 'ppup';
    ppup.style.display = 'block';
    ppup.style.position = 'absolute';
    ppup.style.textAlign = 'center';
    ppup.style.zIndex = zIndex + 1;
    layer = create_layer(ppup.id, zIndex);
    document.body.appendChild(layer);

    // Set pop-up content object params values
    var h3 = document.createElement('h3');
    h3.innerHTML = title;
    h3.className = 'ppup_title';
    ppup.appendChild(h3);

    // Set pop-up content object params values
    var content = document.createElement('div');
    content.className = 'ppup_content';
    ppup.appendChild(content);

    // Set pop-up text object params value
    var small = document.createElement('small');
    small.innerHTML = text;
    content.appendChild(small);

    return ppup;
}

/**
 * This function is designed to create a layer on the site interface.
 * @param {string} id : must be a chosen pop-up id.
 * @param {string} action : must be pop-up action when confirmation is validated.
 * @param {string} title : must be pop-up title.
 * @param {string} text : must be pop-up descriptive text.
 * @param {number} zIndex : must be css pop-up zIndex value.
 * @return {element} ppup : pop-up object.
 */
function ppup_confirm(id, action, title, text, zIndex){
    // Set pop-up buttons objects params values
    console.log(action);
    var btn = document.createElement('div');
    btn.style.width = '100%';

    var primary_btn = document.createElement('div');
    primary_btn.appendChild(btn);
    primary_btn.className = 'btn primary_btn';
    primary_btn.textContent = 'Yes';
    if(parent !== ''){
        primary_btn.addEventListener('click', function(){
            document.getElementById(id).remove();
            document.getElementById(`${id}_layer`).remove();
            window.location.href = `${action}`;
        });
    }

    var secondary_btn = document.createElement('div');
    secondary_btn.appendChild(btn);
    secondary_btn.className += 'btn secondary_btn';
    secondary_btn.textContent = 'No';
    secondary_btn.addEventListener('click', function(){
        document.getElementById(id).remove();
        document.getElementById(`${id}_layer`).remove();
    });

    // Set pop-up params values
    ppup = create_ppup(
        id,
        title,
        text,
        zIndex
    );

    // Display pop-up
    ppup.appendChild(primary_btn);
    ppup.appendChild(secondary_btn);
    ppup.style.paddingBottom = 0;
    document.body.appendChild(ppup);
}
