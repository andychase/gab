{extends 'base/forumbase.tpl'}

{block "forum"}
{strip}
<div id='users_page'>
    {if $you}
        <div id="your_profile">
            <a href="{$baseurl}/user/{$you.author_name}" title='{$you.author_name|escape}'>
                <img src='{$you.author_email_hash|avatar:64}' class='author_image' alt='{$you.author_name|escape}' />
                <span>{$you.author_name}</span>
            </a>
        </div>
    {/if}
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
