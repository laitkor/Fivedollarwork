<?php $this->set('title_for_layout', 'Reset Password');?><h3 class="blog-title"><a href="#" title="Reset Password">Reset Password</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/newpassword/<?php echo $actkey;?>" class="wpsc_checkout_forms" id="resetpassword">
                        Fields marked with an asterisk must be filled in.
                        <hr class="break" />
                        <div class="form">
                        <label>Password: *</label>
                            <div class="in">
                             <input name="data[password]" type="password" minlength="6"  value="" class="text" title="Password" maxlength="50"/>
                             </div>
                             <div class="clear"></div><label>Confirm Password: *</label>
                            <div class="in">
                             <input class="text" title="Confirm Password" type="password" name="check" data-equals="data[password]"  />
                             </div>
                             </div>
                        <hr class="break" />
<input type="submit" class="broap" value="Submit"/>
                    </form> 
</div>
<script> 
$("#resetpassword").validator();
</script>      
