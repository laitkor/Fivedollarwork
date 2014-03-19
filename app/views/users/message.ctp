<?php $this->set('title_for_layout', 'Sent Items');?><h4 class="blog-title">Message</h4>
                    
                    <?php if(isset($msg[0]['Message']['id'])){ ?>
					<form class="wpsc_checkout_forms" method="post" action="/users/reply/<?php echo $msg[0]['Message']['id']; ?>/<?php if($msg[0]['Message']['to_users_id']==$user_id)
				  {
				   echo $msg[0]['FUser']['id'];
				  }
				  else
				  {
				    echo $msg[0]['User']['id'];
				  } ?>" enctype="multipart/form-data" ><?php } /*else { ?>
 <form class="wpsc_checkout_forms" method="post" action="/users/reply/<?php echo $msg[0]['Sentmessage']['id']; ?>" > <?php } */?>
                    <div class="blog-content">
                   
      <table width="100%" >                               
    <?php if($type=='inbox') {
		
		 ?>
                 
                 
                  <tr><td>  <a href="/users/inbox">Back to Inbox</a></td><td align="right">Date :<b><?php $date= $msg[0]['Message']['date'];
			$old_date = date($date);
echo $new_date = date('m-d-Y', strtotime($old_date));
 ?></b></td></tr>
                  <tr><td colspan="2"><hr class="pagination-break" /></td></tr>
                  <tr><td colspan="2"> &nbsp; &nbsp;From : &nbsp;<b>
				  
				  <?php
				if($msg[0]['Message']['to_users_id']==$user_id)
				  {
				
				   if(is_numeric($msg[0]['FUser']['username'])) {echo $msg[0]['FUser']['name']; }else {echo $msg[0]['FUser']['username']; } 
				  }
				  else
				  {
				  
					if(is_numeric($msg[0]['User']['username'])) {echo $msg[0]['User']['name']; }else {echo $msg[0]['User']['username']; } 
				  }
				  ?></b></td></tr>
                  <tr><td colspan="2"><br /> Subject : &nbsp;<b><?php echo $msg[0]['Message']['subject']; ?></b></td></tr>
  
<tr><td colspan="2"> <br />Message :
<?php if(!empty($reply))
{
	foreach($reply as $re)
	{
		
		 ?>

<table class="comment-right" <?php if($re['User']['id']==$user_id){ echo 'style="margin-left:70px; width:86%; background-color:#FDFCCC;"';} else { echo 'style="margin-left:70px; width:86%; background-color:#D5FDFD;"'; } ?>><tr><td style="float:left;"><img src="/uploads/profile_img/
<?php 
 if($re['FUser']['image']==''){?>no_img.jpg <?php } else {  echo $re['FUser']['image']; }
?>" width="40px" height="40px" title="<?php 
if(is_numeric($re['FUser']['username'])) {echo $re['FUser']['name']; }else {$re['FUser']['username']; } 
  ?>" /></td>
<td><table style="margin-left:10px; width:406px;">
<tr><td align="right" colspan="2"><strong><?php $date= $re['Message']['date'];
			$old_date = date($date);
echo $new_date = date('m-d-Y', strtotime($old_date));
 ?></strong></td></tr>
<tr><td style="width:80%;"><?php echo $re['Message']['message']; ?></td></tr>
<?php if($re['Message']['attachment']!="") { ?>
 <tr><td  style="width:80%">Attached File : <b><?php echo $re['Message']['attachment']; ?></b></td></tr><tr><td  align="right"><a href="/uploads/attachment/<?php echo $re['Message']['attachment']; ?>" ><strong>Download </strong></a></td></tr>
					<?php } ?>
</table></td></tr></table>
<?php } }?>



<tr><td colspan="2">Reply :<p> <textarea   name="data[message]" class="comment-right" rows="5" cols="55" ></textarea></p></td></tr>
<tr><td><b>Attachment : </b></td><td><input type="file" name="data[attachment]" class="text" /><br /><span style="font-size:10px">For multiple files we recommend using a file-compression utility. .</span></td></tr>
 <tr><td colspan="2"><input type="submit" class="broap" value="Reply>>"/></td></tr>
  <tr><td colspan="2"><hr class="pagination-break" /></td></tr>

					<?php  }
					
					else { ?>
          <tr><td><a href="/users/sentitems">Back to Sent</a></td><td align="right">Date :<b><?php $date= $msg[0]['Sentmessage']['date'];
			$old_date = date($date);
echo $new_date = date('m-d-Y', strtotime($old_date));
 ?></b></td></tr>
            <tr><td colspan="2"><hr class="break" /></td></tr>
          <tr><td colspan="2">To : &nbsp;<b><?php echo $msg[0]['FUser']['username']; ?></b></td></tr>
          <tr><td colspan="2"><br /> Subject : &nbsp;<b><?php echo $msg[0]['Sentmessage']['subject']; ?></b></td></tr>
  
<tr><td colspan="2"> <br />Message : 
<?php if(!empty($reply))
{
	foreach($reply as $re)
	{
		
		 ?>

<table class="comment-right" 
<?php if($re['User']['id']==$user_id)
{
echo 'style="margin-left:70px; width:89%; background-color:#FDFCCC"';} 
else {
	echo '
 style="margin-left:70px; width:89%; background-color:#D5FDFD"';}?> >
 <tr><td><img src="/uploads/profile_img/
<?php 
 if($re['User']['image']==''){?>no_img.jpg <?php } else {  echo $re['User']['image']; }
?>" width="40px" height="40px" title="<?php if(is_numeric($re['User']['username'])) {echo $re['User']['name']; }else {$re['FUser']['username']; }  ?>" /></td><td><table ><tr><td><?php echo $re['Sentmessage']['message']; ?></td></tr>

</table></td></tr></table>
<?php } }?>
</td></tr>
  <tr><td colspan="2"><hr class="pagination-break" /></td></tr>
  <?php if($msg[0]['Sentmessage']['attachment']!="") { ?>
 <tr><td>Attached File : <b><?php echo $msg[0]['Sentmessage']['attachment']; ?></b></td><td><a href="/uploads/attachment/<?php echo $msg[0]['Sentmessage']['attachment']; ?>" > <strong>Download</strong></a></td></tr>      
    


<?php }} ?>				
                </table>
 </div>                            </form>


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