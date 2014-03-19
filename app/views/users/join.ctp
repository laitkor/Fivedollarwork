<?php $this->set('title_for_layout', 'Join');?><h3 class="blog-title"><a href="#" title="Join">Join</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/gigs/invite" class="wpsc_checkout_forms" id="invite">
                        Fields marked with an asterisk must be filled in.
                        <hr class="break" />
                        <div class="form">
							<label >Your Name: *</label>
                             <div class="in">
                            <input type="text" name="data[name]"  class="text required"  value="" pattern="[a-zA-Z ]{5,}" maxlength="50" />
                            </div>
                            <div class="clear"></div><label>Your Email: *</label>
                            <div class="in">
                             <input name="data[email]" value="" class="text required email"  type="text" required="required" />
                             </div>
                             <div class="clear"></div><label>Friend's Email: *</label>
                            <div class="in">
                             <input name="data[friendemail1]" value="" class="text" title="Friend's Email" type="email"  required="required" />
                             </div>
                             <div class="clear"></div><label>Friend's Email: </label>
                            <div class="in">
                             <input name="data[friendemail2]" value="" class="text" title="Friend's Email" type="email"  />
                             </div>
                             <div class="clear"></div><label>Friend's Email: </label>
                            <div class="in">
                             <input name="data[friendemail3]" value="" class="text" title="Friend's Email" type="email"  />
                             </div>
                            <div class="clear"></div><label>Message: *</label>
                            <div class="in">
                             <textarea cols="17" rows="3" name="data[message]" maxlength="250"  class="text" title="Message" required="required" ></textarea>
                             </div>
                             </div>
                        <hr class="break" />
<input type="submit" class="broap" value="Send"/>
                    </form> 
<!--<script> 
$("#invite").validator();
</script>                    
--></div>
<script>
  jQuery(document).ready(function(){
			jQuery("#invite").validate();
  });
</script>
