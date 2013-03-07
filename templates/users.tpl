{extends 'base/forumbase.tpl'}

{block "forum"}
{strip}
<div id='users_page'>
    <ul>
    {foreach from=$users item=user}
                <li>
                    <a href="{$baseurl}/user/{$user.author_name}" title='{$user.author_name|escape}'>
                        <img src='{$user.author_email_hash|avatar}' class='author_image' alt='{$user.author_name|escape}' />
                        {$user.author_name}
                    </a>
                </li>
    {/foreach}
    </ul>
</div>
{/strip}
{/block}
