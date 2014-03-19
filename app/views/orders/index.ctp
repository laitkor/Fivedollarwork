<script>
  $(document).ready(function(){
    $('#paymentsubmit').click(function(){
		var method_opt = $("input[name='data[mode]']:checked", '#payment-form').val();	
		if(method_opt == 'P'){
			$('#payment-form2').submit();
		}else{		
		<!--$("#payment-form").validator().submit($('#payment-form'));-->
		jQuery(document).ready(function(){
			jQuery("#payment-form").validate().submit($('#payment-form'));
  });
				}
		return false;
	});	
$('#authorize_div').hide('slow');

  });
  
  function showHideForm(payment_opt){
		if(payment_opt == 'A'){
			$('#authorize_div').show('slow');			
		}else
			$('#authorize_div').hide('slow');
	}
		

</script>
<?php  $title="Order of ".$work['Gig']['title'];$this->set('title_for_layout', $title);?><h3 class="blog-title"><a href="#" title="<?php echo $title;?>"><?php echo $title;?></a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form action="/orders/paymentProcess/<?php echo $work['Gig']['id'];?>" method="post" id="payment-form2">
					<input type="hidden" name="data[mode]" value="P" />
					</form>
                   <form action="/orders/paymentProcess/<?php echo $work['Gig']['id'];?>" method="post" id="payment-form" class="wpsc_checkout_forms">
                    Fields marked with an asterisk must be filled in.
                        <hr class="pagination-break" />
                        <div class="form">
                         <label style="line-height:20px">Method:</label>
                            <div class="in"><!--
                         <input  type="radio" value="A" checked="checked" id="authorizeP" name="data[mode]" onclick="showHideForm('A')"/>&nbsp;Credit Card&nbsp;&nbsp; --><input type="radio" checked="checked"  name="data[mode]" onclick="showHideForm('P')" value="P" />&nbsp;Paypal<input type="hidden" name="data[amt]" value="<?php echo $work['Gig']['price'];?>" class="text" />
                             </div>
                             <div class="clear"></div><div id="authorize_div"><label>Credit Card Type: <span style="color:#F00">*</span></label>
                            <div class="in">
        <select name="data[c_type]"  class="text required">
        <option value="">Select Credit Card</option>
            <option value="visa">Visa</option>
            <option value="discover">Discover</option>
            <option value="amex">Amex</option>
            <option value="other">Other</option>
    </select>
                             </div>
                             <div class="clear"></div><label>CC Number: <span style="color:#F00">*</span></label>
                            <div class="in">
                           <input type="text" class="text required"  pattern="[0-9]{12,}" maxlength="16" name="data[c_n]" >

                             </div>
                              <div class="clear"></div><label>CVV2: <span style="color:#F00">*</span></label>
                            <div class="in">
                              <input type="text" class="text required" pattern="[0-9]{3,}" maxlength="3" name="data[c_cvv2]">
                             </div>
                            <div class="clear"></div><label>Expiration date:</label>
                            <div class="in"><select id="expire_month" name="data[c_expyear]" class="text">
		 <?php $curr_year = date("Y"); for($i=$curr_year;$i<($curr_year+10);$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
		}
			?></select>&nbsp;
		<br /><br /><select id="expire_month" name="data[c_expmonth]" class="text">
		<option value="01">Jan</option>
		<option value="02">Feb</option>
		<option value="03">Mar</option>
		<option value="04">Apr</option>
		<option value="05">May</option>
		<option value="06">Jun</option>
		<option value="07">Jul</option>
		<option value="08">Aug</option>
		<option value="09">Sep</option>
		<option value="10">Oct</option>
		<option value="11">Nov</option>
		<option value="12">Dec</option>
		</select>
                             </div></div>
                            <div class="clear"></div>
                             </div>
                        <hr class="pagination-break" />
<input type="submit" class="broap" value="Submit" id="paymentsubmit"/>&nbsp;&nbsp;<input type="button" value="Cancel" class="broap" onClick="javascript: history.go(-1)">
                    </form> 
</div>
<script> 

</script>
