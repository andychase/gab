{block 'reply_actions'}
    {if $allow_uploads}
        <div id="include_file">
            <label>(2MB Max)<input type="file" name="file"></label><br />
        </div>
    {/if}
{/block}