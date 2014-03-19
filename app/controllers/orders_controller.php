<?php
//////////////////////////////////////
// Create By : Nitin Kumar Shukla   // 
// Date : 25/05/2011                //
// Handles Payments					//
//	1- Paypal						//
//	2- Authorize.net				//
//////////////////////////////////////

class OrdersController extends AppController
{
	var $name = 'Orders';
	var $helpers = array('Html', 'Form', 'Javascript','Session','Ajax');
	var $components = array('Session', 'Email','Captcha','RequestHandler');
	var $uses = array('User','Transaction','Gig','Order','Account');
		//make payment using authorize.net or Paypal
			function beforeFilter() 
        { 
                parent::beforeFilter(); // call the AppController::beforeFilter() 
				$this->paymentsetting();
 		} 
 
 	########  PAYMENT SETTING #######
	 public function paymentsetting(){
		$setting=$this->Setting->find('first',array('conditions' =>array('Setting.id' => '1')));
		//PAYMENT SETTING
		//AUTHORIZE.NET
		define("AUTHORIZENET_API_LOGIN_ID", $setting['Setting']['authorizenet_login']);
		define("AUTHORIZENET_TRANSACTION_KEY", $setting['Setting']['authorizenet_key']);
		//for live URLS enable below and uncommnet last one.
		define("AUTHORIZENET_SANDBOX", false);
		//define("AUTHORIZENET_SANDBOX",true);
		
		//PAYPAL
		/*define("PAYPAL_USERNAME","sdk-three_api1.sdk.com");
		define("PAYPAL_PASSWORD","QFZCWN5HZM8VBG7Q");
		define("PAYPAL_SIGNATURE","A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI");
		*/
		define("API_USERNAME",$setting['Setting']['paypal_username']);
		define("API_PASSWORD",$setting['Setting']['paypal_password']);
		define("API_SIGNATURE",$setting['Setting']['paypal_signature']);
		//for live URLS enable below and uncommnet last one.
		// When Use Sanbox
		//define("API_ENDPOINT",'https://api-3t.sandbox.paypal.com/nvp');
		// When Live
		define("API_ENDPOINT",'https://api-3t.paypal.com/nvp');

		
		// When Use Sanbox
		//define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');
		// When Live
		define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');

		/**
		# Version: this is the API version in the request.
		# It is a mandatory parameter for each API request.
		# The only supported value at this time is 2.3
		*/
		
		define('VERSION', '65.1');
		
		// Ack related constants
		define('ACK_SUCCESS', 'SUCCESS');
		define('ACK_SUCCESS_WITH_WARNING', 'SUCCESSWITHWARNING');

		define("COMMISSION_PERCENT",$setting['Setting']['commission_percent']);
	 }
 
