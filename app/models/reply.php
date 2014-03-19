<?php
class Reply extends AppModel {
    var $name = 'Reply';
	var $belongsTo = array(
		
			'Message' => array(
            'className'    => 'Message',
            
			'foreignKey' => 'message_id'
        )	
		); 
}

?>
