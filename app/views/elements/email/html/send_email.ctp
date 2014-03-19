                    <div class="blog-meta"></div>
                    <div class="blog-content">
<h3>Hi <?php echo $user['username'];?> ,</h3>
<p><b>You recieved the following Gig :</b></p>
</p>
<div><hr class="break" /></div>

                 
  <div class="form">
                    <table cellspacing="0" cellpadding="0"  class="payment" width="100%" >
    		  <tr>
			  <td><a href="<?php echo SITE_URL; ?>/gigs/ordergig/<?php echo $gigId[0]['Gig']['id'] ?>"><img src="<?php echo SITE_URL; ?>/uploads/gig_img/<?php if($gigId[0]['Gig']['image']==''){?>noimage.jpg <?php } else 
			  {
				   echo $gigId[0]['Gig']['image']; } ?>" title="Gigs" width="120px"  height="80px"/></a></td>
			<td>
            <table width="100%">
            <tr><td colspan="4"><h4>
            <a href="<?php echo SITE_URL; ?>/gigs/ordergig/<?php echo $gigId[0]['Gig']['id'] ?>">
            I Will <?php echo $gigId[0]['Gig']['title'];?> for $<?php echo $gigId[0]['Gig']['price'];?>
            </a></h4></td></tr>
            <tr><td colspan="4"><?php echo substr($gigId[0]['Gig']['description'],0,80);?>.........(by <a href="#"><?php echo $gigId[0]['User']['username']; ?></a>)</td></tr>
            
            <tr><td><b>Job Price :  $<?php echo $gigId[0]['Gig']['price'];?></b></td></tr></table>&nbsp;</td>
			
			
		</tr>
        <tr><td colspan="4" class="break"><hr  /></td></tr>
		 
        </td></tr>
        
        
                   </table>
                    </div>  
                    <div><b>Best Regards,</b></div>
                    <div><b>5$ Work Team</b></div>   
            
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
	function sendemail(url)
	{
		alert(url);
	  Session('url')=url;
	}


</script>