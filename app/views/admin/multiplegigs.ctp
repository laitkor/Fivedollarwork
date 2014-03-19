<?php $this->set('title_for_layout', 'Multiple Gigs Price');?>
<div id="box">
                	<h3>Multiple Gigs Price</h3>
<form id="form" action="index" method="post">
<table width="100%" align="center" border="1">
<tr align="center"><td id="box"><h3><?php echo $this->Paginator->sort('Id', 'Gigsprice.id',array('title' =>'Sort by Id','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Multiple Gigs Price', 'Gigsprice.price',array('title' =>'Sort by Multiple Gigs Price','escape' => false)); ?></h3></td><td id="box"><h3>Action</h3></td></tr>
<?php
$count=count($gigprice);

 foreach($gigprice as $gp) { ?>
<tr><td><?php echo $gp['Gigsprice']['id'] ?></td>
<td>$<?php echo $gp['Gigsprice']['price'] ?></td>
<td><a href="/admin/delgigprice/<?php echo $gp['Gigsprice']['id'] ?>" onclick="return confirm('Are you sure you want to delete?')"> <img src="/img/icons/page_white_delete.png" title="delete" /></a>&nbsp;
</td></tr>

<?php } ?>
</table>
<div>Total <b><?php echo $count; ?></b> Records Found</div>
<?php echo $this->element('admin/pagination'); //call pagination from element ?>
</form>
</div>