	########  Order Page #######
	function index($id=NULL){		
		//check if user is logged  in 
		$this->checkSession();
		$work=$this->Gig->findbyId($id);
		if(empty($work))
		{
		$this->Session->setFlash("Invalid Order Request!");
		$this->redirect('/');	
		}
		else{
		$amount=((COMMISSION_PERCENT*$work['Gig']['price'])/100)+$work['Gig']['price'];
		$bal=$this->Account->findbyUser_id($this->Session->read('User.id'));
		if(!empty($bal) && $amount<=$bal['Account']['available_funds'])
		{
			$this->Set('Gig',$work);
			$account_arr=array(
				'id'=>$bal['Account']['id'],
				'available_funds'=>($bal['Account']['available_funds']-$amount),
				'purchases_funds'=>($bal['Account']['purchases_funds']+$amount),
			);
			if($this->Account->save($account_arr))
			{
				$decline="Your payment has been declined.";
				$orders_insert= array(
				  'gig_id'=>$work['Gig']['id'],
				  'user_id'=>$this->Session->read('User.id'),
				  'seller_id'=>$work['Gig']['user_id'],							
				  'datetime'=>date('Y-m-d H:i:s',time()),
				  'status'=>'Pending'
				  );	
		// add Seller account Awaiting Funds 		  
		$seller_account=$this->Account->findbyUser_id($work['Gig']['user_id']);
		$seller_account_arr=array(
				'id'=>$seller_account['Account']['id'],
				'awaiting_funds'=>($seller_account['Account']['awaiting_funds']+$work['Gig']['price']),
				);
				$this->Account->save($seller_account_arr);

				  
			  $transaction_id="CAL".uniqid();					
			  if($this->Order->save($orders_insert))
			  {
			  $Order_id = $this->Order->getLastInsertId(); 
			  $response=array(
			  'user_id'=>$this->Session->read('User.id'),
			  'user_name'=>$this->Session->read('User.name'),
 			  'user_email'=>$this->Session->read('User.email'),
			  'order_id'=>$Order_id,
			  'order_title'=>$work['Gig']['title'],
			  'order_description'=>$work['Gig']['description'],
			  'order_qty'=>'1',
			  'order_price'=>$work['Gig']['price'],
			  'order_commission'=>((COMMISSION_PERCENT*$work['Gig']['price'])/100),
			  'order_total'=>$amount,
			  'CURRENCYCODE'=>'USD',
			  'COMMISSION_PERCENT'=>COMMISSION_PERCENT,
			  'INVNUM'=>$Order_id,
			  'transaction_id'=>$transaction_id,
			  'payment_methods'=>'Balance',
			  'TIMESTAMP'=>date('Y-m-d H:i:s',time()),
			  );
			  $transaction_insert= array(
			  'user_id'=>$this->Session->read('User.id'),
			  'receiver_id'=>'Admin',
			  'order_id'=>$Order_id,
			  'gig_id'=>$work['Gig']['id'],
			  'payment_methods'=>'Balance',
			  'amount'=>$amount,
			  'returned_data'=>serialize($response),
			  'transaction_id'=>$transaction_id,
			  'transaction_date'=>date('Y-m-d H:i:s',time()),
			  'status'=>'Success',
			  );	
			  	
			  if($this->Transaction->save($transaction_insert))
			  {
			  $Tran_id = $this->Transaction->getLastInsertId();
			  $transactionData=$this->Transaction->findbyId($Tran_id);
			  $this->set('Transaction', $transactionData);
			  
			  //work transaction_id
			  $subject='Transaction Details : '.$transaction_id.' from '.SITE_URL;
			  $this->_sendUserMail('',$subject,'success',$this->Session->read('User.email'),'Y');
			  $this->_sendUserMail('',$subject,'success',$work['User']['email'],'N');
			  $this->Session->setFlash('Payment made succesfully.');
			  $this->redirect('/');
			  }
			  else
			  {
			  $subject='Transaction Decline from '.SITE_URL;
			  $this->_sendUserMail('',$subject,'decline',$this->Session->read('User.email'),'Y');
			  $this->Session->setFlash($decline);
			  $this->redirect('/orders/index/'.$id);
			  }
			  }
			  else
			  {
			  $subject='Transaction Decline from '.SITE_URL;
			  $this->_sendUserMail('',$subject,'decline',$this->Session->read('User.email'),'Y');
			  $this->Session->setFlash($decline);
			  $this->redirect('/orders/index/'.$id);
			  }				
			}
			else
			{
				$this->Set('work',$work);
			}
			
		}
		else
		{
			$this->Set('work',$work);
		}
		}
	}//end index function

	########  Payment Process #######
	function paymentProcess($id=NULL)
	{
		//check if user is logged  in 
		$this->checkSession();
		if(!empty($this->data))
		{
		if(isset($id) && !empty($id))
		{
			// Paypal Payment Process
			if($this->data['mode']=='P')
			{
				$this->paypal($id);
				$this->redirect('/orders/index/'.$id);
			}
			
			// Authorize.Net Payment Process
			if($this->data['mode']=='A')
			{
				if(!$this->_validateFields($this->data)){
					$this->Session->setFlash("Please enter valid credit card.");		
					$noerror =0;
					$this->redirect('/orders/index/'.$id);
				}
				else
				{
					$noerror =1;
				}
				if($noerror){
				 $response=$this->authorizenet($id);
				 if($response->approved)
				 {
					$this->ordersData($response, $id);
				 }
				 else
				 {
					 $this->Session->setFlash($response->response_reason_text);
					 $this->redirect('/orders/index/'.$id);
				 }
				}
				else
				{
					$this->Session->setFlash("Invalid Payment Details!");
					$noerror =0;
					$this->redirect('/orders/index/'.$id);
				}
			}
		}
		else
		{
		$this->Session->setFlash("Invalid Order Request!");
		$this->redirect('/');	
		}
		}
		else
		{
		$this->Session->setFlash("Invalid Payment Details!");
		$this->redirect('/orders/index/'.$id);
		}
	}
	
