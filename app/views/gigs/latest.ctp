<?php /* $this->set('title_for_layout', '');*/?><!--<h3 class="blog-title"><a href="#" title="Profile Settings">Gigs</a></h3>
                    <div class="blog-meta"></div>-->
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post" name='Ordergig' id="Ordergig" >
				 <table cellspacing="0" cellpadding="0"  class="payment" width="100%">
                        <tbody>
                            <tr>
							<th style="width:12%">Filter By</th>
                            <td class="row"   >&nbsp;<a href="/gigs/index" style="color:#FFF" >Auto</a></td>
							<td class="row" >
                            <a href="/gigs/mostpopular" style="color:#FFF" >Most Popular</a></td>
							<td class="row" ><a href="/gigs/bestrating" style="color:#FFF">Best Ratings</a></td>
                            <td class="row" style="background-color: #A6BA76;  color: #000; "><a href="/gigs/latest"><b>Latest</b></a></td>
                            <td class="row" style="width:23%"  align="right">Job Price:<select name="data[price]" onchange="getPrice(this.value)">
                	<option selected="selected" value="">Price</option>
                    <?php if(isset($gigsprice)){foreach($gigsprice as $price){ ?>
                    <option value="<?php echo $price['Gigsprice']['price']; ?>">$<?php echo $price['Gigsprice']['price']; ?></option>
                    <?php }} ?>
                </select>
</td>
							
 </tr>
                        </tbody>
                    </table>
					
                    <hr class="break" />
                    <div class="form">
                    <table cellspacing="0" cellpadding="0"  class="payment" width="100%" >
      <?php 
	if(count($allgigs)>0)
		{ //echo "<pre>";print_r($allUser);
			foreach($allgigs as $gigs) 
			{ 
			?>
			  <tr  class="rowgrid">
			  <td class="frame"><a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>"><img src="/uploads/gig_img/<?php if($gigs['Gig']['image']==''){?>noimage.jpg <?php } else { echo $gigs['Gig']['image']; } ?>" title="Gigs" width="120px"  height="80px"/></a>
               <?php if($gigs['Gig']['featured']=='Y'){ ?>   <a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>"><span class="featured-label">featured</span></a> <?php } ?>
              </td>
			<td>
            <table width="100%">
            <tr><td colspan="4"><h4 class="blog-title">
            <a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>">I Will <?php echo $gigs['Gig']['title'];?> for $<?php echo $gigs['Gig']['price'];?></a></h4></td></tr>
            <tr><td colspan="4"><?php echo substr($gigs['Gig']['description'],0,50);?>....... <br />(by <?php  if(is_numeric($gigs['User']['username'])) {echo $gigs['User']['name']; }else {echo $gigs['User']['username']; } ?>)</td></tr>
            <tr><td id="post"><a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>">Read More</a>
            &nbsp;<?php
if($this->Session->check('User'))
    {
		if(isset($gigs['Gig']['like_user']) && $gigs['Gig']['like_user'] !='')
		  {			
			echo $html->link($html->image('/images/like.png'), array('action' => 'unlike', 
			$gigs['Gig']['id'] ),array( 'update' => 'post','escape'=>false,'title'=>'Like')); 
		  }
		else
    	  { 
			echo $html->link($html->image('/images/unlike.png'),array('action' => 'like',
			 $gigs['Gig']['id']),array( 'update' => 'post','escape'=>false,'title'=>'Unlike')); 
     	  }

	}		  
			  ?><td><a href="#">Share</a></td><td>            			  <a href="http://www.facebook.com/share.php?u=<?php echo SITE_URL; ?>/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>" onclick="return fbs_click()" target="_blank"><img src="/images/icon-facebook.png" alt="Share on Facebook" /></a>
              &nbsp; <a href="" title="Click to share this post on Twitter"     onclick="window.open('http://twitter.com/home?status=<?php echo SITE_URL; ?>/gigs/ordergig/<?php echo $gigs['Gig']['id']; ?>','sharer','toolbar=0,status=0,width=626,height=436′')"><img src="/images/icon-twitter.png" alt="Share on Twitter"></a>&nbsp;  <a href="/gigs/sendEmail/<?php echo $gigs['Gig']['id']; ?>"><img src="/images/btn-email.png" title="post on your email" /></a>
</td><td align="right"><input type="button"  value="Order" class="broap" id="<?php echo $gigs['Gig']['id']; ?>" onclick="return order(this.id);"  /></tr>
           </table>&nbsp;</td>
			
			
		</tr></tr><tr><td colspan="2"><hr  class="break"  /></td></tr>

		 <?php } 
		}
?>
		<tr><td colspan="2">
<?php /*echo $paginator->first('<< '.__('First', true));?>
<?php echo $paginator->prev('<< '.__('Previous', true), array(), null, array('class'=>'disabled'));?>
|     <?php echo $paginator->numbers();?>
<?php echo $paginator->next(__('Next', true).' >>', array(), null, array('class'=>'disabled'));?>
<?php echo $paginator->last(__('Last', true).' >>');*/?>
<?php echo $this->element('pagination'); //call pagination from element ?>


        </td></tr>          			
                    
                   </table>
                    </div></form>
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