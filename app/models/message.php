<?php
class Message extends AppModel {
    var $name = 'Message';
	var $belongsTo = array(
		'Gig' => array(
            'className'    => 'Gig',
            'foreignKey'    => 'gigs_id'
        ),
		'User' => array(
            'className'    => 'User',
            
			'foreignKey' => 'to_users_id'
        )	,
		'FUser' => array(
            'className'    => 'User',
            
			'foreignKey' => 'from_users_id'
        )
		
				
		); 
		var $hasMany=array(
		
		'Reply' => array(
            'className'    => 'Reply',
            
			'foreignKey' => 'message_id',
			'order'  => 'Reply.date DESC'
			
        )	
		)
		;
}

?>
