<table width="550" cellpadding="5" cellspacing="0">
<tbody><tr>
<td style="font-size: 12px; color: rgb(0, 0, 0); font-family: arial,sans-serif;" valign="top" align="left">
Hello <b><?php echo $this->Session->read('User.name')?></b>,<br/>Please find a copy of your invoice.<br><br>
<p>
<span style="font-size: 16px; font-weight: bold;">
Thank you for your order!
</span>
</p>
<table width="100%" bgcolor="#a0a0a0" cellpadding="2" cellspacing="0">
<tbody><tr><td><span style="color: rgb(255, 255, 255); font-size: 12px;">
Order Information
</span></td></tr>
</tbody></table>
<table width="100%" cellpadding="2" cellspacing="0">
<tbody><tr><td valign="top" width="90"><span style="font-size: 12px;">Merchant:</span></td><td valign="top"><span style="font-size: 12px;"><?php echo SITE_NAME;?></span></td></tr>
<tr><td valign="top" width="90"><span style="font-size: 12px;">Description:</span></td><td valign="top"><span style="font-size: 12px;"><?php echo $Gig['Gig']['title'];?></span></td></tr>
</tbody></table>
<table width="100%" cellpadding="0" cellspacing="0">
<tbody><tr><td valign="top" width="250">
<table cellpadding="2" cellspacing="0">
<tbody><tr><td valign="top" width="90"><span style="font-size: 12px;">Invoice&nbsp;Number:</span></td><td valign="top"><span style="font-size: 12px;"><?php echo $Transaction['Transaction']['order_id'];?></span></td></tr>
<tr><td valign="top" width="90"><span style="font-size: 12px;">Customer&nbsp;ID:</span></td><td valign="top"><span style="font-size: 12px;"><?php echo $Transaction['Transaction']['user_id'];?></span></td></tr>
</tbody></table>
</td>
<td valign="top">
<table cellpadding="2" cellspacing="0">
</table>
</td></tr>
</tbody></table>
<hr>
<table width="100%" cellpadding="0" cellspacing="0">
<tbody><tr><td valign="top" width="250">
<span style="font-size: 12px;">
<span style="font-weight: bold;">Billing Information</span>
<br><?php echo $this->Session->read('User.name')?><br>
<a href="mailto:<?php echo $this->Session->read('User.name')?>" target="_blank"><?php echo $this->Session->read('User.email')?></a>
</span>
</td>
<td valign="top">
<span style="font-size: 12px;">
</td></tr>
</tbody></table>
<hr>
<table width="100%" cellpadding="2" cellspacing="0">
<thead>
<tr>
<td width="7%" align="center"><span style="font-size: 12px; font-weight: bold;">Item</span></td>
<td align="justify"><span style="font-size: 12px; font-weight: bold; text-align:justify;">Description</span></td>
<td align="right"  width="5%"><span style="font-size: 12px; font-weight: bold;">Qty</span></td>
<td align="center" width="12%"><span style="font-size: 12px; font-weight: bold;">Taxable</span></td>
<td align="right" width="12%"><span style="font-size: 12px; font-weight: bold;">Unit&nbsp;Price</span></td>
<td align="right" width="12%"><span style="font-size: 12px; font-weight: bold;">Item&nbsp;Total</span></td>
</tr>
</thead>
<tbody>
<tr>
<td><span style="font-size: 12px;">1</span></td>
<td><span style="font-size: 12px;"><?php echo $Gig['Gig']['title'];?></span></td>
<td align="right"><span style="font-size: 12px;">1</span></td>
<td align="center"><span style="font-size: 12px;">N</span></td>
<td align="right"><span style="font-size: 12px;">US&nbsp;$<?php echo $Gig['Gig']['price'];?></span></td>
<td align="right"><span style="font-size: 12px;">US&nbsp;$<?php echo $Gig['Gig']['price'];?></span></td>
</tr>
<!--<tr>
<td><span style="font-size: 12px;">&nbsp;</span></td>
<td colspan="3"><span style="font-size: 12px;"><?php //echo $Gig['Gig']['description'];?></span></td>
<td><span style="font-size: 12px;">&nbsp;</span></td>
<td><span style="font-size: 12px;">&nbsp;</span></td>
</tr>
--></tbody>
</table>
<hr>
<table width="100%" cellpadding="0" cellspacing="0">
<tbody><tr><td align="right">
<table cellpadding="2" cellspacing="0">
<tbody><tr>
<td valign="top" align="right"><span style="font-size: 12px;">Commission:</span></td>
<td valign="top" align="right"><span style="font-size: 12px;">Commission Percent : <?php echo COMMISSION_PERCENT;?>%</span></td>
<td valign="top" align="right"><span style="font-size: 12px;">US&nbsp;$<?php echo $comm=$Transaction['Transaction']['amount']-$Gig['Gig']['price'];?></span></td>
</tr>
<tr>
<td valign="top" align="right"><span style="font-size: 14px; font-weight: bold;">Total:</span></td>
<td valign="top" align="right"><span style="font-size: 14px;"></span></td>
<td valign="top" align="right"><span style="font-size: 14px; font-weight: bold;">US&nbsp;$<?php echo $Transaction['Transaction']['amount'];?></span></td>
</tr>
</tbody></table>
</td></tr>
</tbody></table>
<br>
<table width="100%" bgcolor="#a0a0a0" cellpadding="2" cellspacing="0">
<tbody><tr><td><span style="color: rgb(255, 255, 255); font-size: 12px;"><?php echo $Transaction['Transaction']['payment_methods'];?></span></td></tr>
</tbody></table>
<table width="100%" cellpadding="0" cellspacing="0">
<tbody><tr>
<td valign="bottom">
<table cellpadding="2" cellspacing="0">
<tbody><tr><td valign="top" width="130"><span style="font-size: 12px;">Date/Time:</span></td><td valign="top"><span style="font-size: 12px;"><?php echo $Transaction['Transaction']['transaction_date'];?></span></td></tr>
<tr><td valign="top" width="130"><span style="font-size: 12px;">Transaction&nbsp;ID:</span></td><td valign="top"><span style="font-size: 12px;"><?php echo $Transaction['Transaction']['transaction_id'];?></span></td></tr>
</tbody></table>
</td>
<td valign="bottom" align="right">
<table>
</table>
</td>
</tr>
</tbody></table>
<br>
Thank you for your business!
</td>
</tr>
</tbody></table>