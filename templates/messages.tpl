{block "forum"}
<div id='messages'>
        {foreach from=$messages item=message}
        <div class="message">
            <a href="{$base_url}/{$message.reply_to}#post{$message.id}">
                Mention by
                <span class="author">{$message.author_name}</span>
                <span class="time">{block 'message_time'}on {$message.time_created}{/block}</span>
                <span class="topic_title">{$message.title}</span>
            </a>
            <blockquote>{$message.message|truncate:100}</blockquote>
        </div>
        {/foreach}
</div>
{/block}