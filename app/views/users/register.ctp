<?php $this->set('title_for_layout', 'Join');?><h3 class="blog-title"><a href="#" title="Join">Join</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/register" class="wpsc_checkout_forms" id="join">
                        <strong>Fields marked with an asterisk must be filled in. </strong>
                    <hr class="pagination-break" />
                        <div class="form">
                         <label>Email: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[email]" value="<?php if(isset($data['email'])) {echo $data['email'];}?>" class="text required email"  type="text"  />
                             </div>
                             <div class="clear"></div><label>Username: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[username]" value="<?php if(isset($data['email'])) {echo $data['username'];}?>" class="text required"  type="text"   maxlength="50" pattern="[a-zA-Z]{3}[a-zA-Z0-9]{3,}" minlength="6" id="username"/>
                             </div>
                             <div class="clear"></div><label>Password: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[password]" type="password" minlength="6" value="" class="text required" maxlength="50" id="password"/>
                             </div>
                             <div class="clear"></div><label>Confirm Password: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input class="text required" type="password" equalTo="#password"  />
                             </div>
                            <div class="clear"></div><label>Are You Human?: <span style="color:#F00">*</span></label>
                            <div class="in">
							<input type="text" id="SignupCaptcha" value=""  class="text required"  autocomplete="off" name="data[captcha]" ></div>
                            <div class="clear"></div><label>&nbsp;</label>
                            <div class="in">
							<?php echo $html->image($html->url(array('controller'=>'users', 'action'=>'captcha'), true),array('style'=>'','vspace'=>2)); ?></div>

                             </div>
                        <hr class="pagination-break" />
<input type="submit" class="broap" value="Submit" id="joinsubmit"/>
                    </form> 
</div>
<!--<script> 
$("#join").validator();
</script>      
--><script>
  jQuery(document).ready(function(){
			jQuery("#join").validate();
  });
</script>
