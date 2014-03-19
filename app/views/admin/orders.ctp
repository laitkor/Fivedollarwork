<?php $this->set('title_for_layout', 'Orders');?>
<div id="box">
                	<h3>Orders</h3>
<form id="form" action="index" method="post">
<table width="100%" align="center" border="1">
<tr align="center">
<td id="box"><h3><?php echo $this->Paginator->sort('Id', 'Order.id',array('title' =>'Sort by Id','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Date', 'Order.datetime',array('title' =>'Sort by Date','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Order Item', 'Gig.title',array('title' =>'Sort by Order Item','escape' => false)); ?></h3></td>

<td id="box"><h3><?php echo $this->Paginator->sort('User Name', 'User.name',array('title' =>'Sort by User Name','escape' => false)); ?></h3></td>

<td id="box"><h3>Status</h3></td>
<td id="box"><h3>Action</h3></td></tr>
<?php
$count=count($orders);

 foreach($orders as $allcat) { ?>
<tr>
<td><?php echo $allcat['Order']['id'] ?></td>
<td><?php echo $allcat['Order']['datetime'] ?></td>
<td><?php echo $allcat['Gig']['title'] ?></td>
<td><?php echo $allcat['User']['username'] ?></td>
<td><?php echo $allcat['Order']['status'] ?></td>

<td><a href="deleteorder/<?php echo $allcat['Order']['id'] ?>"
 onclick="return confirm('Are you sure you want to delete?')">
 <img src="/img/icons/page_white_delete.png" title="delete" /></a>&nbsp;
</td></tr>

<?php } ?>
</table>
<div>Total <b><?php echo $count; ?></b> Records Found</div>
<?php echo $this->element('admin/pagination'); //call pagination from element ?>
</form>
</div>