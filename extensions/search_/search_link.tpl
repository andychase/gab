{block 'extra_links' prepend}
    <form action="/ext/search" id="search">
        <input type="text" name="q" />
        <button type="submit" value="search" class="submit" title="Search" ></button>
    </form>
{/block}
{block 'head' append}
    <script type='text/javascript'>var search_url="{$search_url}";</script>
{/block}