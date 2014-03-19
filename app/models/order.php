<?php
class Order extends AppModel
{
	var $name = 'Order';    	
	var $belongsTo = array(
	'Gig' => array(
            'className'    => 'Gig',
            'foreignKey'    => 'gig_id'
        ),
		'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        ),
		'Seller' =>array(
		'className' =>'User',
		'foreignKey'    => 'seller_id'
		)			
		); 
	
}
?>