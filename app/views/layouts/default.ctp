<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">

<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type"/>
<script src="http://platform.twitter.com/anywhere.js?id=ufeQt0zeoiRqSzZDuz7eEA&v=1" type="text/javascript"></script>
<?php echo $this->Html->meta('keywords',KEYWORDS); ?>
<?php echo $this->Html->meta('description',DESCRIPTION); ?> 
<?php echo $this->Html->meta(array('name' => 'robots', 'content' => 'index')); ?>
<?php echo $this->Html->meta(array('name' => 'Created By', 'content' => 'Fariha Mansoor')); ?>
<title><?php if($setting['Setting']['title']!=''){ echo $setting['Setting']['title'].' : '.$title_for_layout;} else {echo SITE_NAME.' : '.$title_for_layout;}?></title>
<?php echo $this->Html->meta('favicon.ico','/favicon.ico',array('type' => 'icon'));?>
<link media="screen" rel="stylesheet" type="text/css" href="/css/style.css" />
<!-- custom theme css -->
<link media="screen" rel="stylesheet" type="text/css" href="/themes/blue/style.css" />
<!--<script type="text/javascript" src="/js/jquery.tools.min.js"></script>
--><script type="text/javascript" src="/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>

<!--<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<script type="text/javascript">FB.init("95b18d01cc5d1f68930df8f0884c3fef","/xd_receiver.htm");</script>-->

<!--<script type="text/javascript" src="/js/iepngfix_tilebg.js"></script> 
<script type="text/javascript" src="/js/jquery.tools.js"></script>

<script type="text/javascript" src="/js/ikonik.js"></script>-->
</head>
<body>
<div id="wrap">
  <div id="main" class="clearfix">
    <!-- start container -->
    <div id="full" class="container clearfix">
    
      <!-- start head -->
<?php echo $this->element('header');  ?>
      <!-- end head -->
      
      <div class="big-block grid">
      	<div class="big-block-top">
        <?php if($this->Session->check('User')){ 
		$user=$this->Session->read('User.username');
		 if(is_numeric($user)) { 
		 $username=$this->Session->read('User.name'); 
		 }
		 else { $username=$this->Session->read('User.username');
		       }
			/*$username=$this->Session->read('User.name');
			$user=$this->Session->read('User.username');*/
			 ?><div id="cartstatuslogin" >
            <p>
            Welcome&nbsp;&nbsp;<a href="/<?php echo $user;?>" title="Welcome <?php echo $username;?>"><b><?php echo $username;?></b></a>&nbsp;&nbsp;|&nbsp;<a href="/users/signout" title="Sign Out">Sign Out</a></p></div>
<?php } 
else if($this->Session->check('Admin'))
{ $username=$this->Session->read('Admin.username'); ?>
<div id="cartstatuslogin" >
            <p>
Welcome&nbsp;<a href="/admin/index" title="Go to admin dashboard"><?php echo $username;?></a>&nbsp;&nbsp;|&nbsp;<a href="/admin/signout" title="Sign Out">Sign Out</a></p></div>
<?php }
/*else if(isset($FACEBOOK_COOKIE['uid']))
 { 
         ?>
            Welcome&nbsp;&nbsp;<a href="/<?php echo $user;?>" title="Welcome <?php echo $username;?>"><?php echo $username;?></a>&nbsp;&nbsp;|&nbsp;<a href="/users/signout" title="Sign Out">Sign Out</a> 
   <?php } 
   else if(isset($this->Session->read('tw_user')))
 { 
 $username =$this->Session->read('tw_user');
         ?>
            Welcome&nbsp;&nbsp;<a href="/<?php echo $username;?>" title="Welcome <?php echo $username;?>"><?php echo $username;?></a>&nbsp;&nbsp;|&nbsp;<a href="/users/signout" title="Sign Out">Sign Out</a> 
   <?php } */
else
{
?><div id="cartstatus" >
            <p>
<a href="/users/register" title="Join">Join</a>&nbsp;|&nbsp;<a href="/users/signin" title="Sign In">Sign In</a>&nbsp;|&nbsp;Connect&nbsp;<a href="/users/fb_authorize" ><img src="/img/fconnect.png" border="0" alt="FB_Connect" align="top" onmouseover="this.src='/img/fconnect1.png'" 
onmouseout="this.src='/img/fconnect.png'" style="margin-top:-10px;"/></a><a href="/users/tw_authorize"><img src="/img/tconnect.png" border="0" alt="T_Connect" align="top" onmouseover="this.src='/img/tconnect1.png'" 
onmouseout="this.src='/img/tconnect.png'" style="margin-top:-10px;"/></a></p>
          </div>
<?php }?>
        </div>
        <div class="big-block-content clearfix">
            
            <div class="block-left">
            
            	<div class="blog-entry">
                <?php echo $this->Session->flash(); ?>
                <?php echo $content_for_layout; ?>
                </div><!-- end .blog-entry -->
                
            </div><!-- end .block-left -->
         <?php echo $this->element('sidebar');  ?>   
        </div>
        <div class="big-block-bottom"></div>
      </div><!-- end .big-block -->
      
    </div>
    <!-- end container -->

  </div>
</div>

  
<!-- start footer -->
<?php echo $this->element('footer');  ?>
<!-- end footer -->
</body>
</html>
<?php echo $this->element('sql_dump'); ?>
  <script type="text/javascript">
			  function fbs_click() 
			  {
				  u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436′');return false;}
                  
function limitText(limitNum) {
	
	if (document.getElementById('recommend').value.length > limitNum) {
	
		document.getElementById('recommend').value = document.getElementById('recommend').value.substring(0, limitNum);
		
		
	} else {
		
		document.getElementById('countdown').innerHTML = limitNum - document.getElementById('recommend').value.length;
		
	}
}
function limitTitle(limitNum){
	if (document.getElementById('title').value.length > limitNum) {
	
		document.getElementById('title').value = document.getElementById('title').value.substring(0, limitNum);
		
		
	} else {
		
		document.getElementById('charleft').innerHTML = limitNum - document.getElementById('title').value.length;
		
	}
}
function limitDesc(limitNum){
	if (document.getElementById('description').value.length > limitNum) {
	
		document.getElementById('description').value = document.getElementById('description').value.substring(0, limitNum);
		
		
	} else {
		
		document.getElementById('desleft').innerHTML = limitNum - document.getElementById('description').value.length;
		
	}
	
} 
  
</script>
