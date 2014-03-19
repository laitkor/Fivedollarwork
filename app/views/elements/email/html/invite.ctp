Hi User ,
<br />
<br />
<b><?php echo $record['email'];?></b> has sent an invitation for  <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><b><?php echo SITE_NAME;?>.</b></a>
<br />
<p align="justify">Five Dollar Work is a platform or a marketplace where users sell and buy's services and products just for 5$ base price. People get registered and broadcast what they are willing to do for $5 base price.</p><br />

You can view the site by <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"> <strong>Clicking Here</strong> </a>
<br /><br /><br /><?php if($record['message']!="") { ?>
<b>Here is Sender's Custom Message :</b>
<br />
<?php echo $record['message']; }?>
<br /> 
<br /> <br /><br /><br />
Regards,
<br /><br />
<a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a> Team


