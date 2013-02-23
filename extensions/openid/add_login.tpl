{block 'head' append}
<script type="text/javascript" src="{$ext_url}/openid/openid-selector/js/openid-jquery.js"></script>
<script type="text/javascript" src="{$ext_url}/openid/openid-selector/js/openid-en.js"></script>
<link type="text/css" rel="stylesheet" href="{$ext_url}/openid/openid-selector/css/openid.css" />
<script type="text/javascript">
    $(document).ready(function() {
        openid.init('openid_identifier');
        //openid.setDemoMode(true); //Stops form submission for client javascript-only test purposes
    });
</script>
{/block}

{block 'new_links' append}
    {if !$logged_in}
    <a href="{$base_url}/login" id="new_link" class="nav_section new_link ss-plus"><span>Login</span></a>
    {$new_name = 'Login'}
    <div id="new_thread">
        <h2>JQuery Simple OpenID Selector Demo</h2>
        <p>This is a simple example to show how you can include the Javascript into your page.</p>
        <br/>
        <!-- Simple OpenID Selector -->
        <form action="/ext/openid" method="get" id="openid_form">
            <input type="hidden" name="action" value="verify" />
            <fieldset>
                <legend>Sign-in or Create New Account</legend>
                <div id="openid_choice">
                    <p>Please click your account provider:</p>
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
            </fieldset>
        </form>
    </div>
    {/if}
{/block}