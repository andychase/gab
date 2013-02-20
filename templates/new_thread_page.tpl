{block 'head'}
<style type="text/css">
    #forum #new_thread {
        display: block !important;
    }
</style>
{/block}

{block name="content"}
    <div id="forum">
        {include 'new_thread.tpl'}
    </div>
{/block}