<?php
class Withdraw extends AppModel
{
	var $name = 'Withdraw';    	
	var $belongsTo = array(
						'User' => array(
							'className'    => 'User',
							'foreignKey'    => 'user_id',
							)); 
}
?>