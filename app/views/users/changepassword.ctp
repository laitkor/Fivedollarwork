<?php $this->set('title_for_layout', 'Change Password');?><h3 class="blog-title"><a href="#" title="Change Password">Change Password</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/changepassword" class="wpsc_checkout_forms" id="changepassword">Fields marked with an asterisk must be filled in.
                        <hr class="pagination-break" />
                        <div class="form">
                        <label>Old Password: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[oldpassword]" type="password" minlength="6"  value="" class="text required" maxlength="50"/>
                             </div>
                             <div class="clear"></div><label>New Password: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[password]" type="password" minlength="6"  value="" class="text required"  maxlength="50" id="newpassword"/>
                             </div>
                             <div class="clear"></div><label>Confirm Password: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input class="text required" type="password" name="check" equalTo="#newpassword"   />
                             </div>
                             </div>
                        <hr class="pagination-break" />
<input type="submit" class="broap" value="Submit"/>
                    </form> 
</div>
<script> 

jQuery(document).ready(function(){
			jQuery("#changepassword").validate();
  });
</script>      
