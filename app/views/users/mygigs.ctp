<?php $this->set('title_for_layout', 'My Gigs');?><h3 class="blog-title"><a href="#" title="Profile Settings">My Gigs</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post" name="MyGig" id="MyGig"   >
				 <table cellspacing="0" cellpadding="0"  class="payment" width="100%">
                        <tbody>
                            <tr>
							<td><input type="button" id="add_new"  class="broap" value="Add New" onclick="return redirect();" ></td>
							<td><input type="button" id="suspend" class="broap" value="Suspend" onclick="return redirect1();" ></td>
							<td><input type="button" id="active" class="broap" value="Active" onclick="return redirect2();"></td>
							
 </tr>
                        </tbody>
                    </table>
					
                   
                    <div class="form">
                    <table cellspacing="0" cellpadding="0"  class="payment" width="100%" align="center">
                    
                                     <?php 
					 if(count($allgigs)>0){ //echo "<pre>";print_r($allUser);
	foreach($allgigs as $gigs) 
	{ 
	?>
	  <tr>
      <td align="center"><input type="checkbox" name="data[MyGig][check][]" value="<?php echo $gigs['Gig']['id'];?>"/></td><td><img src="/uploads/gig_img/<?php if($gigs['Gig']['image']==''){?>noimage.jpg <?php } else { echo $gigs['Gig']['image']; } ?>" title="Gigs" width="80px"  height="50px"/></td>
    <td><a href="/gigs/ordergig/<?php echo $gigs['Gig']['id'];?>"><b>I will <?php echo $gigs['Gig']['title'];?> for $<?php echo $gigs['Gig']['price'];?></b></a></td>
	
	<?php
	if($gigs['Gig']['status']=='Active')
	{
	 echo "<td ><font style='background-color:#000; font-size:14px ; color:white'><b>".$gigs['Gig']['status']."</b></font</td>";
	}
	else
	{
	echo '<td><font  style="background-color:#CCC; font-size:14px" ><b>'.$gigs['Gig']['status'].'</b></font></td>';
	}
	 ?>
     
     </td><td><a href="/users/editgig/<?php echo $gigs['Gig']['id'];?>"><strong>Edit</strong></a></td>
</tr>
<tr><td colspan="5"><hr class=" pagination-break" /></td></tr>
<?php } 
					 }
?>
<tr><td colspan="5"><?php echo $this->element('pagination'); //call pagination from element ?></td></tr>		
                    
                   </table>
                    </div></form>
</div>

<script language="javascript" type="text/javascript">

function redirect()
{
	if(document.getElementById('add_new').value=='Add New')
	{
		
		window.location="/users/addgigs";
		//return true;
	}
}
function redirect1()
{
	if(document.getElementById('suspend').value=='Suspend')
	{
		 document.MyGig.action='/users/suspend'; 
		 document.MyGig.submit();
		
	}
}
function redirect2()
{
	if(document.getElementById('active').value=='Active')
	{
		
		document.MyGig.action='/users/active'; 
		 document.MyGig.submit();
	}
}

</script>