<?php $this->set('title_for_layout', 'Order Gig');?><h3 class="blog-title"><a href="#" title="Profile Settings">Order Gig</a></h3>
<?php if(!empty($gigId))
{ ?>
<div class="blog-meta"></div>
  <div class="blog-content">
  
		<form class="wpsc_checkout_forms" method="post" class="payment" name="Order" id="Order">
                    
                    
                    
         <div style="float:left; display:inline;">
             <b>Posted On </b>:<?php  $date= $gigId['Gig']['date'];
				$old_date = date($date);
				$time=strtotime($old_date);
				$new_date = date('d-M-Y', $time);
				echo $new_date; ?>
    </div>
          <div style=" float:right">
               <b >Age of Gig : </b><?php echo $ago; ?>
          </div>
           <hr class="break" />        
           <div class="single-image-box" style="margin-top:0px; margin-left:0px; float:left"> 
            
           <table class="single-write" style="width:570px;">
            <tr><td class="frame"><img src="/uploads/profile_img/<?php if($gigId['User']['image']            ==''){?>no_img.jpg <?php } else {  echo $gigId['User']['image']; } ?>" width="50px"             height="50px" /></td>
            <td style="width:67%">
            <h3 class="blog-title"><font color="#0099CC"><?php 
			if(is_numeric($gigId['User']['username'])) {echo $gigId['User']['name']; }else {echo $gigId['User']['username']; }
			?>            </font> : I Will <?php echo $gigId['Gig']['title'];?> for $<?php echo $gigId['Gig'][              'price'];?></h3></td><td>&nbsp;&nbsp;&nbsp;
            <?php if($this->Session->read('User.id')==$gigId['Gig']['user_id'])
                                {
                                 ?>
              
                                  <a href="/users/editgig/<?php echo $gigId['Gig']['id'];?>">																						                      <input type="button" class="broap" value="Edit"/></a><?php }
                                  else { ?>
                   <a href="#"><input type="button" class="broap" value="Order Now" onclick="order(<?php echo $gigId['Gig']['id'];?>);"/></a><br/><br />
                            <a href="/gigs/compose/<?php echo $user_id?>/<?php echo $gigId['Gig']['id'] ?>" style="text-decoration:none;"><strong>&nbsp;&nbsp;&nbsp;Contact Seller </strong></a><?php } ?>
            </td>
       </tr></table>
              
                
                	
                
                
                <div class="single-image-left">
                
                </div>
                
                <div class="single-image" style="position:relative;">
                 
<img src="/uploads/gig_img/<?php if($gigId['Gig']['image']==''){?>noimage.jpg <?php } else { echo $gigId['Gig']['image']; } ?>" width="345px" height="160px" /><?php if($gigId['Gig']['featured']=='Y'){ ?>   <span class="big-featured-label">featured</span><?php } ?>
<ul class="tags"><?php foreach($key as $tag) { ?><li><span><a href="/gigs/tags/<?php echo $tag; ?>"><?php echo $tag; ?></a></span></li><?php } ?></ul>
             
                </div>
                <div class="single-image-right"></div>
                
    </div>
    
              
              <div class="single-write">
              
                <p align="justify"><?php echo $gigId['Gig']['description'];?>.</p>
                <p><strong>Available in : </strong></p>
                <ul>
                    <li>Job Price $<?php echo $gigId['Gig']['price'];?></li>
                    
                </ul>
              </div>
              </form>
</div>
           
            <div class="clear"></div>
            
             <hr class="pagination-break" />       
                  
                   <div style="float:left; display:inline; width:48%">
                 <div><h4 class="blog-title"> Other Gigs By  <?php 
				 if(is_numeric($gigId['User']['username'])) {echo $gigId['User']['name']; }else {echo $gigId['User']['username'];}
				  ?></h4></div>
                   <?php
				    
			if(!empty($usersgig))
			  {
				   foreach($usersgig as $ug)
				   {?>
				     
		<table class="comment-right rowgrid" style="margin-left:0px; width:100%"><tr><td class="frame"><a href="<?php echo $ug['Gig']['id'] ?>"><img src="/uploads/gig_img/<?php if($ug['Gig']['image']==''){?>noimage.jpg <?php } else { echo $ug['Gig']['image']; } ?>" width="50px" height="50px" /></a></td><td><table ><tr><td><a href="<?php echo $ug['Gig']['id'] ?>"  class="rowgrid">I will <?php 
		echo substr($ug['Gig']['title'],0,14); ?> &nbsp;...<br /> for $<?php echo $ug['Gig']['price']; ?></a></td></tr></table></td></tr></table><br />
				   <?php }
			  }
			  else
			  { ?>
              <table class="comment-right" style="margin-left:0px; width:100%">
              <tr><td><h2><font color="#999999">No Gig Found</font></h2></td></tr></table>
			<?php }	    ?>
         
                   </div>
                   <div style="float:right; display:inline; width:50%">
                 <div><h4 class="blog-title"> Related Gigs </h4></div>
                   <?php
			if(!empty($relgig))
			  {
				   foreach($relgig as $rg)
				   {?>
				     
		<table class="comment-right rowgrid" style="margin-left:0px; width:100%"><tr><td class="frame"><a href="<?php echo $rg['Gig']['id'] ?>"><img src="/uploads/gig_img/<?php if($rg['Gig']['image']==''){?>noimage.jpg <?php } else { echo $rg['Gig']['image']; } ?>" width="50px" height="50px" /></a></td><td><table ><tr><td><a href="<?php echo $rg['Gig']['id'] ?>"  class="rowgrid">I will <?php echo substr($rg['Gig']['title'],0,14); ?> &nbsp;...<br /> for $<?php echo $rg['Gig']['price']; ?></a></td></tr></table></td></tr></table><br />
				   <?php }
			  }
			else 
			  { ?>
              <table class="comment-right" style="margin-left:0px; width:100%">
              <tr><td><h2><font color="#999999">No Gig Found</font></h2></td></tr></table>
		<?php }  ?>
         
                   </div>
                   <div style="clear:both"></div>
                   
<?php } else
{  ?><img src="/images/PageNotFound.jpg" /><?php } ?>
<script type="text/javascript">
function order(id)
{
	document.Order.action='/orders/index/'+id; 
		 document.Order.submit();

}
</script>