<form>
    <?php
    $userType = 'user';
    #$userType = 'admin';
    if($userType == 'admin') : ?>
        <span>
            <button>Add artwork</button>
            <button>Modify categories</button>
        </span>
    <?php endif; ?>

    <select>
        <option value='' selected>Type</option>
    </select>
    <select>
        <option value='' selected>Category</option>
    </select>
    <select>
        <option value='' selected>Editor</option>
    </select>
    <span>
        <input type='text' placeholder='Search...'/>
    </span>
</form>

<div>
    <span>
        <img/>
    </span>
    <span>
        <h3>#Title</h3>
    </span>
    <span>
        <small>#Description</small>
    </span>
    <span>#Type</span>
    <span>#Mark</span>
</div>