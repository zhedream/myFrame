<?php
/* Smarty version 3.1.30, created on 2018-06-03 10:11:11
  from "C:\Users\l1951\Desktop\SMT\app\Home\View\Index\testbootsrap.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b13bebfdbf210_26247269',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e586235dc585171bc610cdf611738a79bec1c052' => 
    array (
      0 => 'C:\\Users\\l1951\\Desktop\\SMT\\app\\Home\\View\\Index\\testbootsrap.html',
      1 => 1528020353,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b13bebfdbf210_26247269 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- 视口 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="Public/css/bootstrap.min.css">
    <title>测试bootsrap</title>
</head>
<body>

    <h1>测试</h1>
    <a href="#" class="btn btn-success">连接按钮</a>

    <?php echo $_smarty_tpl->tpl_vars['name']->value;?>



    
    <?php echo '<script'; ?>
 src="Public/js/jquery-3.2.1.min.js"><?php echo '</script'; ?>
>
     <?php echo '<script'; ?>
 src="Public/js/bootstrap.min.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
