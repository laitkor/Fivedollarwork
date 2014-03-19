<?php $this->set('title_for_layout', 'Edit Manage Work');?><h3 class="blog-title"><a href="#" title="Change Password">Edit Manage Work</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/editmanagework/<?php echo $order[0]['Order']['id'];?>/<?php echo $wstatus ?>" class="wpsc_checkout_forms">                         <hr class="break" />
                        <div class="form">
                         <label>Shop Order Item</label>
                            <div class="in">
                             <?php echo  $order[0]['Gig']['title'];   ?>                             </div>
                            
                             <div class="clear"></div><label>Status </label>
                             
                            <div class="in">
                             <select name="data[status]" class="text" >
                             <?php if($wstatus=='Pending') { ?>
                             <option value="Active">Active</option>
                             <option value="Cancelled">Cancelled</option>
                            <?php }
							else if($wstatus=='Active') { ?>
                             <option value="Delivered">Delivered</option>
							 <?php } ?>
                             </select>
                             </div>
                         
                         </div>   
                        <hr class="break" />
<input type="submit" class="broap" value="Update" />
                    </form> 
</div>

<script> 
$("#profile").validator();
</script>
