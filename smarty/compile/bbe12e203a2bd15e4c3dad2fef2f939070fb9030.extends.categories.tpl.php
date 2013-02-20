<?php /* Smarty version Smarty-3.1.13, created on 2013-02-19 23:04:31
         compiled from "templates\categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:218125124466a0a4906-10685652%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bbe12e203a2bd15e4c3dad2fef2f939070fb9030' => 
    array (
      0 => 'templates\\categories.tpl',
      1 => 1361327461,
      2 => 'file',
    ),
    'fe5799fc21691dd44bde3ef20ba605f39d0a5d8f' => 
    array (
      0 => 'templates\\base.tpl',
      1 => 1361326961,
      2 => 'file',
    ),
    '2ebc1f93a7c11e6e566d9840b20a96a69c2116c7' => 
    array (
      0 => 'templates\\html_base.tpl',
      1 => 1361343863,
      2 => 'file',
    ),
    '1953c9e401a647e90c8c0e700496ca6b70a599b0' => 
    array (
      0 => 'templates\\new_thread.tpl',
      1 => 1361253877,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '218125124466a0a4906-10685652',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5124466a371441_94919517',
  'variables' => 
  array (
    'assets_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5124466a371441_94919517')) {function content_5124466a371441_94919517($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'C:\\Users\\a5c\\Desktop\\ab\\Apps\\xampp\\htdocs\\smarty\\plugins\\modifier.truncate.php';
if (!is_callable('smarty_modifier_replace')) include 'C:\\Users\\a5c\\Desktop\\ab\\Apps\\xampp\\htdocs\\smarty\\plugins\\modifier.replace.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title>Gab Test</title>
    <meta name="description" content="Embeddable, Extendable, Minimal next-gen forum software that's easy to deploy." />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['assets_url']->value;?>
/gab.css" />
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['assets_url']->value;?>
/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['assets_url']->value;?>
/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['assets_url']->value;?>
/markdown.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['assets_url']->value;?>
/hash.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['assets_url']->value;?>
/script.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Knewave' rel='stylesheet' type='text/css'>

    <style type="text/css">
        body {
            width: 600px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 125px;
        }
        h1 {
            font-family: "Knewave", sans-serif;
            font-size: 72pt;
            color: black;
            text-shadow: 0px 2px 5px black;

        }
        h1 a {
            color: black; text-decoration: none;
            text-shadow: none;
        }
        h1 a:visited { color: black;}
    </style>

</head>
<body>

<h1><a href="">Gab</a></h1>




<div id="forum" class="<?php echo $_smarty_tpl->tpl_vars['forum_section']->value;?>
">
    <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/" class="nav_section posts">Posts</a>
    <?php if ($_smarty_tpl->tpl_vars['topic']->value){?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['topic']->value['id'];?>
" class="nav_section posts single"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['topic']->value['title'],30);?>
</a>
    <?php }?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/categories" class="nav_section cat">Categories</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/messages" class="nav_section msg">Messages</a>
    <?php if ($_smarty_tpl->tpl_vars['forum_section']->value=="posts"&&!$_smarty_tpl->tpl_vars['topic']->value){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/new_thread" id="new_link" class="nav_section new_link ss-plus"><span>New Thread</span></a>
        <?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable('Thread', null, 0);?>
        <?php /*  Call merged included template "new_thread.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('new_thread.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '218125124466a0a4906-10685652');
content_5124757f65cc45_69082776($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "new_thread.tpl" */?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['forum_section']->value=="cat"){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/new_category" id="new_link" class="nav_section new_link ss-plus"><span>New Category</span></a>
        <?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable('Category', null, 0);?>
        <?php /*  Call merged included template "new_thread.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('new_thread.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '218125124466a0a4906-10685652');
content_5124757f6d0915_40026670($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "new_thread.tpl" */?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['forum_section']->value=="msg"){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/new_message" id="new_link" class="nav_section new_link ss-plus"><span>New Message</span></a>
        <?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable('Message', null, 0);?>
        <?php /*  Call merged included template "new_thread.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('new_thread.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '218125124466a0a4906-10685652');
content_5124757f7456f7_15909854($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "new_thread.tpl" */?>
    <?php }?>
    
<div id='categories_page'>
    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
            <table class="category_table">
                <thead>
                <tr>
                    <th colspan="3">
                        <?php if ($_smarty_tpl->tpl_vars['category']->value['title']){?>
                        <a href='<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/category/<?php echo mb_strtolower(smarty_modifier_replace($_smarty_tpl->tpl_vars['category']->value['title']," ","_"), 'UTF-8');?>
'
                           class="category <?php echo mb_strtolower(smarty_modifier_replace($_smarty_tpl->tpl_vars['category']->value['title']," ","_"), 'UTF-8');?>
">
                            <?php echo $_smarty_tpl->tpl_vars['category']->value['title'];?>

                        </a>
                        <?php }?>
                        <span class="description">
                            <?php echo $_smarty_tpl->tpl_vars['category']->value['message'];?>

                        </span>
                    </th>
                 </tr>
                 <tr>
                    <th class='Title'>Title</th>
                    <th>Replies</th>
                    <th>Last</th>
                </tr>
                </thead>
                <tbody>
                <?php  $_smarty_tpl->tpl_vars['post'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['post']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category']->value['posts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['post']->key => $_smarty_tpl->tpl_vars['post']->value){
$_smarty_tpl->tpl_vars['post']->_loop = true;
?>
                <tr>
                    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['post']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                        <?php if ($_smarty_tpl->tpl_vars['key']->value=='id'){?>
                            <td class='<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
'><a href='<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
'>
                                <?php }elseif($_smarty_tpl->tpl_vars['key']->value=='title'){?>
                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
 </a></td>
                            <?php }elseif($_smarty_tpl->tpl_vars['key']->value=='last_reply'){?>
                            <td class='<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
'><?php if ($_smarty_tpl->tpl_vars['value']->value){?><?php echo smarty_modifier_timeAgo($_smarty_tpl->tpl_vars['value']->value);?>
<?php }?></td>
                            <?php }else{ ?>
                            <td class='<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
'><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
</td>
                        <?php }?>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
    <?php } ?>
