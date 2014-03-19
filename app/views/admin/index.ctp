<?php $this->set('title_for_layout', 'Users');?>
<div id="box">
                	<h3>Users</h3>
<form id="form" action="index" method="post">
<table width="100%" align="center" border="1">
<tr align="center"><td id="box"><h3><?php echo $this->Paginator->sort('Id','User.id',array('title' =>'Sort by Id','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Full Name','User.name',array('title' =>'Sort by Full Name','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Email','User.email',array('title' =>'Sort by Email','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Username','User.username',array('title' =>'Sort by Username','escape' => false)); ?></h3></td><td id="box"><h3>User Description</h3></td><td id="box"><h3>User Image</h3></td><td id="box"><h3>Action</h3></td></tr>
<?php
$count=count($user);

 foreach($user as $allusers) { ?>
<tr><td><?php echo $allusers['User']['id'] ?></td>
<td><?php echo $allusers['User']['name'] ?></td>
<td><?php echo $allusers['User']['email'] ?></td>
<td><?php 
if(is_numeric($allusers['User']['username'])) {echo $allusers['User']['name']; }else {echo $allusers['User']['username'];}
?></td>
<td><?php echo $allusers['User']['description'] ?></td>
<td><img src="/uploads/profile_img/
<?php if($allusers['User']['image']!=''){ echo $allusers['User']['image']; } else { ?>noimage.jpg <?php } ?>" width="80px" height="80px"/></td>
<td><a href="/admin/deleteuser/<?php echo $allusers['User']['id'] ?>" onclick="return confirm('Are you sure you want to delete?')"> <img src="/img/icons/user_delete.png" title="delete user" /></a>&nbsp;
<a href="/admin/status/<?php echo $allusers['User']['status']?>/<?php echo $allusers['User']['id'] ?>"><?php
if($allusers['User']['status']=='Active')
{?>
Active
<?php }
else { ?> Inactive <?php } ?>
	
 </a></td></tr>

<?php } ?>
</table>
<div>Total <b><?php echo $count; ?></b> Records Found</div>
<?php echo $this->element('admin/pagination'); //call pagination from element ?>
</form>
</div>