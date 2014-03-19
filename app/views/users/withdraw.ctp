<?php $this->set('title_for_layout', 'Withdraw Earnings');?><h3 class="blog-title"><a href="#" title="Withdraw Earnings">Withdraw Earnings</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
<?php if($Account['Account']['available_funds']>0) {?><form method="post" action="/users/withdraw" class="wpsc_checkout_forms" id="withdraw">                         <hr class="break" />
                        <div class="form">
                         <label>Withdraw Amount</label>
                            <div class="in">
                            <input name="data[amount]" value="<?php echo $Account['Account']['available_funds'];?>" class="text" type="text"  required="required"   />
                             </div>
                         
                         </div>   
                        <hr class="break" />
<input type="submit" class="broap" value="Submit" />
                    </form><br/><br/> <?php }?>

			<?php if(!empty($Withdraw)) {?>
				 <table class="payment" width="100%" border="1">
                        <tbody>
                            <tr>
							<th align="center">Amount</th>
							<th align="center">Commission</th>
							<th align="center">Payble Amount</th>
							<th align="center">Payment Methods</th>
                            <th align="center">Request Datetime</th>
                            <th align="center">Status</th>
							 </tr>
                    <?php foreach($Withdraw as $key=>$withdraw)	{ ?>
					<tr><td>$<?php echo $withdraw['Withdraw']['amount'];?></td>
                    <td>$<?php echo $withdraw['Withdraw']['commission'];?></td>
                    <td>$<?php echo $withdraw['Withdraw']['payble_amount'];?></td>
                    <td><?php echo $withdraw['Withdraw']['payment_methods'];?></td>
                    <td><?php echo $withdraw['Withdraw']['request_datetime'];?></td>
                    <td><?php echo $withdraw['Withdraw']['status'];?></td></tr><?php }?>
                    <tr><td colspan="7"><?php echo $this->element('pagination'); ?></td></tr>			          </tbody>
                    </table><?php } else {echo 'No transactions to display';}?>

</div>
<script> 
$("#withdraw").validator();
</script>
