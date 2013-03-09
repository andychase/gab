{$step = 60}
{if $number_of_items > $step}
<div id="pages">
    {for $i=0 to $number_of_items step $step}
        {if $i == $current_skip}
            <span>{$i}</span>
        {else}
            <a href="./?skip={$i}">{$i}</a>
        {/if}
    {/for}
</div>
{/if}