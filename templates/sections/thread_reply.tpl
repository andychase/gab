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
        <form action="{$base_url}/{$topic.id}#reply" method="post" class="savable" enctype="multipart/form-data">
            {block 'reply_extra_info'}{/block}

            {*<div class="watch">Notified on replies:
                <label><input type="radio" name="watch" value="no" checked="checked" />No</label>
                <label><input type="radio" name="watch" value="yes" />Yes</label>
                <label><input type="radio" name="watch" value="daily" />Daily At Most</label>
                <br />
                <label id="watch_email">Email: <input type="text" name="email" />(Not made public)</label>
            </div>
            *}
            <label class="reply_textarea">
                <textarea name="text"></textarea>
            </label>
            {block 'reply_actions'}{/block}
            <div id="save_warning"></div>
            <input name="text_b" class="text_b" disabled="disabled" />
            <div id='preview'></div>
            <input type="hidden" name="do" value="forum_reply" />
            <input type="hidden" name="topic_id" value="{$topic.id}" />
            <input type="submit" class="submit" value="Submit">
        </form>
    </div>
{/block}