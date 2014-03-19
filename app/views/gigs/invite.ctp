<?php $this->set('title_for_layout', 'Invite Friends');?><h3 class="blog-title"><a href="#" title="Invite Friends">Invite Friends</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/gigs/invite" class="wpsc_checkout_forms" id="join">
                       <b> Fields marked with an asterisk must be filled in.</b>
                        <hr class="pagination-break" />
                        <div class="form">
                           <label>Email: <span style="color:#F00">*</span></label>
                            <div class="in">
<input name="data[email]"  class="text required email"  />
                             </div>
                             
                             <div class="clear"></div><label>Friend's Email: <span style="color:#F00">*</span></label>
                            <div class="in">
<textarea name="data[friendemail]" class="text required" style="resize:none;" cols="25" rows="3"  ></textarea>
                             </div>
                            
                            <div class="clear"></div><label>Message: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <textarea cols="25" rows="3" name="data[message]"   class="text required" style="resize:none;" ></textarea>
                             </div>
                             </div>
                        <hr class="pagination-break" />
<input type="submit" class="broap" value="Send"/>
                    </form> 
<!--<script> 
$("#join").validator();
</script> -->                   
</div>
<script>
  jQuery(document).ready(function(){
			jQuery("#join").validate();
  });
</script>