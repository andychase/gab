{block "forum"}
<div class='post_replies'>
    <h2>{$topic.title|escape}
        {if $topic.category}
            <a href='{$base_url}/category/{$topic.category}' class="category {$topic.category}">{$topic.category}</a>
        {/if}
    </h2>

    {foreach $replies as $key=>$post}
        <div class='post_container'>
            <div class='post_user'>
                <a class="post_anchor" id="post{$post.id}"></a>
                <img src='http://www.gravatar.com/avatar/{$post.author_email_hash}?s=40&d=retro' class='author_image' alt='{$post.author_name|escape}' />
                <span class='author_name'>{$post.author_name|escape}</span>
                <span class='post_time'>{block 'post_time'}{$post.timestamp}{/block}</span>
            </div>
            <div class='post_body'>{block 'post_body'}{$post.message|escape}{/block}</div>
        </div>
    {/foreach}
    {if $topic.replies > 60}
        {for $i=0 to $topic.replies step 60}
            <a href="{$base_url}/{$topic.id}?skip={$i}">{$i}</a>
        {/for}
    {/if}

    <div id='submit_reply'>
        <a id="reply"></a>
        <h3>Reply</h3>
        {if $posterror}
            <ul class="errors">
                {foreach $posterrors as $errors}
                    <li>{$errors}</li>
                {/foreach}
            </ul>
        {/if}
        <form action="{$base_url}/{$topic.id}#reply" method="post" class="savable">
            <label>
                <textarea name="text"></textarea>
            </label>
            <div id="save_warning"></div>
            <input name="text_b" class="text_b" />
            <div id='preview'></div>
            <input type="hidden" name="do" value="forum_reply" />
            <input type="hidden" name="topic_id" value="{$topic.id}" />
            <input type="submit" class="submit" value="Submit">
        </form>
    </div>
</div>
{/block}