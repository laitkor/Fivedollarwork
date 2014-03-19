<?php
	include("IXR_Library.php");
	$client = new IXR_Client('http://nitin.0fees.net/xmlrpc.php');

	if (!$client->query('wp.getCategories','', 'admin','nitin123')) {
		die('An error occurred - '.$client->getErrorCode().":".$client->getErrorMessage());
	}
	$response = $client->getResponse();
	print_r($response);
	$content['title'] = 'Test Draft Entry using MetaWeblog API';
	$content['categories'] = array($response[1]['categoryName']);
	$content['description'] = '<p>Test the post other site!</p>';
	if (!$client->query('metaWeblog.newPost','', 'admin','nitin123', $content, false)) {
		die('An error occurred - '.$client->getErrorCode().":".$client->getErrorMessage());
	}
	echo $client->getResponse();    //with Wordpress, will report the ID of the new post
?>