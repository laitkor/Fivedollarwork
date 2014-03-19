<?php $this->set('title_for_layout', 'Manage Orders Review');?><h3 class="blog-title"><a href="#" title="Profile Settings">Manage Orders Review</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
				<form class="wpsc_checkout_forms" method="post" name='Ordergig' id="Ordergig" >
			
            	 <table cellspacing="0" cellpadding="0"  class="payment" width="100%">
                        <tbody>
                        <tr><td><a href="allstatus">All Status</a></td><td><a href="pending">Pending</a></td><td><a href="completed">Completed</a></td><td><a href="cancelOrders">Cancelled</a></td><td><a href="orderreview" style="background-color:#09C; color:#FFF">Review</a></td></tr>
        	<?php if(!empty($orders)) { ?>				
                            <tr>
		
                            <th>SL No.</th>
							<th >Shop Order Item</th>
							<th>Review To</th>
                            
                            <th colspan="2">Review</th>
							 </tr>
                    <?php foreach($orders as $order)
					{ ?>
					<tr><td><?php echo $order['reviews']['id']?></td><td><?php echo $order['gigs']['title']?></td><td><?php echo $order['users']['username']?></td><td colspan="2"><?php echo $order['reviews']['message']?></td></tr>
					
					
					<?php }?>
                    <tr><td colspan="5"><?php //echo $this->element('admin/pagination'); //call pagination from element ?></td></tr>					
        <?php } ?>
                        </tbody>
                    </table>
					
                             </form>
</div>

<script language="javascript" type="text/javascript">


function order(id)
{
	
	if(document.getElementById(id).value=='Order')
	{
		
		document.Ordergig.action='/gigs/ordergig/'+id; 
		 document.Ordergig.submit();
	}
}
function getPrice(price)
	{
		document.Ordergig.action='/gigs/getprice/'+price; 
		 document.Ordergig.submit();
	}


</script>