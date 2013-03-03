{block "forum"}
<div id='signup'>
    <form action="openid_signup" method="post">
        <h2>Signup</h2>
        <ul>{foreach $errors as $error}<li>{$error}</li>{/foreach}</ul>
        Name: <input type="text" name="name"><br />
        Email (Optional, for gravatars only) <input type="text" name="email"><br />
        <input type="submit" value="submit">
    </form>
</div>
{/block}