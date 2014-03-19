<?php $this->set('title_for_layout', 'Customer Service');?><h3 class="blog-title"><a href="#" title="Customer Service">Customer Service</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/gigs/customerservice" class="wpsc_checkout_forms" id="customerservice">
                        <b> Fields marked with an asterisk must be filled in.</b>
						 <hr class="pagination-break" />
                         <div class="form">
                        <label>Subject: <span style="color:#F00">*</span></label>
                         <div class="in">
                        <select  name="data[subject]" title="Subject"  class="required text" style="width:245px;">
<option  value="">Select...</option>
<option  value="Account problem / unblock">Account problem / unblock</option>
<option  value="Report misuse, spam or bad behavior">Report misuse, spam or bad behavior</option>
<option  value="Conflict with seller or buyer">Conflict with seller or buyer</option>
<option  value="Seller Not Responding">Seller Not Responding</option>

<option  value="Buyer Not Responding">Buyer Not Responding</option>
<option  value="Request new features">Request new features</option>
<option  value="Media and Press">Media and Press</option>
<option  value="Partners or Investors">Partners or Investors</option>
<option  value="Other...">Other...</option>
                          </select>
                          </div>
            
                            <div class="clear"></div><label >Order:<span>&nbsp;&nbsp;</span> </label>
                             <div class="in">
                             <input type="text" name="data[Order]" value="" class="text"  title="Order"/>
                              </div>

                            <div class="clear"></div><label >Name: <span style="color:#F00">*</span></label>
                             <div class="in">
                            <input type="text" name="data[name]"  class="required text"  value="" pattern="[a-zA-Z ]{5,}" maxlength="50" />
                            </div>
             
                            <div class="clear"></div><label>Email: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[email]" value="" class="required text"  />
                             </div>
            
                            <div class="clear"></div><label>Message: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <textarea cols="17" rows="3" name="data[message]" class="required text" style="resize:none;" ></textarea>
                             </div>
                             </div>
                        <hr class="pagination-break" />
<input type="submit" class="broap" value="Send"/>
                    </form> 
<script> 
 
jQuery(document).ready(function(){
			jQuery("#customerservice").validate();
  });
</script>                    
</div>