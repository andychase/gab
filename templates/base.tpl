{extends 'html_base.tpl'}
{block 'body'}

{block 'top_navigation'}
<div id="forum" class="{$forum_section}">
    <a href="{$base_url}/" class="nav_section posts">Posts</a>
    {if $topic}
    <a href="{$base_url}/{$topic.id}" class="nav_section posts single">{$topic.title|truncate:30}</a>
    {/if}
    <a href="{$base_url}/categories" class="nav_section cat">Categories</a>
    <a href="{$base_url}/messages" class="nav_section msg">Messages</a>
    {if $forum_section == "posts" && !$topic}
        <a href="{$base_url}/new_thread" id="new_link" class="nav_section new_link ss-plus"><span>New Thread</span></a>
        {$new_name = 'Thread'}
        {include 'new_thread.tpl'}
    {/if}
    {if $forum_section == "cat"}
        <a href="{$base_url}/new_category" id="new_link" class="nav_section new_link ss-plus"><span>New Category</span></a>
        {$new_name = 'Category'}
        {include 'new_thread.tpl'}
    {/if}
    {if $forum_section == "msg"}
        <a href="{$base_url}/new_message" id="new_link" class="nav_section new_link ss-plus"><span>New Message</span></a>
        {$new_name = 'Message'}
        {include 'new_thread.tpl'}
    {/if}
    {block 'forum'}{/block}
</div>
{/block}

{block 'content'}{/block}

{/block}