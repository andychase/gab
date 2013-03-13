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
    {if $logged_in}
    <a href='{$baseurl}/ext/flag/{$post.id}' class="flag" title="Flag as spam">
        <span class="txt">Flag</span>
    </a>
    {/if}
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