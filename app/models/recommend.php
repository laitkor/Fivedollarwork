<?php
class Recommend extends AppModel {
    var $name = 'Recommend';
	var $belongsTo = array(
		'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        )			
		); 
}

?>
