<?php $this->set('title_for_layout', 'Profile Settings');?><h3 class="blog-title"><a href="#" title="Profile Settings">Profile Settings</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                   <table cellspacing="0" cellpadding="0" border="1" class="payment" width="100%">
                        <tbody>
                            <tr>
                                <td class="row">My public profile: <a href="<?php echo SITE_URL."/".$record['username'];?>" title="<?php echo $record['username'];?>" style="color:#FFF"><?php
								if(is_numeric($record['User']['username'])) { echo SITE_URL."/".$record['username']; }else { echo SITE_URL."/".$record['username'];}?>
								</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <form method="post" action="/users/profile" class="wpsc_checkout_forms" id="profile" enctype="multipart/form-data">
                   <b> Fields marked with an asterisk must be filled in.</b>
                        <hr class="pagination-break" />
                        <div class="form">
                         <label>Full Name: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[name]" value="<?php if($record['name']!="") {echo $record['name'];}?>" class="text required" type="text" pattern="[a-zA-Z0-9_.]{5,}" maxlength="50" />
                             </div>
                             <div class="clear"></div><label>Email: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[email]" value="<?php if($record['email']!="") {echo $record['email'];}?>" class="text required email"   />
                             </div>
                             <div class="clear"></div><label>Paypal Account: </label>
                            <div class="in">
                             <input name="data[paypal_email]" value="<?php if($record['paypal_email']!="") {echo $record['paypal_email'];}?>" class="text" title="Paypal Account" type="email" />
                             </div>
                              <div class="clear"></div><label>Website: </label>
                            <div class="in">
                             <input name="data[website]" value="<?php if($record['website']!="") {echo $record['website'];}?>" class="text" title="Website" type="url" />
                             </div>
                            <div class="clear"></div><label>Something about you: </label>
                            <div class="in" style=" margin-left:165px; text-align:justify; font-size:11px">
                             <textarea cols="22" rows="3" name="data[description]" minlengthvalue="250"  class="text" title="Something about you" style="resize:none;" onKeyDown="limitDesc(250);" onKeyUp="limitDesc(250);" id="description"  ><?php if($record['description']!="") {echo $record['description'];}?></textarea><br /><font size="1">
You have <span id="desleft">250</span> characters left.</font>
                             </div>
                            <div class="clear"></div><label>Profile Picture:</label>
                            <div class="in">
							<input type="file" name="data[image]" accept="png|jpe?g|gif"><br/>
                            <div class="profile">
                            <?php 
							
							/*if(file_exists(WWW_ROOT."/uploads/profile_img/".$record['image'])) { echo '<img alt="'.$record['username'].'" src="/uploads/profile_img/'.$record['image'].'" class="avatar">';} else {echo '<img alt="'.$record['username'].'" src="/uploads/profile_img/no_icon.gif" />';}*/
							if($record['image']=="")
							{
							 echo '<img alt="'.$record['username'].'" src="/uploads/profile_img/no_icon.gif" />'; 
							}
							else
							{
							  echo '<img alt="'.$record['username'].'" src="/uploads/profile_img/'.$record['image'].'" class="avatar">';
							}
							?>
                            </div>
                            </div>
                             </div>
                            
                        <hr class="pagination-break" />
                        <div> <p><br/><a href="/users/changepassword" title="Change Password"><b>Change Password</b></a></p></div>
<input type="submit" class="broap" value="Submit" id="submit"/>
                    </form> 
                    
</div>

<!--<script> 
$("#profile").validator();
</script>
--><script>
  jQuery(document).ready(function(){
			jQuery("#profile").validate();
  });
</script>