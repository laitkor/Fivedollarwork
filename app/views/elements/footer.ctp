<?php
//////////////////////////////////////
// Create By : Nitin Kumar Shukla   // 
// Date : 14/04/2011                //
//////////////////////////////////////
?>
<?php ?><div id="footer" class="container">
    <div class="grid clearfix">
      <div class="footer-left" style="color: #000">
        &copy; <?php echo COPY_RIGHT_YEAR.'&nbsp;';?><a href="<?php echo SITE_URL;?>" title="<?php echo SITE_NAME;?>" style="color:#424a2a;"><b><?php echo SITE_NAME;?></b></a>
      </div>
      <div class="footer-right" style="color: #000">
        <b>General</b> | <b><?php echo $this->Html->link('Terms of Service', '/gigs/cms/2', array('title' => 'Terms of Service','style'=>'color:#424a2a;')); ?></b> | <b> <?php echo $this->Html->link("How It's Work", '/gigs/cms/1', array('title' => "How It's Work",'style'=>'color:#424a2a;')); ?> </b>| <b> <?php echo $this->Html->link('Customer Service', '/gigs/customerservice', array('title' => 'Customer Service','style'=>'color:#424a2a;')); ?> </b> | <b> <?php echo $this->Html->link('Help', '/gigs/cms/3', array('title' => 'Help','style'=>'color:#424a2a;'));?>
</b>        </div>
    </div>
</div>
