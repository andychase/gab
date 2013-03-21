{block 'thread_reply' append}
    {if !$logged_in}
        {include 'sections/thread_reply.tpl'}
    {/if}
{/block}
{block 'reply_extra_info'}
    {if !$logged_in}
        <div id="annon_post">
            <label>Name: <input type="text" name="name" /></label>
        </div>
    {/if}
{/block}