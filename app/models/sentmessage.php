<?php
class Sentmessage extends AppModel {
    var $name = 'Sentmessage';
	var $belongsTo = array(
		'Gig' => array(
            'className'    => 'Gig',
            'foreignKey'    => 'gigs_id'
        ),
		'User' => array(
            'className'    => 'User',
            
			'foreignKey' => 'sender_id'
        )	,
		'FUser' => array(
            'className'    => 'User',
            
			'foreignKey' => 'reciever_id'
        )			
		); 
}

?>