	// Authorize.Net Payment
	function authorizenet($id=NULL)
	{
		if(isset($id) && !empty($id))
		{		
		$Gig=$this->Gig->findbyId($id);
		if(isset($Gig) && !empty($Gig))
		{	
		if(!empty($this->data))
		{
		require_once APP.'vendors/authorizenet/AuthorizeNet.php';	
        $merchant = (object)array();
        $merchant->login = AUTHORIZENET_API_LOGIN_ID;
        $merchant->tran_key = AUTHORIZENET_TRANSACTION_KEY;
        $merchant->allow_partial_auth = "false";

        $creditCard = array(
            'exp_date' => $this->data['c_expmonth'].'/'.$this->data['c_expyear'],
            'card_num' => $this->data['c_n'],
            'card_code' => $this->data['c_cvv2'],
			'method' =>  "CC",
            );
		$amount=((COMMISSION_PERCENT*$Gig['Gig']['price'])/100)+$Gig['Gig']['price'];
        $transaction = array(
        'amount' => $amount,
        'duplicate_window' => '10',
         'email_customer' => 'false',
        'footer_email_receipt' => 'thank you for your business!',
        'header_email_receipt' => 'a copy of your receipt is below',
        );
            
        $order = array(
            'description' => substr($Gig['Gig']['description'],0,250),
            'invoice_num' => substr("CAL".uniqid(),0,20),
            'line_item' => '1<|>'.substr($Gig['Gig']['title'],0,30).'<|>'.substr($Gig['Gig']['description'],0,250).'<|>1<|>'.$Gig['Gig']['price'].'<|>N',
            );

		
        $customer = (object)array();
        $customer->first_name = substr($this->Session->read('User.name'),0,50);
        //$customer->last_name = "Smith";
        //$customer->company = "Jane Smith Enterprises Inc.";
        //$customer->address = "20 Main Street";
       // $customer->city = "San Francisco";
      //  $customer->state = "CA";
       // $customer->zip = "94110";
       // $customer->country = "US";
       // $customer->phone = "415-555-5557";
        //$customer->fax = "415-555-5556";
        $customer->email = $this->Session->read('User.email');
        $customer->cust_id = substr($this->Session->read('User.id'),0,20);
        $customer->customer_ip = substr($_SERVER['REMOTE_ADDR'],0,15);

//        $shipping_info = (object)array();
//        $shipping_info->ship_to_first_name = "John";
//        $shipping_info->ship_to_last_name = "Smith";
//        $shipping_info->ship_to_company = "Smith Enterprises Inc.";
//        $shipping_info->ship_to_address = "10 Main Street";
//        $shipping_info->ship_to_city = "San Francisco";
//        $shipping_info->ship_to_state = "CA";
//        $shipping_info->ship_to_zip = "94110";
//        $shipping_info->ship_to_country = "US";
//        $shipping_info->tax = "CA";
//        $shipping_info->freight = "Freight<|>ground overnight<|>12.95";
        $shipping_info->duty = 'Commission<|>Commission Percent : '.COMMISSION_PERCENT.'%<|>'.((COMMISSION_PERCENT*$Gig['Gig']['price'])/100);
//        $shipping_info->tax_exempt = "false";
//        $shipping_info->po_num = "12";

        $sale = new AuthorizeNetAIM;
        $sale->setFields($creditCard);
        $sale->setFields($shipping_info);
        $sale->setFields($customer);
        $sale->setFields($order);
        $sale->setFields($merchant);
        $sale->setFields($transaction);
		//$sale->setCustomField("Commission",'sdf');
        $response = $sale->authorizeAndCapture();
		return $response;
		}
		else
		{
		$this->Session->setFlash("Invalid Payment Details!");
	   	$this->redirect('/orders/index/'.$id);
		}
		}		
		else
		{
		$this->Session->setFlash("Invalid Order Request!");
		$this->redirect('/');				
		}
		}
		else
		{
		$this->Session->setFlash("Invalid Order Request!");
		$this->redirect('/');				
		}
	}
	
	
	// Insert Data to Orders and Transaction Tables for Authorize.Net
		function ordersData($response,$id=NULL){
			
		if(isset($id) and !empty($id) and isset($response) and $response->approved)
		{
		$Gig=$this->Gig->findbyId($id);
		$this->set('Gig', $Gig);
		$orders_insert= array(
							'gig_id'=>$id,
							'user_id'=>$this->Session->read('User.id'),
							'seller_id'=>$Gig['Gig']['user_id'],							
							'datetime'=>date('Y-m-d H:i:s',time()),
							'status'=>'Pending'
							);	
							
				// add Seller account Awaiting Funds 		  
		$seller_account=$this->Account->findbyUser_id($Gig['Gig']['user_id']);
		$seller_account_arr=array(
				'id'=>$seller_account['Account']['id'],
				'awaiting_funds'=>($seller_account['Account']['awaiting_funds']+$Gig['Gig']['price']),
				);
				$this->Account->save($seller_account_arr);
	
		$decline=$response->response_reason_text;
		if($this->Order->save($orders_insert))
		{
			  $Order_id = $this->Order->getLastInsertId(); 
				  $amount=$response->amount;
				  $payment_methods='Authorize';
				  $transaction_id=$response->transaction_id;
					$transaction_insert= array(
							'user_id'=>$this->Session->read('User.id'),
							'receiver_id'=>'Admin',
							'order_id'=>$Order_id,
							'gig_id'=>$id,
							'payment_methods'=>$payment_methods,
							'amount'=>$amount,
							'returned_data'=>serialize($response),
							'transaction_id'=>$transaction_id,
							'transaction_date'=>date('Y-m-d H:i:s',time()),
							'status'=>'Success',
							);		
		if($this->Transaction->save($transaction_insert))
		{
			$Tran_id = $this->Transaction->getLastInsertId();
			$transactionData=$this->Transaction->findbyId($Tran_id);
			$this->set('Transaction', $transactionData);
			$subject='Transaction Details : '.$transaction_id.' from '.SITE_URL;
			$this->_sendUserMail('',$subject,'success',$this->Session->read('User.email'),'Y');
			$this->_sendUserMail('',$subject,'success',$Gig['User']['email'],'N');			
			$this->Session->setFlash('Payment made succesfully.');
			$this->redirect('/');
		}
		else
		{
			$subject='Transaction Decline Details : '.$decline.' from '.SITE_URL;
			$this->_sendUserMail('',$subject,'decline',$this->Session->read('User.email'),'Y');
			$this->Session->setFlash($decline);
	   		$this->redirect('/orders/index/'.$id);
		}
		}
		else
		{
			$subject='Transaction Decline Details : '.$decline.' from '.SITE_URL;
			$this->_sendUserMail('',$subject,'decline',$this->Session->read('User.email'),'Y');
			$this->Session->setFlash($decline);
	   		$this->redirect('/orders/index/'.$id);
		}
		}
		else
		{
		$this->Session->setFlash("Invalid Payment Details!");
	   	$this->redirect('/orders/index/'.$id);
		}
	}

	
		//handles validation
	function _validateFields($data){
		$c_num=$data['c_n'];
		$c_type=$data['c_type'];
		if($this->_validCreditCard($c_num,$c_type))
			return true;
		else 
			return false;	
	}
	
