<?php $this->set('title_for_layout', 'Inbox');?><h3 class="blog-title"><a href="#" title="Profile Settings">Inbox/All Messages</a></h3>
    <script type="text/javascript" src="../js/ikonik.js"></script>

                    <div class="blog-meta"></div>
                    <div class="blog-content">
					<form class="wpsc_checkout_forms" method="post" name="Inbox" id="Inbox" >
				
          <div class="metadata">
		<ul class="filters">
			<li>
				<a href="" onclick="inbox();"><span style="background-color:#000; color:#FFF">Inbox </span></a></li>
			<li>
				<a href="#" onclick="sent();" ><span>Sent Items</span></a></li>
        </ul></div>
           
              	 <table cellspacing="0" cellpadding="0"  class="payment" width="100%" border="2" style="border-color:#CCC">
                        <tbody>
                            <tr style="background-color:#CCC;"><td><input type="checkbox" name="selected" id="selected" value="" onclick="checkAll();"  /></td>
							<td align="center" ><span style="color:#000; font-weight:bold">Subject/Gig</span></td>
							<td align="center"><span href="#" style="color:#000; font-weight:bold">From</span></td>
							<td align="center"><span href="#" style="color:#000; font-weight:bold">Date</span></td>
                          
							
 </tr> 
      <?php 
	if(count($to)>0)
		{ 
			foreach($to as $msg) 
			{
				
			?>
			 <?php if($msg['Message']['status']=='unread') {?>
			
            <tr style="background-color:#424a2a; color: #000; font-weight:bold; cursor:pointer" >
                  
           
		
		 <?php }
		 else
		 { ?>
			 <tr id="<?php echo $msg['Message']['id']?>" style="background-color:#a6ba76; color: #000; font-weight:normal; cursor:pointer" > 
		<?php  }?>
         <td align="center">
                  <?php echo  $form->input('check',array('label'=>false,'type'=>'checkbox',' value'=>$msg['Message']['id'])); ?></td>

            <td onclick="redirect(<?php echo ($msg['Message']['parent_id'] > 0)? $msg['Message']['parent_id'] : $msg['Message']['id'];?>,'inbox','<?php echo $msg['Message']['status']; ?>',<?php echo $msg['Message']['id']; ?>);"><?php echo $msg['Message']['subject'];?></td>
            <td onclick="redirect(<?php echo ($msg['Message']['parent_id'] > 0)? $msg['Message']['parent_id'] : $msg['Message']['id']?>,'inbox','<?php echo $msg['Message']['status']; ?>',<?php echo $msg['Message']['id']; ?>);">
			<?php if(is_numeric($msg['FUser']['username'])) {echo $msg['FUser']['name']; }else {echo $msg['FUser']['username']; } ?></td>
            
            <td onclick="redirect(<?php echo ($msg['Message']['parent_id'] > 0)? $msg['Message']['parent_id'] : $msg['Message']['id']?>,'inbox','<?php echo $msg['Message']['status']; ?>',<?php echo $msg['Message']['id']; ?>);"><?php  $date= $msg['Message']['date'];
			$old_date = date($date);
echo $new_date = date('m-d-Y', strtotime($old_date));
	if( $msg['Message']['attachment']!="")	{	 ?>&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/hdr_atch.png"  /> <?php } ?></td></tr>
		 
		 <?php  }  ?>
		 <tr style="background-color:#CCC;"><td colspan="3"><?php echo $this->element('pagination'); //call pagination from element ?></td><td width="22%" ><input type="button" name="delete" id="delete" value="Delete" class="broap"  onclick="return deleteall(document.getElementById('check').value);"/></td></tr>					
                    
                  
                   
		<?php } 
		else { ?>
        <tr><th colspan="5" align="center">Message Box is empty</th></tr>
<?php }?>
 </table>
</form>		
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
function checkAll()
{

if(document.Inbox.selected.checked== true)
{
for(var i=0; i < document.Inbox.check.length; i++)
{
document.Inbox.check[i].checked=true;
}
}
else
{
for(var i=0; i < document.Inbox.check.length; i++)
{
document.Inbox.check[i].checked=false;
}
}
}

function deleteall(id)
{
	
 if(document.getElementById('delete').value=='Delete')
	{
		//alert(id);
		var myarray=new Array();
		if(document.Inbox.check.length == undefined)
		{ 
		//alert(id);
		   document.Inbox.check.length=1;
		  
		}
		
		if(document.Inbox.check.checked)
		{
			
		  myarray[0]=document.Inbox.check.value;
		 
		}
		else
		{
		for(var i=0; i < document.Inbox.check.length; i++)
{
	
  if(document.Inbox.check[i].checked==true)
  {
    myarray[i]=document.Inbox.check[i].value;
	
  }
}
}


		 document.Inbox.action='/users/del_inbox/'+myarray; 
		 document.Inbox.submit();
		
	}

}
function inbox()
{
	document.Inbox.action='/users/inbox'; 
		 document.Inbox.submit();

}

function sent()
{
	document.Inbox.action='/users/sentitems'; 
		 document.Inbox.submit();

}
function redirect(id,type,sta,msg_id)
{
	
	/*if(status=='unread')
	{
		
		document.getElementById(id).style.backgroundColor='#D6F7FE';
		document.getElementById(id).style.fontWeight='normal';
		
	}*/
	
	 document.Inbox.action='/users/message/'+id+'/'+type+'/'+sta+'/'+msg_id; 
		 document.Inbox.submit();
}
</script>