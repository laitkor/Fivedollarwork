<?php
class Review extends AppModel {
    var $name = 'Review';
	var $belongsTo = array(
		'Order' => array(
            'className'    => 'Order',
            'foreignKey'    => 'order_id'
        )
					
		); 
}

?>
