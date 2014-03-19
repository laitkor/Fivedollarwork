<?php $this->set('title_for_layout', 'Category');?>
<div id="box">
                	<h3>Category</h3>
<form id="form" action="index" method="post">
<table width="100%" align="center" border="1">
<tr align="center"><td id="box"><h3><?php echo $this->Paginator->sort('Id', 'Category.id',array('title' =>'Sort by Id','escape' => false)); ?></h3></td>
<td id="box"><h3><?php echo $this->Paginator->sort('Category Name', 'Category.name',array('title' =>'Sort by name','escape' => false)); ?></h3></td>
<td id="box"><h3>Category Description</h3></td>
<td id="box"><h3>Category Status</h3></td>
<td id="box"><h3>Action</h3></td></tr>
<?php
$count=count($category);

 foreach($category as $allcat) { ?>
<tr><td><?php echo $allcat['Category']['id'] ?></td>
<td><?php echo $allcat['Category']['name'] ?></td>
<td><?php echo $allcat['Category']['description'] ?></td>
<td><?php echo $allcat['Category']['status'] ?></td>
<td><a href="/admin/editcat/<?php echo $allcat['Category']['id'] ?>" > <img src="/img/icons/page_white_edit.png" title="edit" /></a>&nbsp;
<a href="/admin/deletecat/<?php echo $allcat['Category']['id'] ?>"
 onclick="return confirm('Are you sure you want to delete?')">
 <img src="/img/icons/page_white_delete.png" title="delete" /></a>&nbsp;
</td></tr>

<?php } ?>
</table>
<div>Total <b><?php echo $count; ?></b> Records Found</div>
<?php echo $this->element('admin/pagination'); //call pagination from element ?>
</form>
</div>