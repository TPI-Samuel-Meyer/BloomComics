<?php
/*
 * User: Samuel Meyer
 * Date: 18.05.2021
 */
?>

<form method='post' action='index.php?action=sign_in'>
    <h1>Sign in</h1>
    <span><?=$errors['sign in'];?></span>
    <label>
        <span>Email</span>
        <input name='email' type='email' required/>
    </label>
    <label>
        <span>Password</span>
        <input name='password' type='password' required/>
    </label>

    <input type='submit'/>
    <a href='index.php?action=sign_up'>Don't already have an account? Sign up!</a>
</form>