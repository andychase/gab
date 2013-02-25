{block "forum"}
 <table id='posts_table'>
    <thead>
    <tr class='headers'>
        {foreach from=array("Title", "Category", "Author", "Posts", "Views", "Last") item=header}
            <th class='{$header}'>{$header}</th>
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
                <td class='{$key}'><a href=""><img title="{$value}"
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