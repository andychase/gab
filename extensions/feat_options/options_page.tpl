{block 'head' append}
<style type="text/css">
#settings_nav {
    margin-top: 0pt;
    text-align: center;

}
#settings_nav a {
    margin-right: 15px;
    color: black;
}
#settings_title {
    margin-top: 0px;
    text-align: center;
    font-size: 12pt;
    color: grey;
    width: 100%;
}
.theme_screenshot {
    width: 512px;
    float: right;
    clear: left;
}
.theme_screenshot_frame {
    display: block;
    height: 175px;
    overflow: hidden;
}
.center {
    display: block;
    width: 100%;
    text-align: center;
}
</style>
{/block}

{block 'forum'}

<br />
<h2 id="settings_title">Forum Options:</h2>

<div id="settings_nav">
    <a href="?section=">General</a>
    <a href="?section=theme">Theme</a>
    <a href="?section=ext">Extensions</a>
</div>

<form action='' method="post" id="config">
<input type='hidden' name='do' value='save_config' />
{if $section == ''}
    {block 'general'}{/block}
{elseif $section == 'theme'}
    {block 'theme'}{/block}
{elseif $section == 'ext'}
    {block 'ext'}{/block}
{/if}
<span class="center">
    <input type="submit" value="Save" class="save" />
</span>
</form>

{/block}

{block 'general'}

<h3>Forum Name & Description</h3>
<label for="name">Name:<br />
    <input type="text" id="name" name="name" value="{$forum_name}" {$name_disabled}/>
</label><br />
<label for="description">Description:<br />
    <textarea rows="4" cols="70" id="description" name="description">{$forum_desc|trim}</textarea>
</label>
{/block}

{block 'theme'}
<h3>Theme</h3>
<input type="radio" name="theme" id="theme_none" value="none" />
<label for="theme_none" class="theme_label">No theme
    <span class="theme_screenshot_frame">
        <img src="/extensions/feat_options/none.png" alt="Screenshot of no theme" class="theme_screenshot" />
    </span>
</label>
{foreach $themes as $theme}
<input type="radio" name="theme" id="theme{$theme@index}" value="{$theme.name}" {if $theme.active}checked="checked"{/if} />
<label for="theme{$theme@index}" class="theme_label">{$theme.name|substr:6}
    <span class="theme_screenshot_frame">
        <img src="/{$theme.thumb}" alt="Screenshot of {$theme.name|substr:6}" class="theme_screenshot" />
    </span>
</label>
{/foreach}

{/block}

{block 'ext'}
<h3>Extensions</h3>
<table>
    <thead><tr><th>Extension</th><th>On</th><th>Off</th><th>Description</th><th></th></tr></thead>
    <tbody>
        {foreach $exts as $ext}
        <tr>
            <td>{$ext.name}</td>
            <td><input type="radio" name="{$ext.name}" value="on" {if $ext.active}checked="checked"{/if} /></td>
            <td><input type="radio" name="{$ext.name}" value="off" {if !$ext.active}checked="checked"{/if} /></td>
            <td>{$ext.desc}</td>
            <td>{*<a href="http://gabBB.com/ext/{$ext.name}">-&gt;</a>*}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
{/block}






















