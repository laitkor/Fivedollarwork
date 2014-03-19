<?php $this->set('title_for_layout', 'Invite Friends');?><br/><span style="font-family:'Arial'; color:#0099CC; font-size:19px;"><b>Invite Friends</b></span>
<br/><br/>
<?php
echo $form->create('User', array('action' => 'invitefriend')); ?>
<table width="60%"  cellspacing="10" cellpadding="12" align="center" bgcolor="#CCFFFF">
  <tr><td><font color="#66CCFF" size="-1"><b>Tell A Friend</b></font></td><td>&nbsp;</td></tr>
  <tr>
    
    <td >Your Name: *<br /><?php echo $form->input('name',array('label'=>false,'id'=>'name','style'=>"position:absolute; width:180px; height:20px"));?></td>
    <td >Your Email: *<br /><?php echo $form->input('email',array('label'=>false,'id'=>'email','style'=>"position:absolute; width:180px; height:20px"));?></td>
  </tr>
  <tr><td colspan="2" align="right">(* required fields)</td></tr>
  <tr>
  
 <td >Friend's Email: *<br /><?php echo $form->input('friendemail1',array('label'=>false,'id'=>'friendemail1','style'=>"position:absolute; width:180px; height:20px"));?></td>
  </tr>
  <tr>
<td >Friend's Email: <br /><?php echo $form->input('friendemail2',array('label'=>false,'id'=>'friendemail2','style'=>"position:absolute; width:180px; height:20px"));?></td>
 </tr>
  <tr>
  
<td >Friend's Email:<br /><?php echo $form->input('friendemail3',array('label'=>false,'id'=>'friendemail3','style'=>"position:absolute; width:180px; height:20px"));?></td>  </tr>
  <tr>
<tr><td colspan="2">Message *(max 250 characters allowed)<br />
<?php echo $form->input('message',array('label'=>false,'id'=>'message','style'=>"position:absolute",'type'=>'textarea','rows'=>'5','cols'=>'50'));?>
</td>
</tr>  
  <tr><td colspan="2" align="right"><br /><br /><br /><?php echo $this->Form->end('/img/send.png');?></td></tr>
    </table>

