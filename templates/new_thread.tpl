{if $new_name == ""}{$new_name = "Thread"}{/if}
<div id="new_thread">
    <form action="/#new_{$new_name|lower}" method="post" class="savable">
        <h3>New {$new_name}</h3>
        {if $posterror}
            <ul class="errors">
                {foreach $posterrors as $errors}
                    <li>{$errors}</li>
                {/foreach}
            </ul>
        {/if}
         <label>
            {if $new_name == "Message"}To:{/if}
            {if $new_name == "Category"}Name:{/if}
            <input type="text" name="title" id="new_thread_title" />
        </label>
        <label>
            {if $new_name == "Category"}Description:
            <input type="text" name="Description" id="new_category_description" />
            {else}
            {if $new_name == "Message"}Message:{/if}
            <textarea name="text"></textarea>
            {/if}
        </label>
        <div id="save_warning"></div>
        <input type="hidden" name="do" value="forum_new_thread" />
        <div id="preview">
        </div>
        <input type="text" name="title_b" class="text_b" />
        <input type="submit" class="submit" value="Submit">
    </form>
</div>