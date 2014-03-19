<?php
//////////////////////////////////////
// Create By : Nitin Kumar Shukla   // 
// Date : 28/04/2011                //
//////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->meta(array('name' => 'Created By', 'content' => 'Nitin Kumar Shukla')); ?>
<title><?php if($setting['Setting']['title']!=''){ echo $setting['Setting']['title'].' : '.$title_for_layout;} else {echo SITE_NAME.' : '.$title_for_layout;}?></title>
<?php echo $this->Html->meta('favicon.ico','/favicon.ico',array('type' => 'icon'));?>
<link rel="stylesheet" type="text/css" href="/css/admin/theme.css" />
<link rel="stylesheet" type="text/css" href="/css/admin/style.css" />
<script>
   var StyleFile = "theme" + document.cookie.charAt(6) + ".css";
   document.writeln('<link rel="stylesheet" type="text/css" href="/css/admin/' + StyleFile + '">');
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="/css/admin/ie-sucks.css" />
<![endif]-->
<script type="text/javascript" src="/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<?php 
echo $javascript->link('modalbox/prototype');
echo $javascript->link('modalbox/scriptaculous.js?load=builder,effects');
echo $javascript->link('modalbox/modalbox');
echo $html->css('modalbox');
?>
</head>
<body>
	<div id="container">
   <?php echo $this->element('admin/header');  ?>
        <div id="wrapper">
            <div id="content">
           <?php $massage=$this->Session->Flash(); if($massage!="") {?> <div id="box" align="center"><h3><?php echo $massage; ?></h3></div><?php }?>
                <?php echo $content_for_layout; ?> 
            </div>
         <?php echo $this->element('admin/sidebar');  ?>   
      </div>
<?php echo $this->element('admin/footer'); ?> 
<?php echo $this->element('sql_dump'); ?>
</div>
</body>
</html>