   <script>
  FB.init({
    appId  : '212974112072342',
    status : true, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml  : true  // parse XFBML
  });
</script>
<div id="head">
        <div class="grid">
          
          <!--LOGO-->
<h1 id="logo"><a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>"><?php if($setting['Setting']['logo']!='' and $setting['Setting']['show_logo']=='1'){ ?><img src="/uploads/<?php echo $setting['Setting']['logo'];?>" alt="<?php echo SITE_NAME;?>"><?php } else { echo SITE_NAME;}?></a></h1>           <!--/LOGO-->
            <!--MENU-->
          <ul id="navigation">
            <li><a class="round<?php if($this->params['controller']=='gigs' && $this->params['action']=='index'){echo ' round-current';}?>" href="/" title="Home"><span>Home</span></a></li><li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
            <?php if(!$this->Session->check('User')){ ?>
            <li><a class="round<?php if($this->params['action']=='cms' && $this->params['pass'][0]==1){echo ' round-current';}?>" href="/gigs/cms/1" title="How It's Work"><span>How It's Work</span></a></li><li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
           <!-- <li><a class="round<?php if($this->params['action']=='register'){echo ' round-current';}?>" href="/users/register" title="Join"><span>Join</span></a></li>-->
                       <li><a class="round<?php if($this->params['action']=='cms' && $this->params['pass'][0]==3){echo ' round-current';}?>" href="/gigs/cms/3" title="Help"><span>Help</span></a></li><li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
            <li><a class="round<?php if($this->params['action']=='invite'){echo ' round-current';}?>" href="/gigs/invite" title="Invite Friends"><span>Invite Friends</span></a></li>
           <!--  <li><a class="round<?php if($this->params['action']=='signin'){echo ' round-current';}?>" href="/users/signin" title="Sign In"><span>Sign In</span></a></li>-->

            <?php } 
				  else
					{
						 ?>
            <li><a class="round<?php if($this->params['action']=='bookmarks'){echo ' round-current';}?>" href="/users/bookmarks" title="Stuff I Like"><span>Stuff I Like</span></a></li><li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
            <li><a class="round<?php if($this->params['action']=='profile'){echo ' round-current';}?>" href="/users/profile" title="Profile"><span>Profile</span></a></li><li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
            <li><a class="round<?php if($this->params['action']=='mygigs' or $this->params['action']=='addgigs' or $this->params['action']=='editgig'){echo ' round-current';}?>" href="/users/mygigs" title="My Gigs"><span>My Gigs</span></a></li><li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
            <li><a class="round<?php
			$count=$this->requestAction('/users/inbox');
			 if($this->params['action']=='inbox' or $this->params['action']=='sentitems'){echo ' round-current'; }?>" href="/users/inbox" title="Inbox"><span>Inbox<font style="font-size:10px; color:#FFF; font-weight:bold" > <?php if($count>0) { echo $count;	} ?></font></span></a></li>
             <li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
            <li><a class="round<?php if($this->params['action']=='work' or $this->params['action']=='editmanagework'){echo ' round-current';}?>" href="/users/work" title="Manage Work"><span>Manage Work</span></a></li><li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
             <li><a class="round<?php if($this->params['action']=='orders' or $this->params['action']=='editmanageorder' or $this->params['action']=='review'){echo ' round-current';}?>" href="/users/orders" title="Manage Orders"><span>Manage Orders</span></a></li>
             <li style="margin-top:5px;"><img src="/themes/blue/images/sprt.png" /></li>
            <li><a class="round<?php if($this->params['action']=='balance'){echo ' round-current';}?>" href="/users/balance" title="Balance"><span>Balance</span></a></li>
<!--            <li><a class="round" href="/users/signout" title="Sign Out"><span>Sign Out</span></a></li>-->
             <?php
			
			  }?>
          </ul>
           <!--/MENU-->
           
        </div>
        
      </div>
      
			

  <!-- <div id="fb-root"></div> -->
  
			