<?php $this->set('title_for_layout', 'Sent Items');?><h3 class="blog-title"><a href="#" title="Profile Settings">Sent Items</a></h3>
                     <script type="text/javascript" src="../js/ikonik.js"></script>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post" name="Sent" id="Sent" >
<!--<ul id="tabs-home" class="tabs-nav clearfix">
                	<li><a href="#" title="Inbox" onclick="inbox();">Inbox</a></li>
                    <li><a href="#" title="Sent Items" >Sent Items</a></li>
                </ul>-->
              <div class="metadata">
		<ul class="filters">
			<li>
				<a href="#" onclick="inbox();"><span >Inbox </span></a></li>
			<li>
				<a href="" onclick="sent();" ><span style="background-color:#000; color:#FFF">Sent Items</span></a></li>
        </ul></div>
 
              	 <table cellspacing="0" cellpadding="0"  class="payment" width="100%" border="2" style="border-color:#CCC">
                        <tbody>
                            <tr style="background-color:#CCC;"><td><input type="checkbox" name="selected" id="selected" value="" onclick="checkAll();"  /></td>
							<td align="center" ><span href="#" style="color:#000; font-weight:bold">Subject/Gig</span></td>
							<td align="center"><span href="#" style="color:#000; font-weight:bold">To	</span></td>
							<td align="center"><span href="#" style="color:#000; font-weight:bold">Date</span></td>
                          
							
 </tr> 
      <?php 
	if(count($to)>0)
		{ 
		
			foreach($to as $msg) 
			{ 
			?>
			  
            <tr style="background-color:#a6ba76; color: #000; font-weight:normal; cursor:pointer" >
                  <td align="center"><?php echo  $form->input('check',array('label'=>false,'type'=>'checkbox',' value'=>$msg['Sentmessage']['id'])); ?><!--<input type="checkbox" name="check" value="<?php echo $msg['Sentmessage']['id'];?>" />--></td>

            <td onclick="redirect(<?php echo ($msg['Sentmessage']['parent_id'] > 0)? $msg['Sentmessage']['parent_id'] : $msg['Sentmessage']['id'];?>,'sent');"><?php echo $msg['Sentmessage']['subject'];?></td>
<td onclick="redirect(<?php echo ($msg['Sentmessage']['parent_id'] > 0)? $msg['Sentmessage']['parent_id'] : $msg['Sentmessage']['id'];?>,'sent');"><?php if(is_numeric($msg['FUser']['username'])) {echo $msg['FUser']['name']; }else {echo $msg['FUser']['username']; } ?></td>
            
            <td onclick="redirect(<?php echo ($msg['Sentmessage']['parent_id'] > 0)? $msg['Sentmessage']['parent_id'] : $msg['Sentmessage']['id'];?>,'sent');"><?php $date= $msg['Sentmessage']['date'];
			$old_date = date($date);
echo $new_date = date('m-d-Y', strtotime($old_date));
 if( $msg['Sentmessage']['attachment']!="")	{	 ?>&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/hdr_atch.png"  /> <?php } ?></td></tr>
           
		
		 <?php } ?>
		  <tr style="background-color:#CCC;"><td colspan="3"><?php echo $this->element('pagination'); //call pagination from element ?></td><td width="20%"><input type="button" name="delete" id="delete" value="Delete" class="broap"  onclick="return deleteall(document.getElementById('check').value);"/></td></tr>
<?php		}
else {
	
?>
<tr><th colspan="5" align="center">Sent Message Box is empty</th></tr>
<?php }?>
	
                    
                   </table>
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


function checkAll()
{

if(document.Sent.selected.checked== true)
{
for(var i=0; i < document.Sent.check.length; i++)
{
document.Sent.check[i].checked=true;
}
}
else
{
for(var i=0; i < document.Sent.check.length; i++)
{
document.Sent.check[i].checked=false;
}
}
}

function deleteall()
{
	
 if(document.getElementById('delete').value=='Delete')
	{
		var myarray=new Array();
		if(document.Sent.check.length == undefined)
		{ 
		
		   document.Sent.check.length=1;
		  
		}
		
		if(document.Sent.check.checked)
		{
			
		  myarray[0]=document.Sent.check.value;
		 
		}
		else
		{
		for(var i=0; i < document.Sent.check.length; i++)
			{
			  if(document.Sent.check[i].checked==true)
			  {
				myarray[i]=document.Sent.check[i].value;
			  }
			}

		
		
		}
		 document.Sent.action='/users/del_outbox/'+myarray; 
		 document.Sent.submit();
	}

}
function inbox()
{
	document.Sent.action='/users/inbox'; 
		 document.Sent.submit();

}
function sent()
{
	document.Sent.action='/users/sentitems'; 
		 document.Sent.submit();

}
function redirect(msg_id,type)
{
	
	/*if(status=='unread')
	{
		
		document.getElementById(id).style.backgroundColor='#D6F7FE';
		document.getElementById(id).style.fontWeight='normal';
		
	}*/
	 document.Sent.action='/users/message/'+msg_id+'/'+type; 
		 document.Sent.submit();
}

</script>