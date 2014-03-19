
 <div id="pager" align="center"><table width="60%" border="0">
  <tr>
    <td><?php     
	/*echo $paginator->prev(__('Prev', true), array('escape' => false), null, array('class'=>'disabled'));*/
	echo $paginator->prev($html->image('previous.png'), array('escape' => false),array(), null, array('class'=>'disabled'));
	?></td>
    <td><?php echo $paginator->numbers(array('separator'=>' ',style=>'width:51px;height:31px;'));?></td>
    <td><?php #echo $paginator->next(__('Next',true), null,array(), array('class'=>'disabled after'));
	//$paginator->next($html->image('next.png', array('alt' => __('next', true), 'border' => 0), array('escape' => false)));
	echo $paginator->next($html->image('next.png'), array('escape' => false),array(), null, array('class'=>'disabled'));

	?>     </td>
  </tr>
</table>

  
	
	
 </div> 
                    

