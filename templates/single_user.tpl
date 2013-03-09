{block "forum"}
<div id='user_info'>
        <h3>{$user.author_name}</h3>
    <img src='{$user.author_email_hash|avatar:64}' alt='{$user.author_name|escape}' />
    <ul id="user_stats">
        <li>Joined: {$user.time_created|date_format:"%D"}</li>
    </ul>
    <ul id="user_posts">
        {foreach $user_posts as $post}
            {if $post.type == 'post'}
            <li><a href="{$baseurl}/{$post.id}">{$post.title}</a></li>
            {else}
            <li><a href="{$baseurl}/{$post.id}#post{$post.reply_id}">{$post.title}</a></li>
            {/if}
        {/foreach}
    </ul>
</div>
{/block}