<?php $this->set('title_for_layout', 'Change Website Title');?>
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
                	<h3>Change Website Title</h3>
<form id="form" action="<?php echo $html->url('/admin/changetitle');?>" method="post">
<fieldset id="personal" >
<legend>Website Title</legend>
<label  for="title">Website Title:</label>
<input type="text" name="data[title]" maxlength="200"  minlength="6"   class="required" value="<?php echo $setting['Setting']['title'];?>"/>
</fieldset>
<div align="center">
<input id="button1" type="submit" value="Submit" class="button submit" /> 
<input id="button2" type="reset" />
</div>
</form>
</div>