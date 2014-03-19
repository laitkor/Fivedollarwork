<?php $this->set('title_for_layout', 'Sent Items');?><h3 class="blog-title"><a href="#" title="Profile Settings">Conversaton with <?php echo $msg[0]['User']['username']; ?></a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post" >
                    <div class="blog-meta">This Message is related to <strong><?php echo $msg[0]['User']['username']; ?>'s gig</strong><a href="#" title="Uncategorized"> I will <?php echo $msg[0]['Gig']['title'] ?> for <?php echo $msg[0]['Gig']['price'] ?></a></div><br><br><br>
				 
                 

<div><h4 class="blog-title"><?php echo $msg[0]['Message']['subject']; ?></h4></div>
 <br>
  
                  <div class="sidebar-content"> 
<div class="blog-content"><p><?php echo $msg[0]['Message']['message']; ?></p></div>
                        </div>
				
                             </form>
</div>

<script language="javascript" type="text/javascript">


function order(id)
{
	
	if(document.getElementById(id).value=='Order')
	{
		
		document.Ordergig.action='gigs/ordergig/'+id; 
		 document.Ordergig.submit();
	}
}

</script>