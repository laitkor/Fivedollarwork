<?php
class User extends AppModel {

var $name = 'User';

/**
	* (Sample) Model for Showing the use of Captcha*
	* @author     Arvind K. 
	* @link       http://www.devarticles.in/
	* @copyright  Copyright © 2008 www.devarticles.in
	* @version Tested ok in Cakephp 1.2 & 1.3
	* Site URL http://www.devarticles.in/cakephp/simple-captcha-component-for-cakephp-new/
	*/
	var $captcha = ''; //intializing captcha var

	var $validate = array(
			'captcha'=>array(
				'rule' => array('matchCaptcha')
			)
		);

	function matchCaptcha($inputValue)	{
		return $inputValue['captcha']==$this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha
	}

	function setCaptcha($value)	{
		$this->captcha = $value; //setting captcha value
	}

	function getCaptcha()	{
		return $this->captcha; //getting captcha value
	}
	 	
}

?>
