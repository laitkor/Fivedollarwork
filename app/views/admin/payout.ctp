<?php $this->set('title_for_layout', 'Pay Withdraw Request Amount');?>
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
                	<h3 id="adduser">Pay Withdraw Request Amount</h3>
<form id="form" action="<?php echo $html->url('/admin/payout/'.$withdraw['Withdraw']['id']);?>" method="post">
<fieldset id="personal" >
<legend>Payment</legend>
<label  for="Username">Username:</label>
<?php echo $withdraw['User']['username']; ?>
<br/>
<label  for="Amount">Amount:</label>
<?php echo $withdraw['Withdraw']['amount']; ?>
<br/>
<label  for="commission">Commission:</label>
<input type="text" name="data[commission]" class="required number" value="0.00" />
<br/>
<label for="payment_methods">Payment Methods:</label>
<input type="text" name="data[payment_methods]" class="required" value=""/>
<br/>
</fieldset>
<div align="center">
<input id="button1" type="submit" value="Submit" class="button submit" /> 
<input id="button2" type="reset" />
</div>
</form>
</div>