	//check valid credit card number
	function _validCreditCard($cc_number,$c_type){
		$credit_card=$c_type;
		switch($credit_card) {
			case 'amex':
			$goodCC = '/^3[47]{1}[0-9]{13}$/';
			break;
			case 'visa':
			$goodCC = '/^4[0-9]{15}$/';
			break;
			case 'Mastercard':
			$goodCC = '/^5[1-5]{1}[0-9]{14}$/';
			break;
			case 'discover':
			$goodCC = '/^6011[0-9]{12}$/';
			break;
			default:
			$goodCC = '/^[0-9]{15,16}$/';
		}
	
		if (!preg_match($goodCC,$cc_number))
			return false;
		else
			return true;
			
	}//end __validCreditCard
 
 	/**
	  * hash_call: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
	  * returns an associtive array containing the response from the server.
	*/
	
	function hash_call($methodName,$nvpStr)
	{	// form header string
		$nvpheader = "";
	    $nvpheader.= "&PWD=".API_PASSWORD."&USER=".API_USERNAME."&SIGNATURE=".API_SIGNATURE;
		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		//in case of permission APIs send headers as HTTPheders
			$nvpStr=$nvpheader.$nvpStr;
		//check if version is included in $nvpStr else include the version.
		if(strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr)) {
			$nvpStr = "&VERSION=" . urlencode(VERSION) . $nvpStr;	
		}
		
