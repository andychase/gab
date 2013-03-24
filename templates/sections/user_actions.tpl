<div id="user_actions">
{block 'user_actions'}
    {* Moderation actions *}
    {if $user_logged_in->id != $user.id}
        {if $user_logged_in->hasPermission($permissions.ASSIGN_MODS)}
        <form method="post">
            <input type="hidden" name="user" value="{$user.id}">
            {if $user.badges && in_array('mod', $user.badges)}
                <input type="hidden" name="do" value="deletemod" />
                <input type="submit" value="remove moderation status from this user" />
            {else}
                <input type="hidden" name="do" value="makemod" />
                <input type="submit" value="make this user a moderator">
            {/if}
        </form>
        {/if}

        {if $user_logged_in->hasPermission($permissions.BAN)}
            <form method="post">
                <input type="hidden" name="user" value="{$user.id}">
                {if $user.visibility == 'normal'}
                    <input type="hidden" name="do" value="ban" />
                    <input type="submit" value="ban this user" />
                {else}
                    <input type="hidden" name="do" value="unban" />
                    <input type="submit" value="unban this user">
                {/if}
            </form>
        {/if}
    {/if}
{/block}
</div>
