<?php $this->set('title_for_layout', 'Recommend');?>
<div id="box">
                	<h3>Recommend</h3>
<form id="form" action="index" method="post">
<table width="100%" align="center" border="1">
<tr align="center"><td id="box"><h3><?php echo $this->Paginator->sort('Id', 'Recommend.id',array('title' =>'Sort by Id','escape' => false)); ?></h3></td><td id="box"><h3>Gigs Recommend</h3></td><td id="box"><h3>
<?php echo $this->Paginator->sort('Gigs Recommend By', 'User.username',array('title' =>'Sort by Gigs Recommend By','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Gigs For', 'Recommend.price',array('title' =>'Sort by Gigs For','escape' => false)); ?></h3></td><td id="box"><h3>Action</h3></td></tr>
<?php
$count=count($recommend);

 foreach($recommend as $recomm) { ?>
<tr><td><?php echo $recomm['Recommend']['id'] ?></td>
<td width="40%"><?php echo $recomm['Recommend']['recommend'] ?></td>
<td><?php echo $recomm['User']['username'] ?></td>
<td>$<?php echo $recomm['Recommend']['price'] ?></td>
<td><a href="/admin/delrecommend/<?php echo $recomm['Recommend']['id'] ?>" onclick="return confirm('Are you sure you want to delete?')"> <img src="/img/icons/page_white_delete.png" title="delete" /></a>&nbsp;
</td></tr>

<?php } ?>
</table>
<div>Total <b><?php echo $count; ?></b> Records Found</div>
<?php echo $this->element('admin/pagination'); //call pagination from element ?>
</form>
</div>