<?php
define('OAUTH_CALLBACK','http://clone.stpi.com/twitter');
require_once('twitteroauth/twitteroauth.php');
/* Application Details */

$connection = new TwitterOAuth("z5dxI5ypcifv8lcqy6Kiw","rsRPdXtSg55yebo071rwmkd8QswWSeLlqE9mTk");

/* Get temporary credentials. */
$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

/* Save temporary credentials to session. */
$token = $request_token['oauth_token'];
$secret= $request_token['oauth_token_secret'];

 /* If last connection failed don't display authorization link. */
switch ($connection->http_code)
{
case 200:
/* Build authorize URL and redirect user to Twitter. */
   $url = $connection->getAuthorizeURL($token);
   echo"<a href='". $url."'>Login With Twitter </a>";
   break;

default:
/* Show notification if something went wrong. */
   echo 'Could not connect to Twitter. Refresh the page or try again later.';
 }

?>