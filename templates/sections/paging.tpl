{if $topic.replies > 60}
<div id="pages">
    {for $i=0 to $topic.replies step 60}
        <a href="{$base_url}/{$topic.id}?skip={$i}">{$i}</a>
    {/for}
</div>
{/if}