<script type="text/javascript" src="/js/custom_function.js"></script>
            <div class="block-right">
            	<div class="sidebar-wrap">
                <div><!-- AddToAny BEGIN -->
<a class="a2a_dd" href="http://www.addtoany.com/share_save"><img src="http://static.addtoany.com/buttons/share_save_256_24.png" width="256" height="24" border="0" alt="Share"/></a>
<script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END --></div>
                <br />
                	<div class="sidebar-box">
                    	<div class="sidebar-top"></div>
                        <div class="sidebar-content">    
                            <div id="blog-search">
                           <form  method="post"  action="/gigs/searchgig" name="myForm" >
                                  <input type="text" value="" id="blog-s" name="data[search]" required="required" />
                     <input type="submit" id="blog-searchsubmit" />
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-bottom"></div>
                    </div>
                    
                    <div>
 <a href="http://www.facebook.com/pages/Fiverr-Cone/205543556154427" target="_blank"><img src="/images/facebook_find.png" title="find on facebook"/></a>
                    </div>
                                    <br />    <div>
 <a href="  http://twitter.com/#!/FiverrClone" target="_blank"><img src="/images/twit.png" title="find on twitter" /></a>
                    </div><br />
                    

                   <!--Categories List-->
                	<div class="sidebar-box">
                    	<div class="sidebar-top"></div>
                        <div class="sidebar-content" > 
                            <h3><b>Categories</b></h3>
                            <ul>
                            <?php foreach($listcategory as $Category){ ?>
                                <li>
<a href="/gigs/category/<?php echo $Category['Category']['id']; ?>" title="<?php if($Category['Category']['description']!=''){echo $Category['Category']['description'];} else {echo $Category['Category']['name'];}?>">
<font style="font-size:14px"><b><?php echo $Category['Category']['name']; ?></b></font></a></li>
                            <?php } ?>
                            </ul>
                        </div>
                        <div class="sidebar-bottom"></div>
                    </div>
                   <!--/Categories List-->
                      
                </div>
                <!--My Recommendation-->
                <?php if(!empty($myrecommendedlist)){?>
                                       <div class="sidebar-box">
                    	<div class="sidebar-top"></div>
                        <div class="sidebar-content"> 
                            <h3><b>My Recommendation</b></h3>
<table  border="0" cellpadding="0" cellspacing="0" >
 <tr>
   <td height="5"></td>
  </tr>
<?php foreach($myrecommendedlist as $key=>$value) {?>
  <tr>
    <td><?php echo $value['Recommend']['recommend']?> for $<?php echo $value['Recommend']['price']?></td>
  </tr>
    <tr>
    <td><b><a href="/users/removerecommended/<?php echo $value['Recommend']['id']?>" title="Remove Recommendation" onclick="return confirm('Are you sure you want to delete?')">Remove</a></b></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <?php }?>
    <tr>
   <td height="5"></td>
  </tr>
</table> </div>
                        <div class="sidebar-bottom"></div>
                    </div>  <?php }?>
                <!--/My Recommendation-->
                <!--Recommended form and List-->
                                       <div class="sidebar-box">
                    	<div class="sidebar-top"></div>
                        <div class="sidebar-content"> 
                        <form method="post" action="/users/recommended" class="wpsc_checkout_forms" id="recommended" name="recommended">
                            <h3><b>Recommended !</b></h3>
                            <div class="form">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>I want someone to do....</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><textarea cols="35" rows="3" name="data[recommend]" id="recommend"  class="text" onKeyDown="limitText(50);" 
onKeyUp="limitText(50);" style="resize:none;"  ></textarea><br /><font size="1">
You have <span id="countdown" >50</span> characters left.</font><br />
<div id="error1" style="color:red;"></div>

</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td><select name="data[price]" style="margin-left:12px;" id="price" >
                	<option selected="selected" value="">Price</option>
                    <?php if(isset($gigsprice)){foreach($gigsprice as $price){ ?>
                    <option value="<?php echo $price['Gigsprice']['price']; ?>">$<?php echo $price['Gigsprice']['price']; ?></option>
                    <?php }} ?>
                </select>
                <br /><div id="error2" style="color:red;"></div>
</td>
        <td width="50%" align="right"><input type="submit"  value="Recommend" class="recommend"  style="margin-right:15px;" onclick="return validate_recommend();"/></td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
  <?php
 $recommendlist=$this->requestAction('/users/recommendedlist/'.'5');
 
   if(!empty($recommendlist)){?>
      <tr>
    <td id="list"> 

<table  border="0" cellpadding="0" cellspacing="0" id="updates">
<?php foreach($recommendlist as $key=>$value) {?>
  <tr>
  <?php  
			$user_id=$this->Session->read('User.id');
			
			 ?>
    <td><b><a href="/users/compose/<?php echo $user_id ?>/<?php echo $value['Recommend']['id']?>" title="Contact to <?php echo $value['User']['username']?>">
	<?php
	 if(is_numeric($value['User']['username'])) {echo $value['User']['name']; }else {echo $value['User']['username']; }
	?></a> wants:</b></td>
  </tr>
  <tr>
    <td><?php echo $value['Recommend']['recommend']?> <strong>for $<?php echo $value['Recommend']['price']?></strong></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <?php }?>
  
  <tr id="morevideos-1">
                <td></td>
                <td colspan="2" align="center"><div  class="morevideos"><a href="#" class="loadmore" id="1" style="color:#000">More..</a></div></td></tr> 
<script language="javascript" type="text/javascript">loadMore();</script>
</table></td>
  </tr>
  <tr><td>
<!--   <div id="pager" align="center">
  <?php 
/*$paginator->options(array('update' => 'list','controller'=>'users','action'=>'recommendedlist'));    
	echo $paginator->prev(__('Prev', true), array('escape' => false), null, array('class'=>'disabled'));?><?php echo $paginator->numbers(array('separator'=>' '));?><?php echo $paginator->next(__('Next ', true), array(), null, array('class'=>'disabled')); */ ?>     
</div>
-->  <?php #echo $this->element('pagination'); //call pagination from element ?></td></tr>
  <?php }?><?php
#echo $this->element('paging', array('model' => 'User'));
?>
</table></div>
                            </form>
                        </div>
                        <div class="sidebar-bottom"></div>
                    </div>
                  <!--/Recommended form and List-->
            </div>
<!--<script> 
$("#recommended").validator({ 
	position: 'top left', 
	offset: [-5, 0],
	message: '<div><em/></div>' // em element is the arrow
});
</script>
-->
<script>
  jQuery(document).ready(function(){
			jQuery("#recommended").validate();
  });
 function validate_recommend()
 {
	 document.getElementById('error1').innerHTML="";
	 document.getElementById('error2').innerHTML="";
  var  flag=true;
   if(document.getElementById('recommend').value=="")
   {
	   document.getElementById('error1').innerHTML='Field is required !!';
	  flag=false;
   }
  
    if(document.getElementById('price').value=="")
   {
	   document.getElementById('error2').innerHTML='Field is required !!';
	   flag= false;
   }
  return flag;
  
 }
</script>


