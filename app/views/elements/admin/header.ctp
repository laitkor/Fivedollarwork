<?php
//////////////////////////////////////
// Create By : Nitin Kumar Shukla   // 
// Date : 28/04/2011                //
//////////////////////////////////////
?>	 	<div id="header">
       <?php if($setting['Setting']['logo']!='' and $setting['Setting']['show_logo']=='1'){ ?><div class="logo"><a href="/" title="<?php echo SITE_NAME;?>" target="_blank"><img src="/uploads/<?php echo $setting['Setting']['logo'];?>" alt="<?php echo SITE_NAME;?>" style="height:45px;"></a></div><h2>&nbsp;</h2><?php } else { ?><a href="/" title="<?php echo SITE_NAME;?>" target="_blank"><h2><?php echo SITE_NAME;?></h2></a><?php }?>
    <div id="topmenu">
            	<ul>
                	<li <?php if($this->params['action']=='index'){echo 'class="current"';}?> ><a href="/admin/index" title="All Users">All Users</a></li>
                    <li <?php if($this->params['action']=='orders'){echo 'class="current"';}?> ><a href="/admin/orders" title="Orders">Orders</a></li>
                    <li <?php if($this->params['action']=='transaction'){echo 'class="current"';}?> ><a href="/admin/transaction" title="Transaction">Transaction</a></li>
                    <li <?php if($this->params['action']=='gigs'){echo 'class="current"';}?> ><a href="/admin/gigs" title="Gigs">Gigs</a></li>
                    <li <?php if($this->params['action']=='recommend'){echo 'class="current"';}?> ><a href="/admin/recommend" title="Recommend">Recommend</a></li>
                    <li <?php if($this->params['action']=='multiplegigs' or $this->params['action']=='addmultiplegigs'){echo 'class="current"'; $setsubmenu=1;}?> ><a href="/admin/multiplegigs" title="Multiple Gigs">Multiple Gigs</a></li>
                    <li <?php if($this->params['action']=='category' or $this->params['action']=='addcategory'){echo 'class="current"'; $setsubmenu=2;}?> ><a href="/admin/category" title="Category">Category</a></li>
                    <li <?php if($this->params['action']=='changepassword' or $this->params['action']=='changetitle' or $this->params['action']=='commission' or $this->params['action']=='changelogo' or $this->params['action']=='paypalid' or $this->params['action']=='cms'  or $this->params['action']=='editcms' or $this->params['action']=='adminusers'){echo 'class="current"';  $setsubmenu=3;}?> ><a href="/admin/changepassword" title="Setting">Setting</a></li>
                    <li><a href="/admin/signout" title="Logout">Logout</a></li>
              </ul>
          </div>
      </div>
        <div id="top-panel">
            <div id="panel">
           <?php if(isset($setsubmenu)) {?>
                <ul>
                 <?php if($setsubmenu==1) {?>
                
                    <li><a href="/admin/multiplegigs" class="search" title="Show All">Show All</a></li>
                    <li><a href="/admin/addmultiplegigs" class="add" title="Add New">Add New</a></li>
                     <?php } ?>
                     <?php if($setsubmenu==2) {?>
                
                    <li><a href="/admin/category" class="folder_table" title="Show All">Show All</a></li>
                    <li><a href="/admin/addcategory" class="addorder" title="Add New">Add New</a></li>
                     <?php } ?>
                     <?php if($setsubmenu==3) {?>
                
                    <li><a href="/admin/changepassword" class="changepassword" title="Change Password">Change Password</a></li>
                    <li><a href="/admin/changetitle" class="manage_page" title="Change Title">Change Title</a></li>
                    <li><a href="/admin/changelogo" class="online" title="Change Logo">Change Logo</a></li>
                    <li><a href="/admin/cms" class="pageedit" title="CMS">CMS</a></li>
  					<li><a href="/admin/adminusers" class="group" title="Admin Users">Admin Users</a></li>
                    <li><a href="/admin/paypalid" class="invoices" title="Payment API">Payment API</a></li>
                    <li><a href="/admin/commission" class="modules_manage" title="Commission Percentage">Commission Percentage</a></li>

                     <?php } ?>

                </ul>
                <?php }?>
            </div>
      </div>