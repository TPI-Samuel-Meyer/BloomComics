create artwork
modify artwork
create article
modify article
modify profile

<form>
    <label>
        <span>Title</span>
        <input type='text' value='<?php if(isset($title)){echo $title;}?>'/>
    </label>
    <?php
    $action = '';
    if(
        $action == 'create_artwork' ||
        $action == 'modify_artwork'
    ) : ?>
        <select>
            <option value='' selected>Select type</option>
        </select>
    <?php endif; ?>
    <select>
        <option value='' selected>Add category</option>
    </select>
    <input type='file'/>
    <label>
        <span>Description</span>
        <textarea><?php if(isset($description)){echo $description;}?></textarea>
    </label>
    <input type='reset' value='Cancel'/>
    <input type='submit' value='Confirm'/>
</form>