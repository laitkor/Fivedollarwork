<?php $this->set('title_for_layout', 'Admin Users');?>
<div id="box">
                	<h3>Admin Users</h3>
<form id="form" action="index" method="post">
<table width="100%" align="center" border="1">
<tr align="center"><td id="box"><h3>Id</h3></td><td id="box"><h3>Full Name</h3></td><td id="box"><h3>Email</h3></td><td id="box"><h3>Username</h3></td></tr>
<?php
$count=count($user);
 foreach($user as $allusers) { ?>
<tr><td><?php echo $allusers['User']['id'] ?></td>
<td><?php echo $allusers['User']['name'] ?></td>
<td><?php echo $allusers['User']['email'] ?></td>
<td><?php echo $allusers['User']['username'] ?></td>
</tr>

<?php } ?>

</table>
<div>Total <b><?php echo $count; ?></b> Records Found</div>
</form>
</div>