<?php $this->set('title_for_layout', 'Compose Message');?><h3 class="blog-title"><a href="#" title="Profile Settings">Compose Message</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post" name="Compose" action="/gigs/compose/<?php echo $user['User']['id']; ?>/<?php echo $gig['Gig']['id']; ?>" enctype="multipart/form-data" id="Compose" >
				 <table cellspacing="0" cellpadding="0" width="100%">
                        <tbody>
                            <tr>
							<th><a href="/users/inbox">Inbox</a></th>
							<th><a href="/users/sentitems">Sent Items</a></th>
                            
							</tr>
                          
                        </tbody>
                    </table>
					
                  <hr class="pagination-break" />
				  <div class="form">
                    <table cellspacing="0" cellpadding="0"  class="payment" width="100%" >
   
			  <tr><td><b>From : </b></td>
			  <td>
			  <?php if(is_numeric($user['User']['username'])) {echo $user['User']['name']; }else {echo$user['User']['username']; } ?>
			   </td>
              </tr>
			<tr><td><b> To : </b></td><td><?php echo $gig['User']['username']; ?></td></tr>
            <tr><td><b>Gig : </b></td><td><?php echo $gig['Gig']['title'] ?></td></tr>
            <tr><td><b>Subject : </b></td><td><input type="text" name="data[subject]"  class="text required" /></td></tr>
            <tr><td><b>Message : </b></td><td>  <textarea  name="data[message]" rows="10" cols="40" class="text required"  ></textarea></td></tr>
            <tr><td colspan="2"><b> Attachment maximum 50 mb. :</b></td></tr>
            <tr><td><b>Attachment : </b></td><td><input type="file" name="data[attachment]" class="text" /></td></tr>
            <tr><td colspan="2"><input type="submit" class="broap" value="Send"/></td></tr></table>
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
<script>
  jQuery(document).ready(function(){
			jQuery("#Compose").validate();
  });
</script>
