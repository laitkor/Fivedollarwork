Dear <?php echo  $username;?>,
<br /><br />
<?php if($type==1){?>
You had submited a request for forgot Username at <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a>. Your Username details are given below. 
<br /><br />
<b>Username</b>&nbsp;&nbsp;&nbsp;&nbsp;<b>:</b>&nbsp;&nbsp;<b><?php echo  $username;?></b>
<br /><br />
Please <a href="<?php echo $siteurl.'/users/signin';?>">Sign in</a> to your account.
<?php } if($type==2) {?>
You had submited a request for forgot password at <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a>.
<br /><br>
If you want to reset your password then click on link below
other wise ignore this mail<br /><br /><?php echo $siteurl.'/users/newpassword/'.$activation_key;?>
<?php }?> 
<br />
<br />
Regards
<br />
<a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a> Team