{block 'thread_reply_section'}
    <div id='submit_reply'>
        <a id="reply"></a>
        <h3>Reply</h3>
    {if $posterror}
        <ul class="errors">
            {foreach $posterrors as $errors}
                <li>{$errors}</li>
            {/foreach}
        </ul>
    {/if}
        <form action="{$base_url}/{$topic.id}#reply" method="post" class="savable">
            <label>
                <textarea name="text"></textarea>
            </label>
            <div id="save_warning"></div>
            <input name="text_b" class="text_b" />
            <div id='preview'></div>
            <input type="hidden" name="do" value="forum_reply" />
            <input type="hidden" name="topic_id" value="{$topic.id}" />
            <input type="submit" class="submit" value="Submit">
        </form>
    </div>
{/block}