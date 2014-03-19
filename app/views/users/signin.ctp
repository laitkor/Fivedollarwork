<?php $this->set('title_for_layout', 'Sign In');?><h3 class="blog-title"><a href="#" title="Sign In">Sign In</a></h3>
                    <div class="blog-meta"></div>
                    <div class="blog-content">
                    <form method="post" action="/users/signin" class="wpsc_checkout_forms" id="signin">
                       <b> Fields marked with an asterisk must be filled in.</b>
                        <hr class="pagination-break" />
                        <div class="form" style="float:left; display:inline; width:340px;">
						<label style="font-size:19px; margin-top:30px">Username: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[username]" value="" class="text required" type="text"  maxlength="50" pattern="[a-zA-Z]{3}[a-zA-Z0-9]{3,}" minlength="6" style="width:290px; height:40px; font-size:1.5em" onfocus="bkgcolor(this.id,1);" id="name" />
                             </div>
                             <div class="clear"></div><label style="font-size:19px; margin-top:30px">Password: <span style="color:#F00">*</span></label>
                            <div class="in">
                             <input name="data[password]" type="password" minlength="6"  value="" class="text required" maxlength="50" style="width:290px; height:40px; font-size:1.5em" id="password" onfocus="bkgcolor(this.id);"/>
                             </div>
                           
 <br /> <input type="submit" class="broap" value="Submit"/>
                 
                    <p><br/><a href="/users/forgot/1" title="Forgot Your Username?"><strong>Forgot Your Username?</strong></a><br/><a href="/users/forgot/2" title="Forgot Your Password?"><strong>Forgot Your Password?</strong></a></p>                           </div>
                         
<!--<div  style="float:left; width:1px; height:250px; background-color:#999; margin-top:20px;"><BR></div>
 <div  style="display:inline; width:205px; margin-top:10px; float:right">
 <table>
 <tr style="line-height:20px;"><td ><span style="font-family:Tahoma, Geneva, sans-serif; font-weight:bold">You Can Also Login With Your Facebook Or Twitter Account</span></td></tr>
 <tr style="line-height:20px;"><td>
 <br /><a href="/users/fb_authorize" ><img src="/img/fconnect.png" border="0" alt="FB_Connect" align="top" onmouseover="this.src='/img/fconnect1.png'" 
onmouseout="this.src='/img/fconnect.png'"/></a><br /><br /><span style="color:#000; font-size:22px; font-weight:bold; margin-left:90px;">OR</span><br /><br />
<a href="/users/tw_authorize"><img src="/img/tconnect.png" border="0" alt="T_Connect" align="top" onmouseover="this.src='/img/tconnect1.png'" 
onmouseout="this.src='/img/tconnect.png'"/></a></td></tr>
</table>

                             
 </div>-->

                            
                        <hr class="pagination-break" />   </form>

</div>
<script>
  jQuery(document).ready(function(){
			jQuery("#signin").validate();
  });
  
  function bkgcolor(id)
  {
	if(id=='name')
	{
    document.getElementById('name').style.background="#D5FDFD";
	document.getElementById('password').style.background="#ffffff";
	}
	if(id=='password')
	{
    document.getElementById('password').style.background="#D5FDFD";
	document.getElementById('name').style.background="#ffffff";
	}
  }
</script>
