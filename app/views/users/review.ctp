<?php $this->set('title_for_layout', 'Add Review');?><h3 class="blog-title"><a href="#" title="Profile Settings">Add Review</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/review/<?php echo  $order[0]['Order']['id'];  ?>" class="wpsc_checkout_forms" id="profile" enctype="multipart/form-data">

                        <hr class="break" />
                        <div class="form">
                         <label>Shop Order Item</label>
                            <div class="in">
                             <?php echo  $order[0]['Gig']['title'];  ?>                             </div>
                             <div class="clear"></div><label>Review Message</label>
                            <div class="in">
                             <textarea cols="17" rows="3" name="data[message]" 	class="text required"  ></textarea>
                             </div>
                             <div class="clear"></div><label>Rating </label>
                            <div class="in">
                             <select name="data[rating]" class="text" >
                             <?php for($i=1;$i<=10;$i++) { ?>
                             <option value="<?php echo $i; ?>">
                             <?php echo $i; ?>
                             </option>
                             <?php } ?>
                             </select>
                             </div>
                         
                         </div>   
                        <hr class="pagination-break" />
<input type="submit" class="broap" value="Submit" id="submit"/>
                    </form> 
</div>

<script> 
//$("#profile").validator();
 jQuery(document).ready(function(){
			jQuery("#profile").validate();
  });
</script>
