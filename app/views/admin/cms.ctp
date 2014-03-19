<?php $this->set('title_for_layout', 'Change Website Page Content'); ?>
<div id="box">
                	<h3>Change Website Page Content</h3>
<table width="100%">
						<thead>
							<tr>
                            	<th width="5%"><a href="#">Sr</a></th>
                            	<th  width="20%"><a href="#">CMS Name</a></th>
                                <th><a href="#">CMS Content</a></th>
                                <th width="10%"><a href="#">Action</a></th>
                            </tr>
						</thead>
						<tbody>
                        <?php $i=1; 
						foreach($content as $key=>$value) {?>
							<tr>
                            	<td class="a-center"><a><?php echo $i;?></a></td>
                            	<td><a><?php echo $value['Content']['name'];?></a></td>
                                <td><?php echo strip_tags(substr($value['Content']['content'], 0, 1000)); ?></td>
                                <td class="a-center"><a href="/admin/editcms/<?php echo $value['Content']['id'];?>" title="Edit <?php echo $value['Content']['name'];?> Page"><img src="/img/icons/page_white_edit.png" title="Edit Page Content" width="16" height="16" /></a></td>
                            </tr>
                            <?php $i++; }?>
						</tbody>
					</table></div>