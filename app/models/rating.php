<?php
class Rating extends AppModel {
    var $name = 'Rating';
	var $belongsTo = array(
		'Gig' => array(
            'className'    => 'Gig',
            'foreignKey'    => 'gig_id'
        ),
		'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'giguserid'
        )	
		); 
}

?>
