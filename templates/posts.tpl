{block "forum"}
 <table id='posts_table'>
    <thead>
    <tr class='headers'>
        {block 'sort'}
            {$sort_desc = array("Sort by title",
            "Sort by random",
            "Sort by contribution",
            "Sort by posts",
            "Sort by views",
            "Sort by last activity")}
        {/block}
        {block 'table_headers'}
            {$table_headers = array("Title", " ", "Author", "Posts", "Views", "Last")}
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
        {foreach $post as $key=>$value}
            {if $key == 'id'}
                <td class='{$key}'><a href='{$base_url}/{$value}'>
            {elseif $key == 'title'}
                {$value|escape} </a></td>
            {elseif $key == 'author_name'}
                <td class='{$key}'><a href="{$baseurl}/user/{$value}"><img title="{$value}"
            {elseif $key == 'author_email_hash'}
                            src="http://www.gravatar.com/avatar/{$value}?s=24&d=retro"/></a></td>
            {elseif $key == 'last_reply'}
                <td class='{$key}'>{if $value}{$value|timeAgo}{/if}</td>
            {elseif $key == 'category'}
            <td>
                {if $value}
                    <a href='{$base_url}/category/{$value|replace:" ":"_"}' class="category {$value|replace:" ":"_"|lower}">
                        {$value}
                    </a>
                {/if}
            </td>
            {else}
                <td class='{$key}'>{$value|escape}</td>
            {/if}
        {/foreach}
        </tr>
    {/foreach}
    </tbody>
    </table>
{/block}