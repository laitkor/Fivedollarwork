Dear <?php echo $record['name'];?>,
<br />
<br />
This is an automated message sent at your request from <a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a>.
<br />
<br />
A new issue was just created By <?php echo $record['name'];?> .Details of this
issue are given below:
<br />
<br />
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="50%"><b>Subject :</b></td>
    <td width="50%"><?php echo $record['subject'];?></td>
  </tr>
  <?php if($record['Order']!='') {?>
  <tr>
    <td><b>Order :</b></td>
    <td><?php echo $record['Order'];?></td>
  </tr><?php }?>
  <tr>
    <td><b>Name :</b></td>
    <td><?php echo $record['name'];?></td>
  </tr>
  <tr>
    <td><b>Email :</b></td>
    <td><?php echo $record['email'];?></td>
  </tr>
  <tr>
    <td><b>Message :</b></td>
    <td><?php echo $record['message'];?></td>
  </tr>
</table>
<br /> 
<br /> 
Regards
<br />
<a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a> Team