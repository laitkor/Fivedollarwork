<?php 		
switch($type){
			case '1':
			$pg="Username";
			break;
			case '2':
			$pg="Password";
			break;
		}
$title="Forgot Your ".$pg.'?';
$this->set('title_for_layout', $title);?><h3 class="blog-title"><a href="#" title="<?php echo $title;?>"><?php echo $title;?></a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/forgot/<?php echo $type;?>" class="wpsc_checkout_forms" id="forgot">
                        <strong>Fields marked with an asterisk must be filled in.</strong>
                        <hr class="pagination-break" />
                        <div class="form">
                         <label>Email: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[email]" value="" class="text required email"   />
                             </div>
                             </div>
                        <hr class="pagination-break" />
<input type="submit" class="broap" value="Submit"/>
                    </form>
<!--<script> 
$("#forgot").validator();
</script>  -->                  
</div>
<script>
  jQuery(document).ready(function(){
			jQuery("#forgot").validate();
  });
</script>