		$nvpreq="METHOD=".urlencode($methodName).$nvpStr;
		
		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);
	
		//getting response from server
		$response = curl_exec($ch);
	
		//convrting NVPResponse to an Associative Array
		$nvpResArray=$this->deformatNVP($response);
		$nvpReqArray=$this->deformatNVP($nvpreq);
		$this->Session->write('nvpReqArray',$nvpReqArray);	
		//closing the curl
		curl_close($ch);
		return $nvpResArray;
	}

		/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
		  * It is usefull to search for a particular key and displaying arrays.
		  * @nvpstr is NVPString.
		  * @nvpArray is Associative Array.
		  */
		
		function deformatNVP($nvpstr)
		{
		
			$intial=0;
			$nvpArray = array();
			while(strlen($nvpstr)){
				//postion of Key
				$keypos= strpos($nvpstr,'=');
				//position of value
				$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
		
				/*getting the Key and Value values and storing in a Associative Array*/
				$keyval=substr($nvpstr,$intial,$keypos);
				$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
				//decoding the respose
				$nvpArray[urldecode($keyval)] =urldecode( $valval);
				$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
			 }
			return $nvpArray;
		}
		
	// Paypal Payment
	function paypal($id=NULL)
	{
		if(isset($id) && !empty($id))
		{		
		$Gig=$this->Gig->findbyId($id);
		if(isset($Gig) && !empty($Gig))
		{	
		if(!empty($this->data))
		{
		

/* An express checkout transaction starts with a token, that
   identifies to PayPal your transaction
   In this example, when the script sees a token, the script
   knows that the buyer has already authorized payment through
   paypal.  If no token was found, the action is to send the buyer
   to PayPal to first authorize payment
   */
if(!isset($token)) {

		/* The servername and serverport tells PayPal where the buyer
		   should be directed back to after authorizing payment.
		   In this case, its the local webserver that is running this script
		   Using the servername and serverport, the return URL is the first
		   portion of the URL that buyers will return to after authorizing payment
		   */
		   $currencyCodeType='USD';
		   $paymentType='Order';
           $personName        = substr($this->Session->read('User.name'),0,32);
		  // $SHIPTOSTREET      = $_REQUEST['SHIPTOSTREET'];
		  // $SHIPTOCITY        = $_REQUEST['SHIPTOCITY'];
		   //$SHIPTOSTATE	      = $_REQUEST['SHIPTOSTATE'];
		  // $SHIPTOCOUNTRYCODE = $_REQUEST['SHIPTOCOUNTRYCODE'];
		  // $SHIPTOZIP         = $_REQUEST['SHIPTOZIP'];
		   $L_NAME0           = substr($Gig['Gig']['title'],0,35);
		   $L_DESC0           = substr($Gig['Gig']['title'],0,35);
		   $L_AMT0            = ((COMMISSION_PERCENT*$Gig['Gig']['price'])/100)+$Gig['Gig']['price'];
		   $FEEAMT 			=((COMMISSION_PERCENT*$Gig['Gig']['price'])/100);
		   $L_QTY0            =	'1';
		   $ITEMAMT            = ((COMMISSION_PERCENT*$Gig['Gig']['price'])/100)+$Gig['Gig']['price'];
		   $ORDERDESC 		='Commission Percent : '.COMMISSION_PERCENT.'% '.((COMMISSION_PERCENT*$Gig['Gig']['price'])/100);
		   $INVNUM       =   "CAL".uniqid();
		   $NOSHIPPING ='1';
		   $ADDROVERRIDE  ='0';
		   $HDRIMG   =SITE_URL.'/uploads/logo.jpg';
		   $EMAIL    =$this->Session->read('User.email');
		   $CUSTOM ='Commission Percent : '.COMMISSION_PERCENT.'% '.((COMMISSION_PERCENT*$Gig['Gig']['price'])/100);
		  // $L_NAME1           =	$_REQUEST['L_NAME1'];
		  // $L_AMT1            = $_REQUEST['L_AMT1'];
		  // $L_QTY1            =	$_REQUEST['L_QTY1'];



		 /* The returnURL is the location where buyers return when a
			payment has been succesfully authorized.
			The cancelURL is the location buyers are sent to when they hit the
			cancel button during authorization of payment during the PayPal flow
			*/

		   $returnURL =urlencode(SITE_URL."/orders/ordercomplete");
		   $cancelURL =urlencode(SITE_URL);

		 /* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
           $amt = ((COMMISSION_PERCENT*$Gig['Gig']['price'])/100)+$Gig['Gig']['price'];
           $maxamt= $amt+25.00;
           $nvpstr="";
		   
           /*
            * Setting up the Shipping address details
            */
           $shiptoAddress = "&SHIPTONAME=$personName";
           
           $nvpstr="&ADDRESSOVERRIDE=".$ADDROVERRIDE."&NOSHIPPING=".$NOSHIPPING.urlencode($shiptoAddress)."&MAXAMT=".(string)$maxamt."&L_NAME0=".urlencode($L_NAME0)."&FEEAMT=".urlencode($FEEAMT)."&L_DESC0=".urlencode($L_DESC0)."&ITEMAMT=".urlencode($ITEMAMT)."&L_AMT0=".$L_AMT0."&L_QTY0=".$L_QTY0."&AMT=".(string)$amt."&ORDERDESC=".urlencode($ORDERDESC)."&INVNUM=".urlencode($INVNUM)."&HDRIMG=".urlencode($HDRIMG)."&EMAIL=".urlencode($EMAIL)."&CUSTOM=".urlencode($CUSTOM)."&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType."&PAYMENTACTION=".$paymentType;
		   
           
		 	/* Make the call to PayPal to set the Express Checkout token
			If the API call succeded, then redirect the buyer to PayPal
			to begin to authorize payment.  If an error occured, show the
			resulting errors
			*/
		   $resArray=$this->hash_call("SetExpressCheckout",$nvpstr);
		 //$this->Session->write('reshash',$resArray);
		  $this->Session->write('id',$id);
		  $this->Session->write('amount',$amt);
		   $ack = strtoupper($resArray["ACK"]);

		   if($ack=="SUCCESS"){
					// Redirect to paypal.com here
					$token = urldecode($resArray["TOKEN"]);
					$payPalURL = PAYPAL_URL.$token;
					$this->redirect($payPalURL);
				  } else  {
					 //Redirecting to display errors.
					$this->Session->setFlash($resArray["L_LONGMESSAGE0"]);
	   				$this->redirect('/orders/index/'.$id);
					}
} 
		}
		else
		{
		$this->Session->setFlash("Invalid Payment Details!");
	   	$this->redirect('/orders/index/'.$id);
		}
		}		
		else
		{
		$this->Session->setFlash("Invalid Order Request!");
		$this->redirect('/');				
		}
		}
		else
		{
		$this->Session->setFlash("Invalid Order Request!");
		$this->redirect('/');				
		}
	}

	// Insert Data to Orders and Transaction Tables for Paypal
		function ordersDatapaypal(){
		$id=$this->Session->read('id');
		$response=$this->Session->read('reshash');
		//$response['PayerID']=$this->params['url']['PayerID'];
		$transaction_id= $response['TOKEN'];
		if(isset($id) and !empty($id) and isset($response) and $response['ACK']=='Success')
		{
		$Gig=$this->Gig->findbyId($id);
		$this->set('Gig', $Gig);
		$orders_insert= array(
							'gig_id'=>$id,
							'user_id'=>$this->Session->read('User.id'),
							'seller_id'=>$Gig['Gig']['user_id'],
							'datetime'=>date('Y-m-d H:i:s',time()),
							'status'=>'Pending'
							);		
						// add Seller account Awaiting Funds 		  
		$seller_account=$this->Account->findbyUser_id($Gig['Gig']['user_id']);
		$seller_account_arr=array(
				'id'=>$seller_account['Account']['id'],
				'awaiting_funds'=>($seller_account['Account']['awaiting_funds']+$Gig['Gig']['price']),
				);
				$this->Account->save($seller_account_arr);

		if($this->Order->save($orders_insert))
		{
			  $Order_id = $this->Order->getLastInsertId(); 
					$transaction_insert= array(
							'user_id'=>$this->Session->read('User.id'),
							'receiver_id'=>'Admin',
							'order_id'=>$Order_id,
							'gig_id'=>$id,
							'payment_methods'=>'Paypal',
							'amount'=>$this->Session->read('amount'),
							'returned_data'=>serialize($response),
							'transaction_id'=>$transaction_id,
							'transaction_date'=>date('Y-m-d H:i:s',time()),
							'status'=>'Success',
							);		
		if($this->Transaction->save($transaction_insert))
		{
			$Tran_id = $this->Transaction->getLastInsertId();
			$transactionData=$this->Transaction->findbyId($Tran_id);
			$this->set('Transaction', $transactionData);
			$subject='Transaction Details : '.$transaction_id.' from '.SITE_URL;
			$this->_sendUserMail('',$subject,'success',$this->Session->read('User.email'),'Y');
	     	$this->_sendUserMail('',$subject,'success',$Gig['User']['email'],'N');
			$this->Session->setFlash('Payment made succesfully.');
			$this->redirect('/');
		}
		else
		{
			$subject='Transaction Decline from '.SITE_URL;
			$this->_sendUserMail('',$subject,'decline',$this->Session->read('User.email'),'Y');
			$this->Session->setFlash('Your payment has been declined.');
	   		$this->redirect('/orders/index/'.$id);
		}
		}
		else
		{
			$subject='Transaction Decline from '.SITE_URL;
			$this->_sendUserMail('',$subject,'decline',$this->Session->read('User.email'),'Y');
			$this->Session->setFlash('Your payment has been declined.');
	   		$this->redirect('/orders/index/'.$id);
		}
		}
		else
		{
			$this->Session->setFlash($response["L_LONGMESSAGE0"]);
	   		$this->redirect('/orders/index/'.$id);
		}
	}
