<?php
class FacebooksController extends AppController {
	var $user;

	/**
	 * Name: beforeFilter
	 * Desc: Performs necessary steps and function calls prior to executing
	 *       any view function calls.
	 */
	function beforeFilter() {
		$this->user = $this->facebook->require_login();
	}

	/**
	 * Name: index
	 * Desc: Display the friends index page.
	 */
	function index() {
		// Retrieve the user's friends and pass them to the view.
		$friends = $this->facebook->api_client->friends_get();
		$this->set('friends', $friends);
	}
}
?>