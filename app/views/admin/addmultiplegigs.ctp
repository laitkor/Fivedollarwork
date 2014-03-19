<?php $this->set('title_for_layout', 'Add Multiple Gigs Price');?>
<div id="box">
                	<h3 id="adduser">Add Multiple Gigs Price</h3>
<form id="form" action="addmultiplegigs" method="post">
<fieldset id="personal" >
<legend>Add Multiple Gigs Price</legend>
<label  for="passwrd">Multiple Gigs Price:</label>
<input name="data[price]"   maxlength="4"    id="gigprice" class="required password" value="" />
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