{block 'new_links' append}
    {if !$logged_in}
    <div id="new_thread">
        <h2>Login</h2>
        <!-- Simple OpenID Selector -->
        <form action="/ext/openid" method="get" id="openid_form">
            <input type="hidden" name="action" value="verify" />
                <div id="openid_choice">
                    <div id="openid_btns"></div>
                </div>
                <div id="openid_input_area">
                    <input id="openid_identifier" name="openid_identifier" type="text" value="http://" />
                    <input id="openid_submit" type="submit" value="Sign-In"/>
                </div>
                <noscript>
                    <p>OpenID is service that allows you to log-on to many different websites using a single indentity.
                        Find out <a href="http://openid.net/what/">more about OpenID</a> and <a href="http://openid.net/get/">how to get an OpenID enabled account</a>.</p>
                </noscript>
        </form>
    </div>
    {/if}
{/block}

{block 'extra_links' append}
    {if !$logged_in}
        <a href="{$base_url}/login" id="new_link" class="nav_section new_link ss-plus"><span>Login</span></a>
        {$new_name = 'Login'}
    {else}
        <a href="{$base_url}/ext/openid_logout" class="nav_section new_link"><span>Logout</span></a>
    {/if}
{/block}
