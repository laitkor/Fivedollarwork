<?php $this->set('title_for_layout', '');?><h3 class="blog-title"><a href="#" title="Profile Settings">My Gigs</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post" name="MyGig" id="MyGig"   >
				 <table cellspacing="0" cellpadding="0"  class="payment" width="100%">
                        <tbody>
                            <tr>
							<th>Filter By</th>
							<td>Most Popular</td>
							<td>Best Ratings</td>
                            <td>Latest</td>
							
 </tr>
                        </tbody>
                    </table>
					
                    <hr class="break" />
                    <div class="form">
                    <table cellspacing="0" cellpadding="0"  class="payment" width="100%" border="1">
                    <tr><th></th><th align="center">Gigs</th><th align="center">Status</th></tr>
                                     <?php 
					 if(count($allgigs)>0){ //echo "<pre>";print_r($allUser);
	foreach($allgigs as $gigs) 
	{ 
	?>
	  <tr>
      <td align="center"><input type="checkbox" name="data[MyGig][check][]" value="<?php echo $gigs['Gig']['id'];?>"/></td>
    <td align="center"><?php echo $gigs['Gig']['title'];?>&nbsp;</td>
	
	<td align="center"><?php echo $gigs['Gig']['status'];?>&nbsp;</td>
</tr>
<?php } 
					 }
?>
					
                    
                   </table>
                    </div></form>
</div>

<script language="javascript" type="text/javascript">

function redirect()
{
	if(document.getElementById('add_new').value=='Add New')
	{
		
		window.location="addgigs";
		//return true;
	}
}
function redirect1()
{
	if(document.getElementById('suspend').value=='Suspend')
	{
		 document.MyGig.action='suspend'; 
		 document.MyGig.submit();
		
	}
}
function redirect2()
{
	if(document.getElementById('active').value=='Active')
	{
		
		document.MyGig.action='active'; 
		 document.MyGig.submit();
	}
}

</script>