{block 'extra_links' append}
{if $user_logged_in->hasPermission($permissions.OPTIONS)}
    <a href="/ext/options" class="nav_section new_link options"><span class="txt">Options</span></a>
{/if}
{/block}
