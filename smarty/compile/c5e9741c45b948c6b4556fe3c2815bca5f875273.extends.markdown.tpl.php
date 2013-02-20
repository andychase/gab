<?php /* Smarty version Smarty-3.1.13, created on 2013-02-19 20:08:49
         compiled from "C:\Users\a5c\Desktop\ab\Apps\xampp\htdocs\extensions\markdown\markdown.tpl" */ ?>
<?php /*%%SmartyHeaderCode:254425124499eab7015-55640375%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5e9741c45b948c6b4556fe3c2815bca5f875273' => 
    array (
      0 => 'C:\\Users\\a5c\\Desktop\\ab\\Apps\\xampp\\htdocs\\extensions\\markdown\\markdown.tpl',
      1 => 1361333326,
      2 => 'file',
    ),
    '0a81252e37faf6515476858785149c8034eee79f' => 
    array (
      0 => 'templates\\single_post.tpl',
      1 => 1361333326,
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
      1 => 1361328106,
      2 => 'file',
    ),
    '1953c9e401a647e90c8c0e700496ca6b70a599b0' => 
    array (
      0 => 'templates\\new_thread.tpl',
      1 => 1361253877,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '254425124499eab7015-55640375',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5124499edcb773_85434891',
  'variables' => 
  array (
    'assets_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5124499edcb773_85434891')) {function content_5124499edcb773_85434891($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'C:\\Users\\a5c\\Desktop\\ab\\Apps\\xampp\\htdocs\\smarty\\plugins\\modifier.truncate.php';
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

    <link href='http://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>

    <style type="text/css">
        body {
            width: 600px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 125px;
        }
    </style>

</head>
<body>




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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('new_thread.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '254425124499eab7015-55640375');
content_51244c512d3a22_08553375($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "new_thread.tpl" */?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['forum_section']->value=="cat"){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/new_category" id="new_link" class="nav_section new_link ss-plus"><span>New Category</span></a>
        <?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable('Category', null, 0);?>
        <?php /*  Call merged included template "new_thread.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('new_thread.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '254425124499eab7015-55640375');
content_51244c51349897_67278102($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "new_thread.tpl" */?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['forum_section']->value=="msg"){?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/new_message" id="new_link" class="nav_section new_link ss-plus"><span>New Message</span></a>
        <?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable('Message', null, 0);?>
        <?php /*  Call merged included template "new_thread.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('new_thread.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '254425124499eab7015-55640375');
content_51244c513cea67_01826022($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "new_thread.tpl" */?>
    <?php }?>
    
<div class='post_replies'>
    <h2><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['topic']->value['title'], ENT_QUOTES, 'UTF-8', true);?>

        <?php if ($_smarty_tpl->tpl_vars['topic']->value['category']){?>
            <a href='<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/category/<?php echo $_smarty_tpl->tpl_vars['topic']->value['category'];?>
' class="category <?php echo $_smarty_tpl->tpl_vars['topic']->value['category'];?>
"><?php echo $_smarty_tpl->tpl_vars['topic']->value['category'];?>
</a>
        <?php }?>
    </h2>
    <div class='post_container'>
        <div class='post_user'>
            
            <img src='http://www.gravatar.com/avatar/<?php echo $_smarty_tpl->tpl_vars['topic']->value['author_email_hash'];?>
?s=40&d=retro' class='author_image' alt='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['topic']->value['author_name'], ENT_QUOTES, 'UTF-8', true);?>
' />
            <span class='author_name'><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['topic']->value['author_name'], ENT_QUOTES, 'UTF-8', true);?>
</span><br />
            <span class='post_time'><?php echo smarty_modifier_timeAgo($_smarty_tpl->tpl_vars['topic']->value['timestamp']);?>
</span>
            
        </div>
        <div class='post_body'><?php echo smarty_modifier_markdown(htmlspecialchars($_smarty_tpl->tpl_vars['topic']->value['message'], ENT_QUOTES, 'UTF-8', true));?>
</div>
    </div>

    <?php  $_smarty_tpl->tpl_vars['post'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['post']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['replies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['post']->key => $_smarty_tpl->tpl_vars['post']->value){
$_smarty_tpl->tpl_vars['post']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['post']->key;
?>
        <div class='post_container'>
            <div class='post_user'>
                <a class="post_anchor" id="post<?php echo $_smarty_tpl->tpl_vars['post']->value['id'];?>
"></a>
                <img src='http://www.gravatar.com/avatar/<?php echo $_smarty_tpl->tpl_vars['post']->value['author_email_hash'];?>
?s=40&d=retro' class='author_image' alt='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['author_name'], ENT_QUOTES, 'UTF-8', true);?>
' />
                <span class='author_name'><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['author_name'], ENT_QUOTES, 'UTF-8', true);?>
</span><br />
                <span class='post_time'><?php echo smarty_modifier_timeAgo($_smarty_tpl->tpl_vars['post']->value['timestamp']);?>
</span>
            </div>
            <div class='post_body'><?php echo smarty_modifier_markdown(htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['message'], ENT_QUOTES, 'UTF-8', true));?>
</div>
        </div>
    <?php } ?>
    <?php if ($_smarty_tpl->tpl_vars['topic']->value['replies']>60){?>
        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 60;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['topic']->value['replies']+1 - (0) : 0-($_smarty_tpl->tpl_vars['topic']->value['replies'])+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['topic']->value['id'];?>
?skip=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
        <?php }} ?>
    <?php }?>

    <div id='submit_reply'>
        <a id="reply"></a>
        <h3>Reply</h3>
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
        <form action="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['topic']->value['id'];?>
#reply" method="post" class="savable">
            <label>
                <textarea name="text"></textarea>
            </label>
            <div id="save_warning"></div>
            <input name="text_b" class="text_b" />
            <div id='preview'></div>
            <input type="hidden" name="do" value="forum_reply" />
            <input type="hidden" name="topic_id" value="<?php echo $_smarty_tpl->tpl_vars['topic']->value['id'];?>
" />
            <input type="submit" class="submit" value="Submit">
        </form>
    </div>
</div>

</div>






</body>
</html><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-02-19 20:08:49
         compiled from "templates\new_thread.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51244c512d3a22_08553375')) {function content_51244c512d3a22_08553375($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['new_name']->value==''){?><?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable("Thread", null, 0);?><?php }?>
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
</div><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-02-19 20:08:49
         compiled from "templates\new_thread.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51244c51349897_67278102')) {function content_51244c51349897_67278102($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['new_name']->value==''){?><?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable("Thread", null, 0);?><?php }?>
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
</div><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-02-19 20:08:49
         compiled from "templates\new_thread.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51244c513cea67_01826022')) {function content_51244c513cea67_01826022($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['new_name']->value==''){?><?php $_smarty_tpl->tpl_vars['new_name'] = new Smarty_variable("Thread", null, 0);?><?php }?>
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