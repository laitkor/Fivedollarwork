<?php $this->set('title_for_layout', 'Manage Orders');?><h3 class="blog-title"><a href="#" title="Profile Settings">Manage Orders</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
				<form class="wpsc_checkout_forms" method="post" name='Ordergig' id="Ordergig" >
				
                <div class="metadata">
		<ul class="filters" >
			<li style="margin:0px; padding: 0px;">
				<?php 
				
				if($status!='Pending') {?><a href="/users/orders/Pending"><?php }?><span>Pending <u><?php echo $Order_status['Pending'];?></u></span><?php if($status!='Pending') {?></a><?php }?>
			</li>
			<li style="margin:0px; padding: 0px;">
				<?php if($status!='Active') {?><a href="/users/orders/Active"><?php }?><span>Active Orders <u><?php echo $Order_status['Active'];?></u></span><?php if($status!='Active') {?></a><?php }?>
			</li>
			<li style="margin:0px; padding: 0px;">
				<?php if($status!='Delivered') {?><a href="/users/orders/Delivered"><?php }?><span>Delivered <u><?php echo $Order_status['Delivered'];?></u></span><?php if($status!='Delivered') {?></a><?php }?>
			</li>
			<li style="margin:0px; padding: 0px;">
				<?php if($status!='Completed') {?><a href="/users/orders/Completed"><?php }?><span>Completed <u><?php echo $Order_status['Completed'];?></u></span><?php if($status!='Completed') {?></a><?php }?>
			</li>
			<li style="margin:0px; padding: 0px;">
				<?php if($status!='Cancelled') {?><a href="/users/orders/Cancelled"><?php }?><span>Cancelled <u><?php echo $Order_status['Cancelled'];?></u></span><?php if($status!='Cancelled') {?></a><?php }?>
			</li>
            <?php if($status!='Review') {?><li style="margin:0px; padding: 0px;"><a href="/users/orders/Review"><?php }?><span>Review<u>&nbsp;</u></span><?php if($status!='Review') {?></a><?php }?>
</li>
		</ul>
	</div>
         
                <?php if(!empty($orders)) { 
				
				
				?>
                 <table border="1" class="payment" width="100%">
                        <tbody>
                            <tr>
							
                            <th>Date</th>
							<th >Order Item</th>
                            <th >Owner Name</th>
							<th>Status</th>
                             <?php if($orders[0]['Order']['status']=="Pending" || $orders[0]['Order']['status']=="Delivered" || $orders[0]['Order']['status']=='Active'){ ?> <th>Action</th>
                           <?php } ?>
                            <th>Review</th><th>&nbsp;</th>
							 </tr>
                    <?php foreach($orders as $order)
					{
					$diff=strtotime(date('Y-m-d'))-strtotime($order['Gig']['date'])+1;
				$days=ceil($diff / (60*60*24)) ;
		
						 ?>
					<tr><td width="15%"><?php $date =$order['Order']['datetime'];
					$old_date = date($date);
echo $new_date = date('m-d-Y', strtotime($old_date));
					?></td>
                    <td width="50%" align="justify"><?php echo $order['Gig']['title']?></td>
                    <td><?php 
					if(is_numeric($order['Seller']['username'])) {echo $order['Seller']['name']; }else {echo $order['Seller']['username'];}
					?></td>
                    <td><?php echo $order['Order']['status']?></td>
 <?php if($order['Order']['status']=="Pending" || $order['Order']['status']=="Delivered" || $order['Order']['status']=='Active' && $order['Gig']['max_days'] > $days) {?>
<td> <a href="/users/editmanageorder/<?php echo $order['Order']['id']?>/<?php echo $order['Order']['status'];  ?>">
                    Edit</a></td>
<?php }else {?><td>None</td> <?php } ?>
                    <td><a href="/users/review/<?php echo $order['Order']['id']?>">Give Review to Seller</a></td></tr>
					
					
					<?php }?>
                    <tr><td colspan="6"><?php echo $this->element('pagination'); //call pagination from element ?></td></tr>					
        
                        </tbody>
                    </table><?php } ?>
                    
                    
                    
                     <table border="1"  class="payment" width="100%">
                        <tbody>
                        
        	<?php if(!empty($review)) { ?>				
                            <tr>
		
                            <th>SL No.</th>
							<th >Shop Order Item</th>
							<th>Review To</th>
                            
                            <th colspan="2">Review</th>
							 </tr>
                    <?php foreach($review as $order)
					{ ?>
					<tr><td><?php echo $order['Review']['id']?></td><td><?php echo $order['Gig']['title']?></td><td><?php
					if(is_numeric($order['User']['username'])) {echo $order['User']['name']; }else {echo $order['User']['username']; }
					?></td><td colspan="2"><?php echo $order['Review']['message']?></td></tr>
					
					
					<?php }?>
                    <tr><td colspan="5"><?php echo $this->element('pagination'); //call pagination from element ?></td></tr>					
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