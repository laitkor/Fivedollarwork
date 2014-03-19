<?php $this->set('title_for_layout', 'Commission Percentage Setting');?>
<div id="box">
                	<h3 id="adduser">Commission Percentage Setting</h3>
<form id="form" action="commission" method="post">
<fieldset id="personal" >
<legend>Commission Percentage Setting</legend>
<label  for="passwrd">Commission Percentage:</label>
<input name="data[commission_percent]"   maxlength="4"    id="commission" class="required password" value="<?php echo $comm[0]['Setting']['commission_percent'] ?>" />%
<br/>
</fieldset>
<div align="center">
<input id="button1" type="submit" value="Submit" class="button submit" /> 
<input id="button2" type="reset" />
</div>
</form>
</div>
<script>
  jQuery(document).ready(function(){
    jQuery('#button1').click(function(){
			jQuery("#form").validate();
			jQuery("#form").submit();
			return false;
		});
		
  });
</script>