</div>

</div>






</body>
</html><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-02-19 23:04:31
         compiled from "templates\new_thread.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5124757f65cc45_69082776')) {function content_5124757f65cc45_69082776($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['new_name']->value==''){?><?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable("Thread", null, 0);?><?php }?>
<div id="new_thread">
    <form action="/#new_<?php echo mb_strtolower($_smarty_tpl->tpl_vars['new_name']->value, 'UTF-8');?>
" method="post" class="savable">
        <h3>New <?php echo $_smarty_tpl->tpl_vars['new_name']->value;?>
</h3>
        <?php if ($_smarty_tpl->tpl_vars['posterror']->value){?>
            <ul class="errors">
                <?php  $_smarty_tpl->tpl_vars['errors'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['errors']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['posterrors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['errors']->key => $_smarty_tpl->tpl_vars['errors']->value){
$_smarty_tpl->tpl_vars['errors']->_loop = true;
?>
                    <li><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</li>
                <?php } ?>
            </ul>
        <?php }?>
         <label>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Message"){?>To:<?php }?>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Category"){?>Name:<?php }?>
            <input type="text" name="title" id="new_thread_title" />
        </label>
        <label>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Category"){?>Description:
            <input type="text" name="Description" id="new_category_description" />
            <?php }else{ ?>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Message"){?>Message:<?php }?>
            <textarea name="text"></textarea>
            <?php }?>
        </label>
        <div id="save_warning"></div>
        <input type="hidden" name="do" value="forum_new_thread" />
        <div id="preview">
        </div>
        <input type="text" name="title_b" class="text_b" />
        <input type="submit" class="submit" value="Submit">
    </form>
</div><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-02-19 23:04:31
         compiled from "templates\new_thread.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5124757f6d0915_40026670')) {function content_5124757f6d0915_40026670($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['new_name']->value==''){?><?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable("Thread", null, 0);?><?php }?>
<div id="new_thread">
    <form action="/#new_<?php echo mb_strtolower($_smarty_tpl->tpl_vars['new_name']->value, 'UTF-8');?>
" method="post" class="savable">
        <h3>New <?php echo $_smarty_tpl->tpl_vars['new_name']->value;?>
</h3>
        <?php if ($_smarty_tpl->tpl_vars['posterror']->value){?>
            <ul class="errors">
                <?php  $_smarty_tpl->tpl_vars['errors'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['errors']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['posterrors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['errors']->key => $_smarty_tpl->tpl_vars['errors']->value){
$_smarty_tpl->tpl_vars['errors']->_loop = true;
?>
                    <li><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</li>
                <?php } ?>
            </ul>
        <?php }?>
         <label>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Message"){?>To:<?php }?>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Category"){?>Name:<?php }?>
            <input type="text" name="title" id="new_thread_title" />
        </label>
        <label>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Category"){?>Description:
            <input type="text" name="Description" id="new_category_description" />
            <?php }else{ ?>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Message"){?>Message:<?php }?>
            <textarea name="text"></textarea>
            <?php }?>
        </label>
        <div id="save_warning"></div>
        <input type="hidden" name="do" value="forum_new_thread" />
        <div id="preview">
        </div>
        <input type="text" name="title_b" class="text_b" />
        <input type="submit" class="submit" value="Submit">
    </form>
</div><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-02-19 23:04:31
         compiled from "templates\new_thread.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5124757f7456f7_15909854')) {function content_5124757f7456f7_15909854($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['new_name']->value==''){?><?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable("Thread", null, 0);?><?php }?>
<div id="new_thread">
    <form action="/#new_<?php echo mb_strtolower($_smarty_tpl->tpl_vars['new_name']->value, 'UTF-8');?>
" method="post" class="savable">
        <h3>New <?php echo $_smarty_tpl->tpl_vars['new_name']->value;?>
</h3>
        <?php if ($_smarty_tpl->tpl_vars['posterror']->value){?>
            <ul class="errors">
                <?php  $_smarty_tpl->tpl_vars['errors'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['errors']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['posterrors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['errors']->key => $_smarty_tpl->tpl_vars['errors']->value){
$_smarty_tpl->tpl_vars['errors']->_loop = true;
?>
                    <li><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</li>
                <?php } ?>
            </ul>
        <?php }?>
         <label>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Message"){?>To:<?php }?>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Category"){?>Name:<?php }?>
            <input type="text" name="title" id="new_thread_title" />
        </label>
        <label>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Category"){?>Description:
            <input type="text" name="Description" id="new_category_description" />
            <?php }else{ ?>
            <?php if ($_smarty_tpl->tpl_vars['new_name']->value=="Message"){?>Message:<?php }?>
            <textarea name="text"></textarea>
            <?php }?>
        </label>
        <div id="save_warning"></div>
        <input type="hidden" name="do" value="forum_new_thread" />
        <div id="preview">
        </div>
        <input type="text" name="title_b" class="text_b" />
        <input type="submit" class="submit" value="Submit">
    </form>
</div><?php }} ?>