// Complete the Order in Paypal
function  ordercomplete(){
		 
//		  At this point, the buyer has completed in authorizing payment
//			at PayPal.  The script will now call PayPal with the details
//			of the authorization, incuding any shipping information of the
//			buyer.  Remember, the authorization is not a completed transaction
//			at this state - the buyer still needs an additional step to finalize
//			the transaction
//			

		   $token =urlencode($this->params['url']['token']);

//		  Build a second API request to PayPal, using the token as the
//			ID to get the details on the payment authorization
//			
		   $nvpstr="&TOKEN=".$token;

//		  Make the API call and store the results in an array.  If the
//			call was a success, show the authorization details, and provide
//			an action to complete the payment.  If failed, show the error
//			
		   $resArray=$this->hash_call("GetExpressCheckoutDetails",$nvpstr);
		  // print_r('<pre>');
		 //  print_r($resArray);exit;
		  $this->Session->write('reshash',$resArray);
		   $ack = strtoupper($resArray["ACK"]);

		   if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING'){
			//$this->Session->setFlash("Paypal peyment success!");
	   		$this->redirect('/orders/ordersDatapaypal');
			  } else  {
					 //Redirecting to display errors.
					$this->Session->setFlash($resArray["L_LONGMESSAGE0"]);
	   				$this->redirect('/orders/index/'.$id);
			  }
}

}
?>
