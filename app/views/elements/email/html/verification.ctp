Dear <?php echo $record['username'];?>,
<br /><br />
Email Verification email from <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a>. Your <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a> Account has not been activated yet.
<br /><br />
We request you to please activate your account by clicking the following link:
<br />
<?php echo $siteurl.'/users/activateaccount/'.$record['activation_key'];?>
<br /><br />
If the above link is not active, you can copy and paste it in the address bar of your browser and hit enter key.
<br /><br />
Regards
<br />
<a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a> Team