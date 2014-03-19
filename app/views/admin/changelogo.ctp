<?php $this->set('title_for_layout', 'Change Website Logo');?>
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
                	<h3>Change Website Logo</h3>
<form id="form" action="<?php echo $html->url('/admin/changelogo');?>" method="post" enctype="multipart/form-data">
<fieldset id="personal" >
<legend>Website Logo</legend>
<label  for="logo">Website Logo:</label>
<input type="file" name="data[logo]" accept="jpg|jpeg|gif|png"/>
<br />
<label  for="showlogo">Display Logo:</label>
<input name="data[showlogo]" type="checkbox" value="1"  <?php if($setting['Setting']['show_logo']=='1'){echo 'checked="checked"';}?> />
<label>
<?php if(file_exists(WWW_ROOT."/uploads/".$setting['Setting']['logo']) and $setting['Setting']['logo']!="") { echo '<img src="/uploads/'.$setting['Setting']['logo'].'">';} else {echo '<img src="/uploads/no_photo.gif">';}?>
</label>
</fieldset>
<div align="center">
<input id="button1" type="submit" value="Submit" class="button submit" /> 
<input id="button2" type="reset" />
</div>
</form>
</div>