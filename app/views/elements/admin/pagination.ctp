 <div id="pager" align="center">
  <?php     
	echo $paginator->prev(__('Prev', true), array('escape' => false), null, array('class'=>'disabled'));?><?php echo $paginator->numbers(array('separator'=>' '));?><?php echo $paginator->next(__('Next ', true), array(), null, array('class'=>'disabled'));?>     
 </div></div> 
                    

