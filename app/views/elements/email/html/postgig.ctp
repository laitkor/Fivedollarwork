<?php 


$this->set('title_for_layout', 'Order Gig');?><h3 class="blog-title"><a href="#" title="Profile Settings">Order Gigs</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post">
				
                     <div class="form">
                    <table cellspacing="0" cellpadding="0"  class="payment" width="100%" >
                    <tr><td><font style="font-size:16px; color:#39C; font-weight:bold">
                    <?php echo $gigId['User']['username'];?> : I Will <?php echo $gigId['0']['Gig']['title'];?> for $<?php echo $gigId['Gig']['price'];?></font></td></tr>
                    <?php if($this->Session->read('User.id')==$gigId['Gig']['user_id'])
					{
					 ?>
                      <tr><td align="right"><input type="button" class="broap" value="Edit"/></td></tr><?php }
					  else 
					  { ?>
                     <tr><td align="right"><a href="/orders/index/<?php echo $gigId['Gig']['id'];?>"><input type="button" class="broap" value="Order"/></a></td></tr>
                    <tr><td align="right"><a href="/gigs/compose/<?php echo $user_id?>/<?php echo $gigId['Gig']['user_id'] ?>">Contact Seller</a></td></tr><?php } ?>
      	  <tr>
			  <td align="center"><img src="/uploads/gig_img/<?php if($gigId['Gig']['image']==''){?>noimage.jpg <?php } else { echo $gigId['Gig']['image']; } ?>" width="350px" height="200px" /></td>
			</tr>
            <tr><td><?php echo $gigId['Gig']['description'];?></td></tr>
            
           
                   </table>
                   
                   <table width="100%">
                   <tr><th>Other Gigs By  <?php echo $gigId['User']['username'] ?></th></tr>
                   <?php
				   foreach($usersgig as $ug)
				   {?>
				     
				   <tr><td><a href="<?php echo $ug['Gig']['id'] ?>"><img src="/uploads/gig_img/<?php if($ug['Gig']['image']==''){?>noimage.jpg <?php } else { echo $ug['Gig']['image']; } ?>" width="50px" height="50px" /><br/><?php echo $ug['Gig']['title']; ?></a></td></tr>
				   <?php }
				    ?>
                   </table>
                    </div></form>
</div>
