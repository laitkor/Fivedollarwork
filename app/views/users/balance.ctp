<?php $this->set('title_for_layout', 'My Balance');?><h3 class="blog-title"><a href="#" title="My Balance">My Balance</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                   <h3>You have $<?php
				   
				    echo $Account['Account']['available_funds'];?>&nbsp; available</h3><div class="withdraw-earn"><a href="/users/withdraw" title="Withdraw your earnings">Withdraw your earnings</a></div>
			<?php if(!empty($Order)) {?>
				 <table class="payment" width="100%" border="1">
                        <tbody>
                            <tr>
							<th align="center">Date</th>
							<th align="center">Gig</th>
							<th align="center">Transactions Mode</th>
							<th align="center">Orders Status</th>
                            <th align="center">Payment Methods</th>
                            <th align="center">Gross</th>
							 </tr>
                    <?php foreach($Order as $key=>$order)	{ ?>
					<tr><td><?php echo $date= date('m-d-Y',strtotime($order['Transaction']['transaction_date']));?>
                    </td>
                    <td><?php echo $order['Gig']['title'];?></td>
                    <td><?php if($order['Transaction']['user_id']==$this->Session->read('User.id')){echo "Buy";} if($order['Transaction']['receiver_id']==$this->Session->read('User.id')){echo "Sell";}?></td>
                    <td><?php echo $order['Order']['status'];?></td>
                    <td><?php echo $order['Transaction']['payment_methods'];?></td>
                    <td>$<?php echo $order['Transaction']['amount'];?></td></tr><?php }?>
                    <tr><td colspan="7"><?php echo $this->element('pagination'); ?></td></tr>			          </tbody>
                    </table><?php } else {echo 'No transactions to display';}?>
</div>
<div class="blog-meta"></div>
<div class="comment-bal">
<cite>
<a title="$<?php echo $Account['Account']['available_funds'];?> Available">$<?php echo $Account['Account']['available_funds'];?> Available</a>
<small><a>Cleared funds available for Withdrawal or Purchasing.</a></small>
</cite>
<cite>
<a title="$<?php echo $Account['Account']['awaiting_funds'];?> Awaiting Clearance">$<?php echo $Account['Account']['awaiting_funds'];?> Awaiting Clearance</a>
<small><a>Incoming payments that are not yet available for withdrawal.</a></small>
</cite>
<cite>
<a title="$<?php echo $Account['Account']['upcoming_funds'];?> Upcoming Payments">$<?php echo $Account['Account']['upcoming_funds'];?> Upcoming Payments</a>
<small><a>Expected revenues from active orders.</a></small>
</cite>
<cite>
<a title="$<?php echo $Account['Account']['withdrawn_funds'];?> Already Withdrawn">$<?php echo $Account['Account']['withdrawn_funds'];?> Already Withdrawn</a>
<small><a>Funds you transferred to you.</a></small>
</cite>
<cite>
<a title="$<?php echo $Account['Account']['purchases_funds'];?> Revenue Purchases">$<?php echo $Account['Account']['purchases_funds'];?> Revenue Purchases</a>
<small><a>You used $<?php echo $Account['Account']['purchases_funds'];?> of your revenues to pay for other gigs.</a></small>
</cite>
</div>
<div class="clear"></div>
