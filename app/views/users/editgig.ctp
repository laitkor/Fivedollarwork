<?php $this->set('title_for_layout', 'Add New Gigs');?><h3 class="blog-title"><a href="#" title="Add New Gigs">Edit Gigs</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/editgig/<?php echo $gig[0]['Gig']['id'];  ?>" class="wpsc_checkout_forms" id="addgig" enctype="multipart/form-data">
                        Fields marked with an asterisk must be filled in.
                        <hr class="pagination-break" />
                        <div class="form">
                         <label>I will: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[title]"  class="text required" 
                             value="<?php echo $gig[0]['Gig']['title']; ?>" />
                             </div>
                             <div class="clear"></div><label>Category: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <select name="data[category_id]" class="text required" >
                             <option value="<?php echo $gig[0]['Category']['id']; ?>">
                             <?php echo $gig[0]['Category']['name']; ?></option>
                             <?php foreach($listcategory as $Category){ ?>
                             <option value="<?php echo $Category['Category']['id']; ?>"><?php echo $Category['Category']['name']; ?></option>
                            <?php } ?>
                             </select>
                             </div>
                             <div class="clear"></div><label>Job Price: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <select name="data[price]" class="text required" >
                	<option selected="selected" value="<?php echo $gig[0]['Gig']['price']; ?>">$<?php echo $gig[0]['Gig']['price']; ?></option>
                    <?php if(isset($gigsprice))
					{foreach($gigsprice as $price){ 
				
						?>
                    
                    <option value="<?php echo $price['Gigsprice']['price']; ?>">$<?php echo $price['Gigsprice']['price']; ?></option>
                    <?php }} ?>
                </select>
                             </div>
                             <div class="clear"></div><label style="text-align:justify">Description <span style="color:#F00">*</span></label>
                            <div class="in" style=" margin-left:165px; text-align:justify; font-size:11px">
                             <textarea   name="data[description]" rows="10" cols="30" class="text required" style="resize:none;" onKeyDown="limitDesc(250);" onKeyUp="limitDesc(250);" id="description" ><?php echo $gig[0]['Gig']['description']; ?></textarea> <br /><font size="1">
You have <span id="desleft">250</span> characters left.</font>
                             <br /><br />Be as descriptive as possible.
Provide samples, what is required, what you will and will not do Define the extents of this gig - how many units, revisions, samples are included 
                             </div>
                            <div class="clear"></div><label>Keywords/Tags <span style="color:#F00">*</span> 
</label>
                            <div class="in" style=" margin-left:165px; font-size:11px"> <textarea   name="data[keywords_tags]" rows="6" cols="30" class="text required" onchange="char_len(this.value)" style="resize:none;"  ><?php echo $gig[0]['Gig']['keywords_tags']; ?> </textarea> <br /><br />Enter keywords that best describe your gig.Example: social marketing,stickers
							</div>
                              <div id="msg" style="color:#F00"></div>
                            <div class="clear"></div><label>Maximum Days To Complete: <span style="color:#F00">*</span></label>
                            <div class="in"  style=" margin-left:165px; text-align:justify; font-size:11px">
							<input name="data[max_days]"  class="text required"   value="<?php echo $gig[0]['Gig']['max_days']; ?>" onchange="days(this.value)" id="txtNumber" onKeyUp="checkNumber(this.id);"  /><br /><br />
                            <span id="msg1" style="color:#F00"></span>The longest time it will take you to complete your work.<br /><br/>

<p>Consider:  time to accept the order, timezone differences, <br />the free time you have  for this work and correspondence<br /> with your buyers.</p><br /><br />

<p>Late deliveries are the #1 reason for order cancellations</p>
                            </div>

                            
                             <div class="clear"></div><label>Gig Image: <span style="color:#F00">*</span></label>
                            <div class="in">
                            <img src="/uploads/gig_img/<?php if($gig[0]['Gig']['image']==''){?>noimage.jpg <?php } else { echo $gig[0]['Gig']['image']; } ?>" title="Gigs" width="80px"  height="50px"/><input name="data[image]" type="file" class="text" accept="png|jpe?g|gif" />
                             </div>
                              </div>
                        <hr class="pagination-break" />
<div style=" width:100%"><input type="submit" class="broap" value="Update" id="update"/>&nbsp;&nbsp;<input type="button" value="Cancel" class="broap" onClick="javascript: history.go(-1)"></div>
                    </form> 
</div>
<script> 
jQuery(document).ready(function(){
			jQuery("#addgig").validate();
  });
function char_len(val)
{
	var str;
	if(val.length>0)
	{
		str=val.split(",");
		if(str.length >4 || val.length > 80)
		{
		  document.getElementById('msg').innerHTML='Tag List Can Contain Upto 4 Tags Or 50 Characters .Example :"fun,video,marketing"';
		  
		}
		else
		{
			document.getElementById('msg').innerHTML="";
		}
	}
}
function days(val)
{
  var day=30;
  if(val >= 30)
  { 
    document.getElementById('msg1').innerHTML='Expected duration must be less than 30 days.';
  }
  else
  {
	  document.getElementById('msg1').innerHTML="";
   }
  
}
function CalcKeyCode(aChar) {
  var character = aChar.substring(0,1);
  var code = aChar.charCodeAt(0);
  return code;
}

function checkNumber(val) {

  var strPass = document.getElementById(val).value;
  var strLength = strPass.length;
  var lchar = document.getElementById(val).value.charAt((strLength) - 1);
  var cCode = CalcKeyCode(lchar);

  /* Check if the keyed in character is a number
     do you want alphabetic UPPERCASE only ?
     or lower case only just check their respective
     codes and replace the 48 and 57 */

  if (cCode < 48 || cCode > 57 ) {
    var myNumber = document.getElementById(val).value.substring(0, (strLength) - 1);
    document.getElementById(val).value = myNumber;
  }
  return false;
}
</script> 
