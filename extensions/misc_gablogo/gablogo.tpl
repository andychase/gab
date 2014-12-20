{block 'head' append}
    {block 'gab_logo_font'}
        <link href='http://fonts.googleapis.com/css?family=Knewave' rel='stylesheet' type='text/css'>
    {/block}
{/block}

{block 'body' prepend}
    {block 'gab_logo'}
        {strip}
            <div id="gabsite_navsection">
                <h1 id="gabname"><a href="/">Gab</a></h1>
                <div id="gabsite_navlinks">
                    <a href="/">community</a>
                    {*<a href="/ext">ext marketplace</a>*}
                    <a href="http://github.com/andychase/gab" class="last">source/download</a>
                </div>
            </div>
        {/strip}
    {/block}
{/block}

