<?php
/*************************************************
APIError.php

Displays error parameters.

Called by DoDirectPaymentReceipt.php, TransactionDetails.php,
GetExpressCheckoutDetails.php and DoExpressCheckoutPayment.php.

*************************************************/

$resArray=$this->Session->read('reshash');
print_r($resArray);
?>

<html>
<head>
<title>PayPal API Error</title>
<link href="sdk.css" rel="stylesheet" type="text/css"/>
</head>

<body alink=#0000FF vlink=#0000FF>

<center>

<table width="280">
<tr>
		<td colspan="2" class="header">The PayPal API has returned an error!</td>
	</tr>

<?php  //it will print if any URL errors 
	if($this->Session->check('curl_error_no') ) { 
			$errorCode= $this->Session->read('curl_error_no');
			$errorMessage=$this->Session->read('curl_error_msg');	
			$this->Session->delete('curl_error_no');	
			$this->Session->delete('curl_error_msg');
?>

   
<tr>
		<td>Error Number:</td>
		<td><?php echo $errorCode; ?></td>
	</tr>
	<tr>
		<td>Error Message:</td>
		<td><?php echo $errorMessage; ?></td>
	</tr>
	
	</center>
	</table>
<?php } else {

/* If there is no URL Errors, Construct the HTML page with 
   Response Error parameters.   
   */
?>

<center>
	<font size=2 color=black face=Verdana><b></b></font>
	<br><br>

	<b> PayPal API Error</b><br><br>
	
  <table class="api" width=400>
	        	<?php 
    		foreach($resArray as $key => $value) {
    			
    			echo "<tr><td> $key:</td><td>$value</td>";
    			}	
       			?>
  </table>
    </center>		
	
<?php 
}// end else
?>
</center>
	</table>
<br>
<a class="home"  id="CallsLink" href="index.html"><font color=blue><B>Home<B><font></a>
</body>
</html>