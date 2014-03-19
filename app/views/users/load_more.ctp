<?php foreach($recommendlist as $key=>$value) {?>
  <tr>
  <?php  
			$user_id=$this->Session->read('User.id');
			
			 ?>
    <td><b><a href="/users/compose/<?php echo $user_id ?>/<?php echo $value['Recommend']['id']?>" title="Contact to <?php echo $value['User']['username']?>"><?php  if(is_numeric($value['User']['username'])) {echo $value['User']['name']; }else {echo $value['User']['username']; }?></a> wants:</b></td>
  </tr>
  <tr>
    <td><?php echo $value['Recommend']['recommend']?> for $<?php echo $value['Recommend']['price']?></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <?php }?>
  <tr id="morevideos-<?php echo $nextpage;?>"><td></td><td colspan="2" align="center"><div  class="morevideos"><a href="#" class="loadmore" id="<?php echo $nextpage;?>" style="color:#000;">More ..</a></div></td></tr>