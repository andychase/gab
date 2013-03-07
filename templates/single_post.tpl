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
                    <img src='http://www.gravatar.com/avatar/{$post.author_email_hash}?s=40&d=retro' class='author_image' alt='{$post.author_name|escape}' />
                </a>
                <span class='author_name'>{$post.author_name|escape}</span>
                <span class='post_time'>{block 'post_time'}{$post.timestamp}{/block}</span>
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
                    {block 'post_body'}{$post.message|parse}{/block}
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