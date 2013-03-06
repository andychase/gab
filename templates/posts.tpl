{block "forum"}
 <table id='posts_table'>
    <thead>
    <tr class='headers'>
        {block 'table_headers'}
            {$sort_desc = array("Sort by title",
            "Sort by random",
            "Sort by contribution",
            "Sort by posts",
            "Sort by views",
            "Sort by last activity")}
            {$table_headers = array("Title", " ", "People", "Replies", "Views", "Last")}
        {/block}
        {foreach $table_headers as $header}
            <th class='{$header}'>
            {if $sort_by == {$header|lower} && $sort_down}
                <a href="?sort={$header|lower}&dir=up" title="{$sort_desc[$header@index]}" class="down">
                    {$header}
                </a>
            {elseif $sort_by == {$header|lower}}
                <a href="?sort={$header|lower}" title="{$sort_desc[$header@index]}" class="up">
                    {$header}
                </a>
            {else}
                <a href="?sort={$header|lower}" title="{$sort_desc[$header@index]}">
                    {$header}
                </a>
            {/if}
            </th>
        {/foreach}
        </tr>
    </thead>
    <tbody>
    {foreach from=$posts item=post}
        <tr>
                <td class='id'><a href='{$base_url}/{$post.id}'>{$post.title|escape}</a></td>
                <td>
                    {if $post.category}
                        <a href='{$base_url}/category/{$post.category|replace:" ":"_"}' class="category {$post.category|replace:" ":"_"|lower}">
                            {$post.category}
                        </a>
                    {/if}
                </td>
                <td class='author_name'>
                    <a href="{$baseurl}/user/{$post.author_name}"><img title="Author: {$post.author_name}"
                            src="http://www.gravatar.com/avatar/{$post.author_email_hash}?s=24&d=retro"/></a>
                    {if $post.most_replies_name}
                    <a href="{$baseurl}/user/{$post.most_replies_name}"><img title="Most Replies: {$post.most_replies_name}"
                            src="http://www.gravatar.com/avatar/{$post.most_replies_email_hash}?s=24&d=retro"/></a>
                    {/if}
                    {if $post.last_replier_name}
                    <a href="{$baseurl}/user/{$post.last_replier_name}"><img title="Last Reply: {$post.last_replier_name}"
                            src="http://www.gravatar.com/avatar/{$post.last_replier_email_hash}?s=24&d=retro"/></a>
                    {/if}
                </td>
                <td class='replies'>{if $post.replies}{$post.replies}{/if}</td>
                <td class='views'>{if $post.views}{$post.views}{/if}</td>
                <td class='last_reply'>{if $post.last_reply}{$post.last_reply|timeAgo}{/if}</td>
            <td>
            </td>
        </tr>
    {/foreach}
    </tbody>
    </table>
{/block}