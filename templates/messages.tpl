{block "forum"}
<div id='messages'>
        {foreach from=$messages item=message}
        <div class="message">
            <a href="{$base_url}/{$message.reply_to}#post{$message.id}">
                Mention by
                <span class="author">{$message.author_name}</span>
                <span class="time">{$message.time_created|timeAgo} ago</span>
                <span class="topic_title">{$message.title}</span>
            </a>
            <blockquote>{$message.message|truncate:100}</blockquote>
        </div>
        {/foreach}
</div>
{/block}