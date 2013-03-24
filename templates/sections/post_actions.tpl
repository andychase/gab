<div class='post_actions'>
{block 'mod_actions'}
    {if in_array('edit', $post.actions) && !$edit}
        <a href="{$baseurl}/{$topic.id}/?edit={$post.id}#post{$post.id}" class="edit" title="Edit">
            <span class="txt">Edit</span>
        </a>
        {elseif in_array('edit', $post.actions)}
        <a href="{$baseurl}/{$topic.id}#post{$post.id}" class="edit" title="Cancel Edit">
            <span class="txt">Cancel</span>
        </a>
    {/if}

    {if in_array('delete', $post.actions)}
        {if $post.visibility == 'hidden' || $post.visibility == 'mod_hidden'}
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