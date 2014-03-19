<?php $this->set('title_for_layout', 'Gigs');?>
<div id="box">
                	<h3>Gigs</h3>
<form id="form" action="" method="post">
<table width="100%" align="center" border="1">
<tr align="center"><td id="box"><h3><?php echo $this->Paginator->sort('Id', 'Gig.id',array('title' =>'Sort by Id','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Gigs Title', 'Gig.title',array('title' =>'Sort by Gigs Title','escape' => false)); ?></h3></td><td id="box"><h3>Gigs Keyword</h3></td><td id="box"><h3><?php echo $this->Paginator->sort('Gigs By', 'User.username',array('title' =>'Sort by Gigs By','escape' => false)); ?></h3></td><td id="box"><h3>Gigs Description</h3></td><!--<td id="box"><h3>User Image</h3></td>--><td id="box"><h3>Click to Featured</h3></td><td id="box"><h3>Gigs For</h3></td><td id="box"><h3>Featured</h3></td><td id="box"><h3>Action</h3></td></tr>
<?php
$count=count($gig);

 foreach($gig as $allgig) { ?>
<tr><td><?php echo $allgig['Gig']['id'] ?></td>
<td><?php echo $allgig['Gig']['title'] ?></td>
<td><?php echo $allgig['Gig']['keywords_tags'] ?></td>
<td><?php
if(is_numeric($allgig['User']['username'])) {echo $allgig['User']['name']; }else {echo $allgig['User']['username'];}
 ?></td>
<td><?php echo $allgig['Gig']['description'] ?></td>
<!--<td><img src="/uploads/profile_img/
<?php if($allgig['User']['image']!=''){ echo $allgig['User']['image']; } else { ?>noimage.jpg <?php } ?>" width="80px" height="80px"/></td>-->
<td><a href="/admin/featured/<?php echo $allgig['Gig']['id'] ?>">Click to make featured</a></td>
<td>$<?php echo $allgig['Gig']['price'] ?></td>
<td><?php echo $allgig['Gig']['featured'] ?></td>
<td><a href="/admin/deletegig/<?php echo $allgig['Gig']['id'] ?>" onclick="return confirm('Are you sure you want to delete?')"> <img src="/img/icons/page_white_delete.png" title="delete" /></a>&nbsp;
</td></tr>

<?php } ?>
</table>
<div>Total <b><?php echo $count; ?></b> Records Found</div>
<?php echo $this->element('admin/pagination'); //call pagination from element ?>
</form>
</div>