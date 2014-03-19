<?php $this->set('title_for_layout', 'Payment API Details');?>
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
                	<h3 id="adduser">Payment API Details</h3>
<form id="form" action="<?php echo $html->url('/admin/paypalid');?>" method="post">
<fieldset id="personal" >
<legend>Authorize.net API</legend>
<label  for="authorizenet_login">API Login ID:</label>
<input type="text" name="data[authorizenet_login]"   maxlength="100"  id="authorizenet_login" class="required" value="<?php echo $setting['Setting']['authorizenet_login'];?>" />
<br/>
<label for="authorizenet_key">Transaction Key:</label>
<input type="text" name="data[authorizenet_key]"  maxlength="100" id="authorizenet_key" class="required" value="<?php echo $setting['Setting']['authorizenet_key'];?>"/>
<br/>
</fieldset>
<fieldset id="personal" >
<legend>Paypal API</legend>
<label  for="paypal_username">API Username:</label>
<input type="text" name="data[paypal_username]"  maxlength="100"  id="paypal_username" class="required" value="<?php echo $setting['Setting']['paypal_username'];?>" />
<br/>
<label for="paypal_password">API Password:</label>
<input type="text" name="data[paypal_password]"  maxlength="100" id="paypal_password" class="required" value="<?php echo $setting['Setting']['paypal_password'];?>"/>
<br/>
<label for="paypal_signature">API Signature:</label>
<input type="text" name="data[paypal_signature]"  maxlength="100" id="paypal_signature" class="required" value="<?php echo $setting['Setting']['paypal_signature'];?>"/>
<br/>
</fieldset>
<div align="center">
<input id="button1" type="submit" value="Submit" class="button submit" /> 
<input id="button2" type="reset" />
</div>
</form>
</div>