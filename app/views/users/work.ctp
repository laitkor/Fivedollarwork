<?php $this->set('title_for_layout', 'Manage Works');?><h3 class="blog-title"><a href="#" title="Manage Works">Manage Works</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
<div class="metadata">
		<ul class="filters">
			<li>
				<?php if($workstatus!='Pending') {?><a href="/users/work/Pending"><?php }?><span>Pending <u><?php echo $Order_status['Pending'];?></u></span><?php if($workstatus!='Pending') {?></a><?php }?>
			</li>
			<li>
				<?php if($workstatus!='Active') {?><a href="/users/work/Active"><?php }?><span>Active Orders <u><?php echo $Order_status['Active'];?></u></span><?php if($workstatus!='Active') {?></a><?php }?>
			</li>
			<li>
				<?php if($workstatus!='Delivered') {?><a href="/users/work/Delivered"><?php }?><span>Delivered <u><?php echo $Order_status['Delivered'];?></u></span><?php if($workstatus!='Delivered') {?></a><?php }?>
			</li>
			<li>
				<?php if($workstatus!='Completed') {?><a href="/users/work/Completed"><?php }?><span>Completed <u><?php echo $Order_status['Completed'];?></u></span><?php if($workstatus!='Completed') {?></a><?php }?>
			</li>
			<li>
				<?php if($workstatus!='Cancelled') {?><a href="/users/work/Cancelled"><?php }?><span>Cancelled <u><?php echo $Order_status['Cancelled'];?></u></span><?php if($workstatus!='Cancelled') {?></a><?php }?>
			</li>
		</ul>
	</div>



			<?php if(isset($orders) && $orders > 0) {?>
            	<form class="wpsc_checkout_forms" method="post" name='Ordergig' id="Ordergig" >
				 <table class="payment" width="100%" border="1">
                        <tbody>
							
                            <th width="15%">Date</th>
							<th >Order Item</th>
							<th >User Name</th>
                            <th>Status</th>
                           <?php if($workstatus != 'Delivered' && $workstatus != 'Completed' && $workstatus != 'Cancelled'){ ?> <th>Action</th>
                           <?php } ?>
                           
							 </tr>
                    <?php
					
					 foreach($orders as $order)
					{ ?>
					<tr><td>
					<?php $date= $order['Order']['datetime'];
					      $old_date = date($date);
                         echo $new_date = date('m-d-Y', strtotime($old_date));
					?>
                    </td>
                    <td><?php echo $order['Gig']['title']?></td>
                    <td><?php
					if(is_numeric($order['User']['username'])) {echo $order['User']['name']; }else {echo $order['User']['username']; }
					?></td>
                    <td><?php echo $order['Order']['status']?></td>
<?php if($order['Order']['status'] != 'Delivered' && $order['Order']['status'] != 'Completed' && $order['Order']['status'] != 'Cancelled'){ ?>
                    <td><a href="/users/editmanagework/<?php echo $order['Order']['id']?>/<?php echo $order['Order']['status']?>">Update Status</a></td></tr>
					
					
					<?php } }?>
                    <tr> <td colspan="6"><?php echo $this->element('pagination'); //call pagination from element ?></td></tr>					
        
                        </tbody>
                    </table>
					
                             </form>
                             <?php } ?>
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