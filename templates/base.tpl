{extends 'html_base.tpl'}
{block 'body'}

{block 'top_navigation'}
<div id="forum" class="{$forum_section}">
    {block 'top_navigation_sections'}
        {* Posts *}
        <a href="{$base_url}/" class="nav_section posts">Posts</a>
        {* Post -> Topic *}
        {if $topic}
            <a href="{$base_url}/{$topic.id}" class="nav_section posts single">{$topic.title|escape|truncate:30}</a>
        {/if}

        {* Categories *}
        <a href="{$base_url}/categories" class="nav_section cat">Categories</a>
        {*  Categories -> Category *}
        {if $category}
            <a href="{$base_url}/category/{$category}" class="nav_section category cat single">{$category|escape|truncate:30}</a>
        {/if}

        {* Messages *}
        {block 'show_messages'}{$show_messages=$logged_in}{/block}
        {if $show_messages}
            <a href="{$base_url}/messages" class="nav_section msg">Messages</a>
        {/if}
    {/block}


    {block 'show_new'}{$show_new=$logged_in}{/block}
    {block 'new_links'}
        {if $show_new}
            {if $forum_section == "posts" && !$topic}
                <a href="{$base_url}/new_thread" id="new_link" class="nav_section new_link ss-plus"><span>New Thread</span></a>
                {$new_name = 'Thread'}
                {block 'extra_links'}{/block}
                {include 'new_thread.tpl'}
            {elseif $forum_section == "cat" && $user_trust >= $trust_levels.new_category}
                <a href="{$base_url}/new_category" id="new_link" class="nav_section new_link ss-plus"><span>New Category</span></a>
                {$new_name = 'Category'}
                {block 'extra_links'}{/block}
                {include 'new_thread.tpl'}
            {elseif $forum_section == "msg"}
                <a href="{$base_url}/new_message" id="new_link" class="nav_section new_link ss-plus"><span>New Message</span></a>
                {$new_name = 'Message'}
                {block 'extra_links'}{/block}
                {include 'new_thread.tpl'}
            {else}
                {block 'extra_links'}{/block}
            {/if}
        {else}
            {block 'extra_links'}{/block}
        {/if}
    {/block}

    {block 'forum'}{/block}
</div>
{/block}

{block 'content'}{/block}

{/block}