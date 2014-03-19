<?php
class Like extends AppModel {
    var $name = 'Like';
	var $belongsTo = array(
		'Gig' => array(
            'className'    => 'Gig',
            'foreignKey'    => 'gig_id'
        ),
		'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        )	
		); 
}

?>
