<?php $this->set('title_for_layout', 'Change Password');?>
<script>
  jQuery(document).ready(function(){
    jQuery('#button1').click(function(){
			jQuery("#form").validate();
			jQuery("#form").submit();
			return false;
		});
		
  });
</script>
<div id="box">
                	<h3 id="adduser">Change Password</h3>
<form id="form" action="<?php echo $html->url('/admin/changepassword');?>" method="post">
<fieldset id="personal" >
<legend>Change Password</legend>
<label  for="passwrd">Password:</label>
<input type="password" name="data[password]"   maxlength="100"  minlength="6"   id="passwrd" class="required password" value="" />
<br/>
<label for="newpasswrd">New Password:</label>
<input type="password" name="data[newpassword]"  maxlength="100"  minlength="6"   id="newpasswrd" class="required password" value=""/>
<br/>
<label for="cpasswrd">Confirm Password:</label><input type="password" name="data[cpassword]"  maxlength="100"  minlength="6"  id="cpasswrd" class="required" equalTo="#newpasswrd"  value=""/><br/>
</fieldset>
<div align="center">
<input id="button1" type="submit" value="Submit" class="button submit" /> 
<input id="button2" type="reset" />
</div>
</form>
</div>