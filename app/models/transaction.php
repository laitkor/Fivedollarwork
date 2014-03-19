<?php
class Transaction extends AppModel
{
	var $name = 'Transaction';    	
	var $belongsTo = array(
						'Order' => array(
							'className'    => 'Order',
							'foreignKey'    => 'order_id',
							),
						'Gig' => array(
							'className'    => 'Gig',
							'foreignKey'    => 'gig_id',
							)); 
}
?>