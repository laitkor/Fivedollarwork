<?php $this->set('title_for_layout', 'Stuff I Like');?><h3 class="blog-title"><a href="Stuff I Like" title="Profile Settings">Stuff I Like</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post" name='Ordergig' id="Ordergig" >
                    <div class="form">
                    <table cellspacing="0" cellpadding="0"  class="payment" width="100%" >
      <?php 
	if(!empty($like))
		{ //echo "<pre>";print_r($allUser);
		?>
		                            <tr>
							<td colspan="2" class="row"><b>You Have <?php echo count($like);?> Liked Gigs</b></td>
														
 </tr>

		<?php
			foreach($like as $gigs) 
			{ 
			?>
			  <tr  class="rowgrid">
			  <td class="frame"><a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>"><img src="/uploads/gig_img/<?php if($gigs['Gig']['image']==''){?>noimage.jpg <?php } else { echo $gigs['Gig']['image']; } ?>" title="Gigs" width="120px"  height="80px"/></a>
               <?php if($gigs['Gig']['featured']=='Y'){ ?>   <a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>"><span class="featured-label">featured</span></a> <?php } ?>
              </td>
			<td>
            <table width="100%">
            <tr><td colspan="4"><h4 class="blog-title"> <a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>">I Will <?php echo $gigs['Gig']['title'];?> for $<?php echo $gigs['Gig']['price'];?></a></h4></td></tr>
            <tr><td colspan="4"><?php echo substr($gigs['Gig']['description'],0,50);?>&nbsp;...... <br />(by <?php echo $gigs['User']['username']; ?>)</td></tr><tr><td>&nbsp;</td></tr>
            <tr><td><a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>">Read More</a>
            &nbsp;<?php
		if(isset($gigs['Gig']['like_user']) && $gigs['Gig']['like_user'] !='')
		{			
		?>
                  <a href="/users/unlike/<?php echo $gigs['Gig']['id']; ?>"> <img src="/images/like.png" title="like" /> </a>
		  <?php     
		           }
		  
			  ?><td><a href="#">Share</a></td><td><a href="http://www.facebook.com/share.php?u=<?php echo SITE_URL; ?>/gigs/ordergig/<?php echo $gigs['Gig']['id'] ?>" onclick="return fbs_click()" target="_blank"><img src="/images/icon-facebook.png" alt="Share on Facebook" /></a>
              &nbsp;  <a href="http://twitter.com/home?status=<?php echo SITE_URL; ?>/gigs/ordergig/<?php echo $gigs['Gig']['id']; ?>" title="Click to share this post on Twitter" target="_blank"><img src="/images/icon-twitter.png" alt="Share on Twitter"></a>&nbsp;  <a href="/gigs/sendEmail/<?php echo $gigs['Gig']['id']; ?>"><img src="/images/btn-email.png" title="post on your email" /></a></td>      
            <td><input type="button" class="broap" value="Order"  id="<?php echo $gigs['Gig']['id']; ?>" onclick="return order(this.id);"  /></td></tr></table>&nbsp;</td>
			
			
		</tr>
       
<tr><td colspan="2"><hr  class="break"></td></tr>
		 <?php } ?> 
		   <tr><td colspan="2">

<?php echo $this->element('pagination'); ?></td>   
           </tr>
	<?php	}
	?>                  </table>
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

</script>