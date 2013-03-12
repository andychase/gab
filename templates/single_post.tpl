{block "forum"}
<div class='post_replies'>
    <h2>{$topic.title|escape}
        {if $topic.category}
            <a href='{$base_url}/category/{$topic.category}' class="category {$topic.category}">{$topic.category}</a>
        {/if}
    </h2>

    {foreach $replies as $key => $post}
        <div class='post_container {if $post.status == 'hidden' || $post.status == 'mod_hidden'}hidden{/if}'>
            <div class='post_user'>
                <a class="post_anchor" id="post{$post.id}"></a>
                <a href="{$baseurl}/user/{$post.author_name}">
                    <img src='{$post.author_email_hash|avatar}' class='author_image' alt='{$post.author_name|escape}' />
                </a>
                <span class='author_name'>{$post.author_name|escape}</span>
                <span class='post_time'>{block 'post_time'}{$post.time_created}{/block}</span>
            </div>
            <div class='post_body'>
                {if $edit && $edit == $post.id}
                    <form action action="{$baseurl}/{$topic.id}/#post{$post.id}" method="post">
                        <input type="hidden" name="edit" value="{$post.id}" />
                        <textarea rows="3" cols="50" name="text">{$post.message}</textarea>
                        <input type="submit" value="submit" />
                    </form>
                {else}
                    {if $post.status == 'hidden' || $post.status == 'mod_hidden'}<del>{/if}
                    {block 'post_body'}
                        {if $post.reply}
                        <div class="post_at_reply">
                            <div class='at_reply_message'>{$post.reply.message}</div>
                            <a href='#post{$post.reply.id}' class='at_reply_link'>Reply to {$post.reply.author_name}</a>
                        </div>
                        {/if}
                        {$post.message|parse}
                    {/block}
                    {if $post.status == 'hidden' || $post.status == 'mod_hidden'}</del>{/if}
                {/if}
                {include 'sections/post_actions.tpl'}
            </div>
        </div>
    {/foreach}
    {include 'sections/paging.tpl'}

    {block 'thread_reply'}
        {if $logged_in}
            {include 'sections/thread_reply.tpl'}
        {/if}
    {/block}
</div>
{/block}