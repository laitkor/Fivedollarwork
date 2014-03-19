<b>Dear <?php echo $record['username'];?></b>,
<br /><br />
You recently registered for an account with <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a>. This message is to confirm that the (<?php echo $record['email'];?>) email address belongs to you. If you did not register for an account at <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a>, please ignore this email otherwise, click on the link below to confirm and log into your new account.
<br /><br />
We request you to please activate your account by clicking the following link:
<br />
<?php echo $siteurl.'/users/activateaccount/'.$record['activation_key'];?>
<br /><br />
If the above link is not active, you can copy and paste it in the address bar of your browser and hit enter key.
<br /><br />
Thank you for using <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a>, we are happy to serve you!
<br /><br />
Sincerely,
<br />
<a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a> Team