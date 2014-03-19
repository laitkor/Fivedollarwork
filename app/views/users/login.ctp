<?php $this->set('title_for_layout', 'Log in');?><br/><span style="font-family:'Arial'; color:#0099CC; font-size:19px;"><b>Log in</b></span>
<br/><br/>
<?php
$this->Session->flash('auth');
echo $form->create('User', array('action' => 'login','onsubmit'=>'return login_validate()' )); ?>
<table width="20%"  cellspacing="2" cellpadding="2" align="center">
  <tr>
    
    <td>Email ID</td>
    <td><?php echo $form->input('User.email',array('label'=>false,'id'=>'email','style'=>" background-color:#FFFFCC;"));?></td>
  </tr>
    <tr>
    
    <td>Password</td>
    <td><?php echo $form->input('User.password',array('label'=>false,'id'=>'password','type'=>'password'));?></td>
  </tr>
  <tr><td colspan="2" align="center"><?php echo $this->Form->end('/img/login.png');?></td></tr>
</table>