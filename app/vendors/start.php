<?php
include 'epi_curl.php';
include 'epi_o_auth.php';
include 'epi_twitter.php';
include 'secret.php';

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

echo '<a href="' . $twitterObj->getAuthorizationUrl() . '">Add Twitter account</a>';
?>

