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
                <div class='post_actions'>
                {block 'mod_actions'}
                    {if $post.author == $user_logged_in && !$edit}
                        <a href="{$baseurl}/{$topic.id}/?edit={$post.id}#post{$post.id}" class="edit" title="Edit">
                            <span class="txt">Edit</span>
                        </a>
                    {elseif $post.author == $user_logged_in}
                        <a href="{$baseurl}/{$topic.id}#post{$post.id}" class="edit" title="Cancel Edit">
                            <span class="txt">Cancel</span>
                        </a>
                    {/if}
                    {if $user_trust >= $trust_levels.delete || $post.author == $user_logged_in}
                        {if $post.status == 'hidden' || $post.status == 'mod_hidden'}
                            <a href='{$baseurl}/{$topic.id}/?recover={$post.id}#post{$post.id}' class="delete" title="Recover">
                                <span class="txt">Recover</span>
                            </a>
                        {else}
                            <a href='{$baseurl}/{$topic.id}/?delete={$post.id}#post{$post.id}' class="delete" title="Delete">
                                <span class="txt">Delete</span>
                            </a>
                        {/if}
                    {/if}
                {/block}
                {block 'post_actions'}
                    <a href='{$baseurl}/ext/flag/{$post.id}' class="flag" title="Flag as spam">
                        <span class="txt">Flag</span>
                    </a>
                    <a href='{$baseurl}/{$topic.id}#post{$post.id}' class="permalink" title="Permanent link for sharing">
                        <span class="txt">Permalink</span>
                    </a>
                    {if $logged_in}
                    <a href='{$baseurl}/{$topic.id}#reply' class="reply" title="Reply to this">
                        <span class="txt">Reply</span>
                    </a>
                    {/if}
                {/block}
                </div>
            </div>
        </div>
    {/foreach}
    {if $topic.replies > 60}
        <div id="pages">
        {for $i=0 to $topic.replies step 60}
            <a href="{$base_url}/{$topic.id}?skip={$i}">{$i}</a>
        {/for}
        </div>
    {/if}

    {if $logged_in}
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
    {/if}
</div>
{/block}