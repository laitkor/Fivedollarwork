<?php $this->set('title_for_layout', 'Join');?><br/><span style="font-family:'Arial'; color:#0099CC; font-size:19px;"><b>Join</b></span>
<br/><br/>
<?php
echo $form->create('User', array('action' => 'signup','onsubmit'=>'return signup_validate()')); ?>
<table width="50%"  cellspacing="5" cellpadding="5" align="center">
  <tr>
    
    <td >Email ID</td>
    <td ><?php echo $form->input('email',array('label'=>false,'id'=>'email'));?></td>
  </tr>
  <tr>
  
    <td>Username</td>
    <td><?php echo $form->input('username',array('label'=>false,'id'=>'username'));?></td>
  </tr>
  <tr>
   
    <td>Password</td>
    <td><?php echo $form->input('password',array('label'=>false,'id'=>'password'));?></td>
  </tr>
  <tr>
  
    <td>Are you Human?</td>
    <td><?php echo $form->input('capture',array('label'=>false,'id'=>'capture'));?></td>
  </tr>
  <tr>
  
    <td>&nbsp;<?php // pr($this->Session->read());?></td>
    <td colspan="2" align="center"><?php echo $this->Html->image('img.php', array('alt' => 'Are you Human?'))?></td>
  </tr>
  <tr><td colspan="2" align="center"><?php echo $this->Form->end('/img/login.png');?></td></tr>
    </table>

