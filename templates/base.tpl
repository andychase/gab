{extends 'html_base.tpl'}
{block 'body'}

{block 'top_navigation'}
<div id="forum" class="{$forum_section}">
    <div id="forum_navigation">
    {block 'top_navigation_sections'}
        {* Posts *}
        <a href="{$base_url}/" class="nav_section posts">Posts</a>
        {* Post -> Topic *}
        {if $topic}
            <a href="{$base_url}/{$topic.id}" class="nav_section posts single">{$topic.title|escape|truncate:25}</a>
        {/if}

        {* Categories *}
        <a href="{$base_url}/categories" class="nav_section cat">Categories</a>
        {*  Categories -> Category *}
        {if $category}
            <a href="{$base_url}/category/{$category}" class="nav_section category cat single">{$category}</a>
        {/if}

        {* Users *}
        <a href="{$base_url}/users" class="nav_section users">Users</a>
        {*  Users -> User *}
        {if $user_name}
            <a href="{$base_url}/user/{$user_name}" class="nav_section users single">{$user_name|escape|truncate:20}</a>
        {/if}

        {* Messages *}
        {block 'show_messages'}{$show_messages=$logged_in}{/block}
        {if $show_messages}
            <a href="{$base_url}/messages" class="nav_section msg">Messages</a>
        {/if}
    {/block}



    {block 'show_new'}{$show_new=$logged_in}{/block}
    {block 'new_links'}
        {* User specific links (Often on the right side) *}
        {if $show_new}
            {if $forum_section == "posts" && !$topic}
                <span class="new_links">
                    {block 'extra_links'}{/block}
                    <a href="{$base_url}/new_thread" id="new_link" class="nav_section new_link ss-plus"><span>New Thread</span></a>
                </span>
                {$new_name = 'Thread'}
            {elseif $forum_section == "cat" && $user_trust >= $trust_levels.new_category}
                <span class="new_links">
                    {block 'extra_links'}{/block}
                    <a href="{$base_url}/new_category" id="new_link" class="nav_section new_link ss-plus"><span>New Category</span></a>
                </span>
                {$new_name = 'Category'}
            {elseif $forum_section == "msg"}
                {*<a href="{$base_url}/new_message" id="new_link" class="nav_section new_link ss-plus"><span>New Message</span></a>
                   Not implemented yet*}
                <span class="new_links">
                    {block 'extra_links'}{/block}
                </span>
                {$new_name = 'Message'}
                
            {else}
                <span class="new_links">
                    {block 'extra_links'}{/block}
                </span>
            {/if}
        {else}
            <span class="new_links">
                {block 'extra_links'}{/block}
            </span>
        {/if}
    </div>
    {if $new_name == 'Thread' || $new_name == 'Category' || $new_name == 'Message'}
        {include 'sections/new_thread_cat_msg.tpl'}
    {/if}
    {/block}
    
<div id="forum_content">
    {block 'forum'}{/block}
</div>
</div>
{/block}

{/block}