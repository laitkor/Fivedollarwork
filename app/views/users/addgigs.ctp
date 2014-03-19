<?php $this->set('title_for_layout', 'Add New Gigs');?><h3 class="blog-title"><a href="#" title="Add New Gigs">Add New Gigs</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/addgigs" class="wpsc_checkout_forms" id="addgig" enctype="multipart/form-data">
                       <b> Fields marked with an asterisk must be filled in.</b>
                        <hr class="pagination-break" />
                        <div class="form">
                         <label>I will: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[title]" id="title"  class="text required" onKeyDown="limitTitle(70);" onKeyUp="limitTitlr(70);" maxlength="70"  /><br /><font size="1">
You have <span id="charleft">70</span> characters left.</font>


                             </div>
                             <div class="clear"></div><label>Category: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <select name="data[category_id]" class="text required" >
                             <option value="">Please Select</option>
                             <?php foreach($listcategory as $Category){ ?>
                             <option value="<?php echo $Category['Category']['id']; ?>"><?php echo $Category['Category']['name']; ?></option>
                            <?php } ?>
                             </select>
                             </div>
                             <div class="clear"></div><label>Job Cost: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <select name="data[price]" class="text required">
                	<option selected="selected" value="">Price</option>
                    <?php if(isset($gigsprice)){foreach($gigsprice as $price){ ?>
                    <option value="<?php echo $price['Gigsprice']['price']; ?>">$<?php echo $price['Gigsprice']['price']; ?></option>
                    <?php }} ?>
                </select>
                             </div>
                             <div class="clear"></div><label>Description <span style="color:#F00">*</span> 
 </label>
                            <div class="in" style=" margin-left:165px; text-align:justify; font-size:11px">
                             <textarea   name="data[description]" rows="8" cols="50" class="text required" onKeyDown="limitDesc(250);" onKeyUp="limitDesc(250);" id="description" style="resize:none;" ></textarea>
                             <br /><font size="1">
You have <span id="desleft">250</span> characters left.</font>
                             <br /><br />Be as descriptive as possible.
Provide samples, what is required, what you will and will not do Define the extents of this gig - how many units, revisions, samples are included 
                             </div>
                            <div class="clear"></div><label>Keywords/Tags <span style="color:#F00">*</span>  
</label>
                            <div class="in" style=" margin-left:165px; font-size:11px"> <textarea  name="data[keywords_tags]" rows="6" cols="30" class="text required" id="keywords_tags"  style="resize:none;" onKeyUp="char_len(this.value);" onKeyDown="char_len(this.value);"  ></textarea>
                            <br /><span id="msg" style="color:#F00 ;font-size:11px"></span>
                            <br /><br />Enter keywords that best describe your gig.Example: social marketing,stickers
							</div>
               
                            <div class="clear"></div><label>No. Of Days <span style="color:#F00">*</span></label>
                            <div class="in" style=" margin-left:165px; text-align:justify; font-size:11px">
							<input name="data[max_days]"  class="text required" maxlength="2"  onchange="days(this.value)" id="txtNumber" onKeyUp="checkNumber(this.id);"  /><br />
                            
                            <span id="msg1" style="color:#F00"></span><br  /><br />The longest time it will take you to complete your work.<br /><br/>

<p>Consider:  time to accept the order, timezone differences, <br />the free time you have  for this work and correspondence<br /> with your buyers.</p><br /><br />

<p>Late deliveries are the #1 reason for order cancellations</p>
                            </div>

                            
                             <div class="clear"></div><label>Gig Image: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[image]" type="file" class="text required" accept="png|jpe?g|gif" />
                             </div>
                              </div>
                        <hr class="pagination-break" />
<input type="submit" class="broap" value="Save" id="save" onclick="return char_len(document.getElementById('keywords_tags').value);"/>
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
		if(str.length >4 || val.length > 50)
		{
					  document.getElementById('msg').innerHTML='Tag List Can Contain Upto 4 Tags Or 50 Characters .Example :"XXX,XXXX,XXXX"';

		document.getElementById('keywords_tags').value = document.getElementById('keywords_tags').value.substring(0,50);	
		  return false;  
		}
		else
		{
			document.getElementById('msg').innerHTML="";
			return true;
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
