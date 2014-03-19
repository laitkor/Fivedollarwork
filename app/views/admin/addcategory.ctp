<?php $this->set('title_for_layout', 'Add Category');?>
<div id="box">
                	<h3 id="adduser">Add Category</h3>
<form id="form" action="addcategory" method="post">
<fieldset id="personal" >
<legend>Category Information</legend>
<label  for="passwrd">Category Name:</label>
<input name="data[name]"   maxlength="100"  minlength="2"   id="catname" class="required password" value="" />
<br/>
<label for="newpasswrd">Category Description:</label>
<textarea name="data[description]"  maxlength="100"  minlength="6"   id="description" class="required password" ></textarea>
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