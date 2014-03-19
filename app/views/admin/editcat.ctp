<?php $this->set('title_for_layout', 'Edit Category');?>
<div id="box">
                	<h3 id="adduser">Edit Category</h3>
                    
<form id="form" action="/admin/editcat/<?php echo $cat[0]['Category']['id'] ?>" method="post">
<fieldset id="personal" >
<legend>Category Information</legend>
<label  for="passwrd">Category Name:</label>
<input name="data[name]"   maxlength="100"  minlength="2"   id="catname" class="required password" value="<?php echo $cat[0]['Category']['name'] ?>" />
<br/>
<label for="description">Category Description:</label>
<textarea name="data[description]"  maxlength="100"  minlength="6"   id="description" class="required password" ><?php echo $cat[0]['Category']['description'] ?></textarea>
<br/>
<label  for="catstatus">Category Status:</label>
<select name="data[status]"  id="catstatus">
<?php if($cat[0]['Category']['status']=='Active') { ?>
<option value="Active">Active</option>
<option value="Inactive">Inactive</option>
<?php } ?>
<?php if($cat[0]['Category']['status']=='Inactive') { ?>
<option value="Inactive">Inactive</option>
<option value="Active">Active</option>
<?php } ?>

</select>

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