<?php $this->set('title_for_layout', 'Withdraw Request');?>
<div id="box"><h3>Withdraw Request</h3>
<table width="100%" align="center" border="1">
<tr align="center">
<td id="box"><h3><?php echo $this->Paginator->sort('Username', 'User.username',array('title' =>'Sort by Username','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Amount', 'Withdraw.amount',array('title' =>'Sort by Amount','escape' => false)); ?></h3></td>
<td id="box"><h3>Request Date</h3></td>
<td id="box"><h3>Action</h3></td></tr>
<?php
$count=count($Withdraw);
 foreach($Withdraw as $withdraw) { ?>
<tr>
<td><?php echo $withdraw['User']['username']; ?></td>
<td><?php echo $withdraw['Withdraw']['amount'];?></td>
<td><?php echo $withdraw['Withdraw']['request_datetime']; ?></td>
<td align="center"><a href="/admin/payout/<?php echo $withdraw['Withdraw']['id']; ?>"
 onclick="return confirm('Are you sure you want to pay?')">Pay $<?php echo $withdraw['Withdraw']['amount'];?></a>&nbsp;
</td></tr>
<?php } ?>
</table>
<div>Total <b><?php echo $count; ?></b> Records Found</div>
<?php echo $this->element('admin/pagination'); //call pagination from element ?>
</div>