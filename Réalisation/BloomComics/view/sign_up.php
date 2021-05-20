<form method='post' action='index.php?action=sign_up'>
    <h1>Sign up</h1>
    <label>
        <span>Username</span>
        <input name='username' type='text' min='2' max='32' required/>
        <span><?=$errors['username'];?></span>
    </label>
    <label>
        <span>Email</span>
        <input name='email' type='email' required/>
        <span><?=$errors['email'];?></span>
    </label>
    <label>
        <span>Password</span>
        <input name='password' type='password' min='8' required/>
        <span><?=$errors['password'];?></span>
    </label>
    <label>
        <span>Confirm</span>
        <input name='confirm' type='password' required/>
    </label>

    <input type='submit'/>
    <a href='index?action=sign_in'>Already have an account? Sign in!</a>
</form>