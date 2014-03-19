<?php
class Gig extends AppModel {
    var $name = 'Gig';
	var $belongsTo = array(
		'Category' => array(
            'className'    => 'Category',
            'foreignKey'    => 'category_id'
        ),
		'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        )	
		); 
}
?>
