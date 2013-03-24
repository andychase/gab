{block "forum"}
<div id='user_info'>
    {if $user.visibility != 'normal'}<del>{/if}
    <h3>{$user.author_name}</h3>
    <img src='{$user.author_email_hash|avatar:64}' alt='{$user.author_name|escape}' />
    {include 'sections/user_actions.tpl'}
    <ul id="user_stats">
        <li>Joined: {$user.time_created|date_format:"%D"}</li>
    </ul>
    <ul id="user_posts">
        {foreach $user_posts as $post}
            {if $post.type == "post"}
            <li>
                <a href="{$baseurl}/{$post.id}">{$post.title}
                    <i>{$post.message|truncate:10}</i>
                </a>
            </li>
            {else}
            <li>
                <a href="{$baseurl}/{$post.reply_to}#post{$post.id}">
                    <i>{$post.message|truncate:10}</i>
                </a>
            </li>
            {/if}
        {/foreach}
    </ul>
    {if $user.visibility != 'normal'}</del>{/if}
</div>
{/block}