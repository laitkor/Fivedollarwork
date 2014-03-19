<?php
#App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));
class UsersController extends AppController
{
	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Javascript','Session','Ajax');
	var $components = array('Session', 'Email','Captcha','RequestHandler','Twitter');
	var $uses = array('User','Recommend','Gig','Transaction','Like','Message','Order','Review','Rating','Account','Sentmessage','Withdraw','Reply');
	//var $paginate;
	
//	function beforeFilter()
//    {	
//	$this->redirectadmin();
//
//	}
	
function index()
	{
		$this->redirect('/');
	}

	
	function getAppURL() {
		$hostURL = 'http';
		if (isset($_SERVER['HTTPS'])) {
			$pageURL .= 's';
		}
		$hostURL .= '://'.$_SERVER['HTTP_HOST']; 
		return $hostURL;
	}
	
	function randomString($minlength = 20, $maxlength = 20, $useupper = true, $usespecial = false, $usenumbers = true){
        $charset = "abcdefghijklmnopqrstuvwxyz";
        if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($usenumbers) $charset .= "0123456789";
        if ($usespecial) $charset .= "~@#$%^*()_+-={}|][";
        if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
        else $length = mt_rand ($minlength, $maxlength);
        $key = '';
        for ($i=0; $i<$length; $i++){
            $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
        }
        return $key;
    }
/****************Facebook Integration Starts from Here*******************/	
	function fb_authorize() 
	{	
		//$this->Session->destroy();
		//import facebook Api
		App::import('Vendor', 'facebook');
 $facebook = new Facebook(array(
                                'appId'  => '212974112072342',
                                'secret' => '5d5452c23803f641a7f5487087f917be',
                                'cookie'=>true
                        ));
/*		
		$facebook = new Facebook(array(
			'appId'  => Configure::read('Facebook.application_id'),
  			'secret' => Configure::read('Facebook.application_secret'), 
		  	'cookie'=>true
		));*/	
		$app_url = $this->getAppURL();
	$session = $facebook->getSession();	
		# generate login url
     	$login_url = $facebook->getLoginUrl(array('next' => $app_url.'/users/fb_callback', 'cancel_url' => $app_url.'/users/fb_callback?denied=true', 'req_perms' => 'email,publish_stream,read_stream,offline_access'));
		
		$this->redirect($login_url);
	}
	
function fb_callback()
	{
		
		if (isset($_GET['denied'])) 
		{
			//session_name('CAKEPHP');
			//session_start();
			$this->Session->setFlash(__('<font color="red">You denied access to your facebook account.</font>', true));
		} 
		else 
		{
			//import facebook Api
			App::import('Vendor', 'facebook');
			$facebook = new Facebook(array(
                                'appId'  => '212974112072342',
                                'secret' => '5d5452c23803f641a7f5487087f917be',
				'cookie'=>true
			));
			$session = $facebook->getSession();
			
			if(!empty($session))
			{
				
				
				try
				{
					$responce = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
					
				}
				catch(FacebookApiException $e)
				{
					
					error_log($e);
				}
				if(!empty($responce))
				{
					
					//check user on users table by fb_uid
								
					if(!$this->Session->check('User')) 
					{	
						$user= $this->User->find('all',array('conditions'=>array('User.email'=> '' . $responce->email)));
					
						//if empty or not found then insert into table
						if(empty($user))
						{	
						$img = file_get_contents('https://graph.facebook.com/'.$responce->id.'/picture?type=large');
						$img_path = '/uploads/profile_img/'.$responce->id.'.jpeg';
		               file_put_contents($_SERVER['DOCUMENT_ROOT'].$img_path, $img);
						//header("Content-type:image/gif"); echo($img); exit;
					
					
							$this->data['User']['email'] =  ''  . $responce->email;
							$this->data['User']['password'] = $this->randomString();
							#$this->data['User']['group_id'] = '2';
							#$this->data['User']['verified'] = 'yes';
							$this->data['User']['name'] = $responce->first_name.' '.$responce->last_name;
							$this->data['User']['image']=$responce->id.'.jpeg';
							$this->data['User']['username'] = $responce->id;
							$this->data['User']['active'] = '1';	
							$this->data['User']['fbid'] = $responce->id;
							$this->data['User']['token'] = $session['access_token'];
							$this->data['User']['facebook_link'] = $session['secret'];
						
							$this->User->save($this->data);
							 $user_id = $this->User->getLastInsertId(); 
						 // Insert Data to Account Tables
						 $account_arr=array(
								'user_id'=>$user_id,
								'available_funds'=>'0',
								'awaiting_funds'=>'0',
								'upcoming_funds' =>'0',
								'withdrawn_funds'=>'0',
								'purchases_funds'=>'0'
						 );
						 $this->Account->save($account_arr);
						// $subject='Account activation email from '.SITE_URL;
						// $this->_sendUserMail('',$subject,'activate_account',$this->data['email'],'Y');
						// Success
						$this->Session->setFlash("Your Account has been created successfully");
						//$this->redirect('/users/nextstep/1');
							
							
							
							
							
							$u = $this->User->read();
							$this->setSession($u['User']);
							//$this->Session->write('user_id',$this->User->id);
							//$this->Session->write('email',$responce->email);
							//$this->Session->write('name', $responce->first_name);	
							$this->redirect('/users/index');
						}else{
							
							$this->setSession($user[0]['User']);
							$this->redirect('/users/index');
						} 
					}
					else
					{
						
						if ($this->Session->check('User'))
						{ 
							$fb_user = $this->User->find('first',array('conditions' => array('User.fbid' => $responce->id,'User.status'=>'Active')));
							if (is_array($fb_user))
							{
								$this->setSession($fb_user['User']);
								$this->redirect('/users/index');
							}
						}	
					}
					
			}
			else
			{
				$this->Session->setFlash(__('<font color="red">Sorry, we could not authenticate you.</font>', true));
				$this->redirect(array('controller'=>'users','action'=>'index'),null,true);
				}
			}
		}	
	}
	
	
	

	######## Captcha #######

	function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			App::import('Component','Captcha'); //load it
			$this->Captcha = new CaptchaComponent(); //make instance
			$this->Captcha->startup($this); //and do some manually calling
		}
		//$width = isset($_GET['width']) ? $_GET['width'] : '120';
		//$height = isset($_GET['height']) ? $_GET['height'] : '40';
		//$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
		//$this->Captcha->create($width, $height, $characters); //options, default are 120, 40, 6.
		$this->Captcha->create();
	}



	########  Join User #######
	function register() {
			if(!empty($this->data))	{
			$this->set('data',$this->data) ;		
			// Checking for Unique Username	
			$userrow=$this->User->findbyUsername($this->data['username']);
			if(!empty($userrow))
			{
				$this->Session->setFlash("Username is already taken, please enter a different Username.");
			}
			else
			{	
			// Checking for Unique Email Id
			$uemail=$this->User->findByEmail($this->data['email']);
			if(!empty($uemail))
			{
				$this->Session->setFlash("Email is already use, please enter a different Email.");
			}
			else
			{
			
			if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
				App::import('Component','Captcha'); //load it
				$this->Captcha = new CaptchaComponent(); //make instance
				$this->Captcha->startup($this); //and do some manually calling
			}

			$captchaValue=$this->Captcha->getVerCode(); //getting the Captcha value  from component 
			  if($captchaValue==$this->data['captcha'])	{ //Captcha validation check

					//Add member to database	
					$activationkey = sha1(microtime(true).mt_rand(10000,90000));			
					$user_ins_arr= array(
						'username'=>$this->data['username'],
						'password'=>md5($this->data['password']),
						'activation_key'=>$activationkey,
						'email'=>$this->data['email'],
						'user_type'=>'User',
						'status' => 'Pending',
						'created'=>date("Y-m-d H:i:s"),
						'updated'=>date("Y-m-d H:i:s")
								);
					if ($this->User->save($user_ins_arr)) {
						//Now Send Mail to user
						 $this->set('record',$user_ins_arr);
						 $user_id = $this->User->getLastInsertId(); 
						 // Insert Data to Account Tables
						 $account_arr=array(
								'user_id'=>$user_id,
								'available_funds'=>'0',
								'awaiting_funds'=>'0',
								'upcoming_funds' =>'0',
								'withdrawn_funds'=>'0',
								'purchases_funds'=>'0'
						 );
						 $this->Account->save($account_arr);
						 $subject=' Please activate your Five Dollar Work account.
';
						 $this->_sendUserMail('',$subject,'activate_account',$this->data['email'],'Y');
						// Success
						$this->Session->setFlash("Congrats !!! You have successfully registered with our site . ");
						$this->redirect('/users/nextstep/1');
					}else {
						$error_msg = ($this->User->invalidFields());
						$this->Session->setFlash($error_msg);
					}
			  }	else	{ //or
				  $this->Session->setFlash("Error occured while matching captcha code!");
				  return false;
				  //pr($this->Signup->validationErrors);
				  //something do something else
			  }
			
			}
			}
	
		}
	}

########  User Account Activation #######
	
function activateaccount($activationkey=0){
		$conditions =  array('conditions' => array('User.activation_key' => $activationkey));
		$r= $this->User->find('first',$conditions); 
		if(!empty($r)){
			if($r['User']['status'] != 'Pending')
				$this->redirect('/users/nextstep/3');
			else{				
				$this->User->save(array('id'=>$r['User']['id'],'status'=>'Active'));
				$this->set('username',$r['User']['username']);
				 $subject='Welcome to Five Dollar Work';
				$this->_sendUserMail('',$subject,'signup_message',$r['User']['email']);
				$this->redirect('/users/signin');		
			}
		}else
			$this->redirect('/users/nextstep/4');
	}
	
	########  User Sign In #######

function signin() {
	
	if(!empty($this->data))
	{
			$u=$this->User->findByUsername($this->data['username']);
			
			if (!empty($u)) {
				 
				if(md5($this->data['password']) == $u['User']['password']){
					
						//update updated date and time record  in users table
				    $result=$this->User->query("update users set updated = '".date("Y-m-d H:i:s")."' where id = '".$u['User']['id']."' ");
					
					
					// Success
					if($u['User']['status'] != 'Active')
					{						
					if($u['User']['status'] == 'Pending')
					{
					$this->Session->setFlash("Your account has not been activated yet.");
					}
					if($u['User']['status'] == 'Inactive')
					{
					$this->Session->setFlash("Your account has been blocked.");
					}
					}
					else{
						if($u['User']['user_type']=='User'){
							
							$this->setSession($u['User']);
							$this->redirect('/');	
						}
						if($u['User']['user_type']=='Admin' or $u['User']['user_type']=='Modifier'){						$this->setadminSession($u['User']);
						$this->redirect('/admin/index');	
						}
					}
				}else
				$this->Session->setFlash("Invalid Password!"); 
			}else{
				$this->Session->setFlash("Invalid Username!"); 
			}
	}
	}
	
	########  User Forgot Password or Username #######
	function forgot($type=0) {
		$this->set('type',$type);
		switch($type){
			case '1':
		//Form Submitted 
		 if (!empty($this->data)) { 
		    //query for select all record	
		  $record=$this->User->findByEmail($this->data['email']);		 
		 if(!empty($record))
		{
		$this->set('username',$record['User']['username']);
		// To send HTML mail, the Content-type header must be set
    	$subject='Request for Username recovery email from '.SITE_URL;
		$this->_sendUserMail('',$subject,'forgot_message',$record['User']['email']);
		$this->redirect('/users/nextstep/9');  
		}
		else{
			$this->Session->setFlash("This email do not exists.");
		    }
		}
			break;
			case '2':
		//Form Submitted 
		 if (!empty($this->data)) { 
		    //query for select all record	
		  $record=$this->User->findByEmail($this->data['email']);		 
		 if(!empty($record))
		{
		$this->set('username',$record['User']['username']);
		$this->set('activation_key',$record['User']['activation_key']);
		// To send HTML mail, the Content-type header must be set
    	$subject='Request for Reset Password email from '.SITE_URL;
		$this->_sendUserMail('',$subject,'forgot_message',$record['User']['email']);
		$this->redirect('/users/nextstep/5');  
		
		}
		else{
			$this->Session->setFlash("This email do not exists.");
		    }
		}
			break;
			default:
			$this->redirect('/');
		}
	}
	
	########  User set New Password #######
		function newpassword($num=NULL){
			 $this->set('actkey',$num);
		//query for select all record	
		   $record=$this->User->findByActivation_key($num);
		    if(!empty($record)) {
				if(!empty($this->data))
				{
					//genrate new activation key 
					$activationkey = sha1(microtime(true).mt_rand(10000,90000));

					//update password and activation key record  in users table
				    $result=$this->User->query("update users set password = '".md5($this->data['password'])."', activation_key = '".$activationkey."' where id = '".$record['User']['id']."' ");
					$this->Session->setFlash(__('You have successfully recovered your password!', true));
					$this->redirect('/users/signin');	

					}
			}
			else 
			{
					$this->Session->setFlash(__('Invalid Link!', true));
					$this->redirect('/users/forgot/2');	
			}

		}

	########  User Profile Edit #######
function profile() {
		//Checking user login
		$this->checkSession();
		$record=$this->Session->read('User');
		$this->set('record',$record);
		if(!empty($this->data))
		{
			foreach($this->data as $key=>$value)
			{
			if($key!="email" and $key!="image")
					{
					$condition[$key] = $value;	
					}
			}
			// Checking for Unique Email Id
			if($this->data['email']!=$record['email'])
			{
			$uemail=$this->User->findByEmail($this->data['email']);
			if(!empty($uemail))
			{
				$this->Session->setFlash("Email is already use, please enter a different Email.");
				$this->redirect('/users/profile');
			}
			else
			{
				$condition['email'] = $this->data['email'];	
				//$condition['status'] = 'Pending';	
				//$subject='Email Verification email from '.SITE_URL;
				//$this->_sendUserMail('',$subject,'verification',$this->data['email'],'N');
				//$massege="Please verify your email.";
			}	
			}
			else
			{
				$condition['email'] = $this->data['email'];	
			}
			
			// Photo upload
			if(!empty($this->data['image']['name']))
			{
			if(strlen($this->data['image']['name'])>4){
			$uploaddir =  WWW_ROOT."uploads/profile_img/";
			// Make sure the required directories exist, and create them if necessary
           if(!is_dir($uploaddir)){mkdir($uploaddir,true);}
			
			$filetype = $this->getFileExtension($this->data['image']['name']);
            $filetype = strtolower($filetype);
			 if (($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png"))
                    {
				$this->Session->setFlash("Please enter a value with a valid extension.");
				$this->redirect('/users/profile');
                    }
                    else
                    {
                        // Get the image size
                        list($width, $height, $type, $attr)= getimagesize($this->data['image']['tmp_name']);
						$filename= $record['username'].'.'.$filetype;
						
						 // Generate a unique name for the image (from the timestamp)
                   // $id_unic = str_replace(".", "", strtotime ("now"));
                    /*$filename = $record['username'];
                    settype($filename,"string");
                    $filename.= ".";
                    $filename.=$filetype;*/
					 
                    $resizedfile = $uploaddir.$filename;
					
					//move_uploaded_file($this->data['image']['tmp_name'],'/img');
					if (is_uploaded_file($this->data['image']['tmp_name']))
                    {
						//move_uploaded_file(	$this->data['image']['tmp_name'],$resizedfile);
						// Copy the image into the temporary directory
                      //  if (!copy($this->data['image']['tmp_name'],$resizedfile))
                      //  {
                       //     print "Error Uploading File!.";
                       //     exit();
                       // }
                       // else {
                    //Generate the version of the image with max of $imgscale in either directions
					if($width<100 && $height<100)
					{
						if(!move_uploaded_file($this->data['image']['tmp_name'],$resizedfile))
						{
							$this->Session->setFlash('Error Uploading File!.');
							$this->redirect('/users/profile');
                       		exit();
						}
					}
					else
					{
                    $this->resize_img($this->data['image']['tmp_name'], 100, $resizedfile,$filetype);         }
						//}
                     // Delete the temporary image
                    unlink($this->data['image']['tmp_name']);
					// image File path
					$condition['image'] = $filename;	
                    }
                    }
			}
			}
$condition['id'] = $record['id'];	
if ($this->User->save($condition)) {
					$us=$this->User->findByUsername($record['username']);
				   $this->setSession($us['User']);
				   if(isset($massege))
				   {
					$this->Session->setFlash("Your profile successfully Updated. ".$massege);
				   }
				   else
				   {
					   $this->Session->setFlash("Your profile successfully Updated.");
				   }
					$this->redirect('/users/profile');
					}else {
						$error_msg = ($this->User->invalidFields());
						$this->Session->setFlash($error_msg);
						$this->redirect('/users/profile');
					}

			
		}
	}

########  Users public profile #######
function publicprofile($username=""){
	if(!empty($username))
	{
		$record=$this->User->findbyUsername($username);
		if(!empty($record))
		{
			$create=$this->_ago(strtotime($record['User']['created']));
			$update=$this->_ago(strtotime($record['User']['updated']));
			$ago=array('create'=>$create,'update'=>$update);
			$this->set('record',$record);
			$this->set('ago',$ago);
			
			if (!$this->Session->check('User'))
			{
				$checkLogin=0;
				$this->set('checkLogin',$checkLogin);
			}
		}
		else
		{
		 	$this->Session->setFlash(__('Invalid Link!', true));
			$this->redirect('/');			
		}
	}
	else
	{
		$this->Session->setFlash(__('Invalid Link!', true));
		$this->redirect('/');			
	}
}


	########  User Change Password #######
function changepassword() {
		//Checking user login
		$this->checkSession();
	  $record=$this->Session->read(); //read session values
			    if (!empty($this->data)) { 		 
			  $user=$this->User->findByUsername($record['User']['username']);
			   if (!empty($user)) {
				//check password is correct or not
				if(md5($this->data['oldpassword']) == $user['User']['password']){
		        //query for update new password	
			    $result=$this->User->query("update users set password='".md5($this->data['password'])."', updated = '".date("Y-m-d H:i:s")."' where username ='".$record['User']['username']."'");
				$us=$this->User->findByUsername($record['User']['username']);
				   $this->setSession($us['User']);
                   $this->Session->setFlash('You have successfully changed your password!');
					
				}else {
				      //Set Error for invalid password
					$this->Session->setFlash("Invalid Password!");
				}
			}
		 }

	}
	
	########  Withdraw earnings #######

	function withdraw() {
		//Checking user login
		$this->checkSession();
		$this->paginate = array('conditions' => array("Withdraw.user_id" => $this->Session->read('User.id')),'limit' =>'10','order' => array('Withdraw.id' => 'DESC'));
	 $Withdraw =$this->paginate('Withdraw'); 
	 $this->set('Withdraw',$Withdraw);
		$Account=$this->Account->findbyUser_id($this->Session->read('User.id')); 
		$this->set('Account',$Account);
		if(!empty($this->data))
		{
			$amount=$this->data['amount'];
			if(is_numeric($amount))
			{
				if($amount<=$Account['Account']['available_funds'] && $amount>0)
				{
				$withdraw_arr=array(
				'user_id'=>$this->Session->read('User.id'),
				'amount'=>$amount,
				'request_datetime'=>date('Y-m-d H:i:s',time()),
				'status'=>'Pending'
				);
			 	if($this->Withdraw->save($withdraw_arr))
				{
				$account_arr=array(
				'id'=>$Account['Account']['id'],
				'available_funds'=>($Account['Account']['available_funds']-$amount),
				'withdrawn_funds'=>($Account['Account']['withdrawn_funds']+$amount),
				);
				$this->Account->save($account_arr);
				$this->Session->setFlash("Withdraw request made succesfully.");
				$this->redirect('/users/withdraw');					
				}
				else
				{
				$this->Session->setFlash("Withdraw request decline!");
				$this->redirect('/users/withdraw');					
				}
				}
				else
				{
				$this->Session->setFlash("Invalid Amount!");
				$this->redirect('/users/withdraw');					
				}		
			}
			else
			{
				$this->Session->setFlash("Invalid Amount! Please enter numeric value only.");
				$this->redirect('/users/withdraw');
			}			
		}
	}
	
	
	########  User Submit Recommendation #######
	function recommended() {
		//Checking user login
		$this->checkSession();
		if(!empty($this->data))
		{
			foreach($this->data as $key=>$value)
			{
			$condition[$key] = $value;	
			}
			$condition['user_id'] = $this->Session->read("User.id");
			if ($this->Recommend->save($condition)) {
					 $this->Session->setFlash("Your recommendation has been submitted for review.");
					$this->redirect('/');
					}
			else {
						$error_msg = ($this->User->invalidFields());
						$this->Session->setFlash($error_msg);
						$this->redirect('/');
			}
		}
	}
	
	########  User Logout #######
	function signout()    { 
		//import facebook Api
		/*App::import('Vendor', 'facebook');
		$facebook = new Facebook(array(
			'appId'  => '212974112072342',
  			'secret' => '5d5452c23803f641a7f5487087f917be', 
		  	'cookie'=>true
		));
		$app_url = $this->getAppURL();
		$facebook->getLogoutUrl(array($app_url));
		*/
		$this->Session->destroy('User');
		//$this->Session->delete('User');    
		$this->Session->setFlash('Successfully Sign Out');  
		$this->redirect('/');    
	}



########  User Account Messages #######	
function nextstep($msgid=0){
		switch($msgid){
			case '1':
				$pagetitle= "Registration Completed";
				$pagemessage = "Your Account has been created successfully and your activation mail has been sent to your mail inbox.<p>Activate your account by clicking on this link, that we have sent you on your email address , which you had provided on sign up form.</p>";
			break;
				
			case '2':
				$pagetitle= "Account Activated";
				$pagemessage = "Your Account has been activated.<p><a href='".FULL_BASE_URL."/users/signin' title='Sign in' style='color:#000'><b>Click here</b></a> to Sign in your account.</p>";
			break;
			
			case '3':
				$pagetitle= "Already Activated";
				$pagemessage = "Your Account has been already activated.<p>Please <a href='".FULL_BASE_URL."/users/signin' title='Sign in' style='color:#000'><b>Click here</b></a> to Sign in your account.</p>";
			break;	
			
			case '4':
				$pagetitle= "Activation Error";
				$pagemessage = "Your Account has not been activated.<br><br> May be due invalid activation link or broken url.<p>Please copy the link from your inbox mail and paste it on a new browser.";
			break;	
			case '5':
				$pagetitle= "Request For Your Reset Password";
				$pagemessage = "Your Reset Password has been sent to  your mail.<p>Please copy the link from your inbox mail and paste it on a new browser.";
			break;	
			case '6':
				$pagetitle= "Request For Your New Password";
				$pagemessage = "Your Password send to your mail.<p>Please click the login link from your inbox mail to continue.";
			break;	
			case '7':
				$pagetitle= "Invite Friends";
				$pagemessage = "Your friend(s) had been invited successfully and they will join you soon.<p><a href='/users/invitefriend'>Click here</a> to find more friend.</p>";
			break;	
			case '8':
				$pagetitle= "Profile Message";
				$pagemessage = "This user not created a profile.</p>";
			break;	
			case '9':
				$pagetitle= "Request For Your Username recovery";
				$pagemessage = "Your Username Recovery  email has been sent.<p>Please check your email.</p><p>Please <a href='".FULL_BASE_URL."/users/signin' title='Sign in' style='color:#000'><b>Click here</b></a> to Sign in your account.</p>";
			break;	
			default:
			$this->redirect('/');
		}
		$this->set('ptitle', $pagetitle);
		$this->set('pmessage', $pagemessage);
	}
	
	function mygigs()
	{
		$this->checkSession();
		$user=$this->Session->read('User.id');
		
		$this->paginate = array('conditions' =>array('Gig.user_id'=>$user,'Gig.status!="Deleted"'), 'limit' =>6);
		$gigs =$this->paginate('Gig'); 
		#$gigs=$this->Gig->find('all',array('conditions'=>array('Gig.user_id'=>$user)));
		if(!empty($gigs))
		{
		$this->set('allgigs',$gigs);
		}
		else
			{
			$this->Session->setFlash('No Records Found !');

			}
		
	}
	function addgigs()
	{
		$this->checkSession();
		if(!empty($this->data))
		{
			if(!empty($this->data['image']['name']))
			{
			if(strlen($this->data['image']['name'])>4){
			$uploaddir =  WWW_ROOT."/uploads/gig_img/";
			// Make sure the required directories exist, and create them if necessary
           if(!is_dir($uploaddir)){mkdir($uploaddir,true);}
			
			$filetype = $this->getFileExtension($this->data['image']['name']);
            $filetype = strtolower($filetype);
			 if (($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png"))
                    {
				$this->Session->setFlash("Please Upload Image File.");
				$this->redirect('/users/addgigs');
                    }
                    else
                    {
                        // Get the image size
                        list($width, $height, $type, $attr)= getimagesize($this->data['image']['tmp_name']);
						$filename= $this->data['image']['name'];
						
						 // Generate a unique name for the image (from the timestamp)
              $id_unic = str_replace(".", "", strtotime ("now"));
                   
                    $resizedfile = $uploaddir.$id_unic.".".$filetype;
					//move_uploaded_file($this->data['image']['tmp_name'],$resizedfile);
					if (is_uploaded_file($this->data['image']['tmp_name']))
                    {
						//move_uploaded_file(	$this->data['image']['tmp_name'],$resizedfile);
						// Copy the image into the temporary directory
                      //  if (!copy($this->data['image']['tmp_name'],$resizedfile))
                      //  {
                       //     print "Error Uploading File!.";
                       //     exit();
                       // }
                       // else {
                    //Generate the version of the image with max of $imgscale in either directions
					if($width<100 && $height<100)
					{
						if(!move_uploaded_file($this->data['image']['tmp_name'],$resizedfile))
						{
							$this->Session->setFlash('Error Uploading File!.');
							$this->redirect('/users/addgigs');
                       		exit();
						}
					}
					else
					{
                    $this->resize_img($this->data['image']['tmp_name'], 100, $resizedfile,$filetype);         }
						//}
                     // Delete the temporary image
                    unlink($this->data['image']['tmp_name']);
					// image File path
					$this->data['image'] = $id_unic.".".$filetype;	
                    }
                    }
			}
			}
			
			
			$user_id=$this->Session->read('User.id');
			$this->data['user_id']=$user_id;
			$this->data['date']=date('Y-m-d h:i:s');
		$this->Gig->save($this->data);
		$this->Session->setflash("Successfully Added");
	
		
		}
	}
    function suspend()
	{
		   $this->checkSession();
			$mygigs = $this->data['MyGig']['check'];
			for($i=0;$i<count($mygigs);$i++)
			{
				$this->Gig->Query("update gigs set status='Suspend' where id='".$mygigs[$i]."'");
			}
		//$this->redirect('mygigs');
		$this->redirect($this->referer(null, true)); 
}
	function active()
	{
		$this->checkSession();
		$mygigs = $this->data['MyGig']['check'];
			for($i=0;$i<count($mygigs);$i++)
			{
				$this->Gig->Query("update gigs set status='Active' where id='".$mygigs[$i]."'");
			}
		//$this->redirect('mygigs');
		$this->redirect($this->referer(null, true));
		
	}
	function inbox()
	{
		
     
		$this->checkSession();
	  $user_id=$this->Session->read('User.id');
		 $count=$this->Message->find('count',array('conditions' =>array('Message.to_users_id'=>$user_id,'Message.message_id'=>0,'Message.status'=>'unread')));
	 # $this->set('count',$count);
	
		$this->paginate = array('conditions' =>array('Message.to_users_id'=>$user_id,'Message.message_id'=>0), 'limit' =>10,'order'=>'Message.date DESC');
		$to =$this->paginate('Message');

		$this->set('to',$to);
		return $count;
	
}
	function sentitems()
	{
		$this->checkSession();
     $user_id=$this->Session->read('User.id');
#	  $to=$this->Message->find('all',array('conditions'=>array('from_users_id'=>$user_id)));
	  	$this->paginate = array('conditions' =>array('Sentmessage.sender_id'=>$user_id,'Sentmessage.message_id'=>0), 'limit' =>10,'order'=>'Sentmessage.date DESC');
		$to =$this->paginate('Sentmessage'); 
	$this->set('to',$to);
		
	}
	function bookmarks()
	{
		$this->checkSession();
						#pr($gig);
			 $user_id=$this->Session->read('User.id');
	
			$this->Like->unbindModel(array('belongsTo' => array('Gig', 'User')),false);
$options['joins'] = array(
                                   array('table' => 'gigs',
                                         'alias' => 'Gig',
                                         'type' => 'INNER',
                                         'conditions' => array('Gig.id=Like.gig_id')),
                                   array('table' => 'users',
                                         'alias' => 'User',
                                         'type' => 'INNER',
                                         'conditions' => array('User.id=Gig.user_id'))
                                                                        );
$options['fields']=array('*');
$options['conditions']=array('Gig.status'=>'Active','Like.user_id' => $user_id,'User.status'=>'Active');
$options['limit']='6';
$this->paginate=$options;
$like = $this->paginate('Like');

		
			
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
				$seaLIKE = $vL['Gig']['id'];
				if (array_key_exists($seaLIKE,$newLike))
				{ #echo "vinod"; exit;
					#if($newLike[$seaLIKE] = $user_id )
					$like[$kL]['Gig']['like_user'] = $newLike[$seaLIKE];	
			}

			}
			if(!empty($like))
			{
				 $this->set('like',$like);
			}
			else
			{
			$this->Session->setFlash('No Records Found !');

			}
		
	}
		
	function unlike($id=NULL)
	{
		$this->checkSession();
		  $user_id=$this->Session->read('User.id');

		$this->Like->query("delete from likes where user_id='$user_id' and gig_id='$id'");
		$this->redirect("bookmarks");
	}
	function message($id=NULL,$type,$stats=NULL,$msg_id=NULL)
	{
		$this->checkSession();
		$user_id=$this->Session->read('User.id');
		$this->set('user_id',$user_id);
		if($type=='inbox')
			{
				
		 $msg= $this->Message->find('all',array('conditions'=>array('Message.id'=>$id)));
			
		
			
					$reply=  $this->Message->find('all',array('conditions'=>array('Message.id="'.$id.'" OR Message.message_id="'.$id.'" '), 'order'=>'Message.date DESC'));
					
					
				$this->set('reply',$reply);
				
				
				
				
				 if($stats=='unread')
					{
						$msgs['Message']['status']='read';
						$msgs['Message']['id']=$msg_id;
						$this->Message->save($msgs);
					
					}
					$this->set('msg',$msg);
					
			}
			else
			{
			 $msg= $this->Sentmessage->find('all',array('conditions'=>array('Sentmessage.id'=>$id)));
			 $reply=  $this->Sentmessage->find('all',array('conditions'=>array('Sentmessage.id="'.$id.'" OR Sentmessage.message_id="'.$id.'" '), 'order'=>'Sentmessage.date DESC'));
					
				$this->set('msg',$msg);	
				$this->set('reply',$reply);
			}
			
			$this->set('type',$type);
	}

function editgig($id=NULL)
{
	$this->checkSession();
	$gig=$this->Gig->find('all',array('conditions'=>array('Gig.id'=>$id)));
/*	pr($gig);
	exit;*/
	$this->set('gig',$gig);
	$this->checkSession();
		$record=$this->Session->read('User');
		$this->set('record',$record);
	if(!empty($this->data))
		{
			$editgig['Gig']=$this->data;
			if(!empty($this->data['image']['name']))
			{
				
			if(strlen($this->data['image']['name'])>4){
			$uploaddir =  WWW_ROOT."/uploads/gig_img/";
			// Make sure the required directories exist, and create them if necessary
           if(!is_dir($uploaddir)){mkdir($uploaddir,true);}
			
			$filetype = $this->getFileExtension($this->data['image']['name']);
            $filetype = strtolower($filetype);
			 if (($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png"))
                    {
				$this->Session->setFlash("Please Upload Image File.");
				$this->redirect('/users/editgigs');
                    }
                    else
                    {
                        // Get the image size
                        list($width, $height, $type, $attr)= getimagesize($this->data['image']['tmp_name']);
						$filename= $this->data['image']['name'];
						
						 // Generate a unique name for the image (from the timestamp)
              $id_unic = str_replace(".", "", strtotime ("now"));
                   
                    $resizedfile = $uploaddir.$id_unic.".".$filetype;
					//move_uploaded_file($this->data['image']['tmp_name'],$resizedfile);
					if (is_uploaded_file($this->data['image']['tmp_name']))
                    {
						//move_uploaded_file(	$this->data['image']['tmp_name'],$resizedfile);
						// Copy the image into the temporary directory
                      //  if (!copy($this->data['image']['tmp_name'],$resizedfile))
                      //  {
                       //     print "Error Uploading File!.";
                       //     exit();
                       // }
                       // else {
                    //Generate the version of the image with max of $imgscale in either directions
					if($width<100 && $height<100)
					{
						if(!move_uploaded_file($this->data['image']['tmp_name'],$resizedfile))
						{
							$this->Session->setFlash('Error Uploading File!.');
							$this->redirect('/users/editgig');
                       		exit();
						}
					}
					else
					{
                    $this->resize_img($this->data['image']['tmp_name'], 100, $resizedfile,$filetype);         }
						//}
                     // Delete the temporary image
                    unlink($this->data['image']['tmp_name']);
					// image File path
					#$this->data['image'] = $id_unic.".".$filetype;	
					$editgig['Gig']['image'] = $id_unic.".".$filetype;	
                    }
                    }
			}
			}
			else
			{
				$editgig['Gig']['image']=$gig[0]['Gig']['image'];
			}
			
			$user_id=$this->Session->read('User.id');
			$editgig['Gig']['id']=$id;
			
			
			$this->Gig->save($editgig);
		$this->Session->setflash("Successfully Updated");
		$this->redirect('mygigs');

		}
	
}
		function review($id=NULL)
		{
			$this->checkSession();
			$order=$this->Order->find('all',array('conditions'=>array('Order.id'=>$id)));
			
			$this->set('order',$order);
			if(!empty($this->data))
			{
			$review['Review']=$this->data;
			$review['Review']['order_id']=$id;
			$review['Review']['datetime']=date('Y-m-d H:i:s');
			$this->Review->save($review['Review']);
            $gig=$this->Rating->find('all',array('conditions'=>array('Rating.gig_id'=>$order[0]['Order']['gig_id'])));
			$user=$this->Gig->find('all',array('conditions'=>array('Gig.id'=>$order[0]['Gig']['id'])));
			if(!empty($gig))
			{
			  $rate=($gig[0]['Rating']['ratingavg']+$review['Review']['rating'])/2;
			  $rating['Rating']['id']= $gig[0]['Rating']['id'];
			  $rating['Rating']['ratingavg']=$rate;
			  $rating['Rating']['giguserid']=$user[0]['Gig']['user_id'];
			  $this->Rating->save($rating);
			}
			else
			{    
			     $rating['Rating']['ratingavg']=$this->data['rating'];
				 $rating['Rating']['gig_id']=$order[0]['Gig']['id'];
				   $rating['Rating']['giguserid']=$user[0]['Gig']['user_id'];
				 $rating['Rating']['giguserid'];
			 $this->Rating->save($rating);
			}

			$this->redirect('orders');
			}
					}
		function del_inbox($arr)
		{
			
			$this->checkSession();
			$var=explode(',',$arr);	
			

				for($i=0;$i<count($var);$i++)
				{
										
                 $this->Message->delete($var[$i]);				
				}
			//$this->redirect('inbox');				
			$this->redirect($this->referer(null, true)); 
			
		}
		function del_outbox($arr)
		{
			$this->checkSession();
			$var=explode(',',$arr);	
			

				for($i=0;$i<count($var);$i++)
				{
										
                 $this->Sentmessage->delete($var[$i]);				
				}
			//$this->redirect('inbox');				
			$this->redirect($this->referer(null, true)); 
			
		}
		function orders($status=NULL)
		{
			
			if($status==NULL)
			{
				$status='Pending';
			}
	
			$this->checkSession();
			$this->set('status',$status);
			$Order_status['Pending']=$this->Order->find('count',array('conditions'=>array('Order.user_id'=>$this->Session->read('User.id'),'Order.status'=>'Pending')));
			$Order_status['Active']=$this->Order->find('count',array('conditions'=>array('Order.user_id'=>$this->Session->read('User.id'),'Order.status'=>'Active')));
			$Order_status['Delivered']=$this->Order->find('count',array('conditions'=>array('Order.user_id'=>$this->Session->read('User.id'),'Order.status'=>'Delivered')));
			$Order_status['Completed']=$this->Order->find('count',array('conditions'=>array('Order.user_id'=>$this->Session->read('User.id'),'Order.status'=>'Completed')));
			$Order_status['Cancelled']=$this->Order->find('count',array('conditions'=>array('Order.user_id'=>$this->Session->read('User.id'),'Order.status'=>'Cancelled')));
			$this->set('Order_status',$Order_status);
			$this->paginate=array('conditions'=>array('Order.user_id'=>$this->Session->read('User.id'),'Order.status'=>$status),'limit'=>15);
			
	if($status=='Review')
			{		
			$this->Review->unbindModel(array('belongsTo' => array('Order')),false);
$options['joins'] = array(
								   array('table' => 'orders',
                                         'alias' => 'Order',
                                         'type' => 'INNER',
                                         'conditions' => array('Review.order_id=Order.id')),
                                   array('table' => 'gigs',
                                         'alias' => 'Gig',
                                         'type' => 'INNER',
                                         'conditions' => array('Gig.id=Order.gig_id')),
                                   array('table' => 'users',
                                         'alias' => 'User',
                                         'type' => 'INNER',
                                         'conditions' => array('User.id=Order.seller_id'))
                                                                        );
$options['fields']=array('*');
$options['conditions']=array('Gig.status'=>'Active','Order.user_id' =>$this->Session->read('User.id'));
$options['limit']='15';
        
     $this->paginate=$options;
	 $review=$this->paginate('Review');
	 if(!empty($review))
		{
			$this->set('review',$review);
			
		}
		else
		{
		 $this->Session->setFlash('No Records Found !');
		}
	
			}
			else
			{
			  $orders=$this->paginate('Order');
			  if(!empty($orders))
		{
			$this->set('orders',$orders);
			
		}
		else
		{
		 $this->Session->setFlash('No Records Found !');
		}
			}
			
			
		
			
			
			
			
					
}	
		function pending()
		{

		$this->Session->write('status','Pending');
		$this->redirect('orders');

		}
		function allstatus()
		{
		$this->Session->write('status','All Status');		
		
		$this->redirect('orders');
		}
		function completed()
		{
			$this->Session->write('status','Completed');		
		
		    $this->redirect('orders');
		}
		function activeOrders()
		{
			$this->Session->write('status','Active Orders');		
		
		    $this->redirect('orders');
		}
		function cancelOrders()
		{
			$this->Session->write('status','Cancel Orders');		
		
		    $this->redirect('orders');
		}
		function editmanageorder($id,$status=NULL)
		{
			$this->checkSession();
			$this->set('status',$status);
			$order=$this->Order->find('all',array('conditions'=>array('Order.id'=>$id)));
			$this->set('order',$order);
			if(!empty($this->data))
			{
				$userid=$this->Session->read('User.id');
	$seller_funds=$this->Account->find('all',array('conditions'=>array('Account.user_id'=>$order[0]['Order']['seller_id'])));	
	  if($this->data['status']=='Completed')
	   {
		
	     $up_fund= $seller_funds[0]['Account']['upcoming_funds']-$order[0]['Gig']['price'];
		$avbl_fund= $seller_funds[0]['Account']['available_funds']+$order[0]['Gig']['price'];
		$seller_acc['Account']['available_funds']= $avbl_fund;
		$seller_acc['Account']['upcoming_funds']=$up_fund;	
		$seller_acc['Account']['id']=$seller_funds[0]['Account']['id']; 
			
		$this->Account->save($seller_acc['Account']);
		}
		else if($this->data['status']=='Cancelled_Active')
		{
			$this->data['status']='Cancelled';
$buyer_fund=$this->Account->find('all',array('conditions'=>array('Account.user_id'=>$userid)));

$awt_fund=$seller_funds[0]['Account']['awaiting_funds']-$order[0]['Gig']['price'];		
	     $avbl_fund= $buyer_fund[0]['Account']['available_funds']+$order[0]['Gig']['price'];
		$seller_acc['Account']['awaiting_funds']= $awt_fund;
		$buyer_acc['Account']['available_funds']=$avbl_fund;
		$buyer_acc['Account']['id']=$buyer_fund[0]['Account']['id'];	
		$seller_acc['Account']['id']=$seller_funds[0]['Account']['id']; 
		$this->Account->save($buyer_acc['Account']);
				$this->Account->save($seller_acc['Account']);
		}
		else if($this->data['status']=='Cancelled')
		{
$buyer_fund=$this->Account->find('all',array('conditions'=>array('Account.user_id'=>$userid)));
$transaction=$this->Transaction->find('all',array('conditions'=>array('Transaction.order_id'=>$id)));
			
$awt_fund=$seller_funds[0]['Account']['awaiting_funds']-$order[0]['Gig']['price'];		
//	     $avbl_fund= $buyer_fund[0]['Account']['available_funds']+$order[0]['Gig']['price'];
		     $avbl_fund= $buyer_fund[0]['Account']['available_funds']+$transaction[0]['Transaction']['amount'];
			
		$seller_acc['Account']['awaiting_funds']= $awt_fund;
		$buyer_acc['Account']['available_funds']=$avbl_fund;
		$buyer_acc['Account']['id']=$buyer_fund[0]['Account']['id'];	
		$seller_acc['Account']['id']=$seller_funds[0]['Account']['id']; 
		$this->Account->save($buyer_acc['Account']);
				$this->Account->save($seller_acc['Account']);
		}
			$ord['Order']=$this->data;
			$ord['Order']['id']=$id;
			$this->Order->save($ord['Order']);
			$this->redirect('orders');
			}
		}
		function work($workstatus=NULL)
		{
			if($workstatus==NULL)
			{
				$workstatus='Pending';
			}
	
			$this->checkSession();
			$this->set('workstatus',$workstatus);
			$Order_status['Pending']=$this->Order->find('count',array('conditions'=>array('Order.seller_id'=>$this->Session->read('User.id'),'Order.status'=>'Pending')));
			$Order_status['Active']=$this->Order->find('count',array('conditions'=>array('Order.seller_id'=>$this->Session->read('User.id'),'Order.status'=>'Active')));
			$Order_status['Delivered']=$this->Order->find('count',array('conditions'=>array('Order.seller_id'=>$this->Session->read('User.id'),'Order.status'=>'Delivered')));
			$Order_status['Completed']=$this->Order->find('count',array('conditions'=>array('Order.seller_id'=>$this->Session->read('User.id'),'Order.status'=>'Completed')));
			$Order_status['Cancelled']=$this->Order->find('count',array('conditions'=>array('Order.seller_id'=>$this->Session->read('User.id'),'Order.status'=>'Cancelled')));
			$this->set('Order_status',$Order_status);
			$this->paginate=array('conditions'=>array('Order.seller_id'=>$this->Session->read('User.id'),'Order.status'=>$workstatus),'limit'=>15);
			$orders=$this->paginate('Order');
		/*	echo '<pre>';
			print_r($orders);
			die;
			echo '</pre>';*/	
			$this->set('orders',$orders);
}
	
	function orderreview()
	{
		$status=$this->Session->read('status');
			$this->checkSession();
		    $user=$this->Session->read('User');
			
	 $this->paginate=$this->Review->query("select * from reviews,orders,gigs,users where reviews.order_id=orders.id and orders.user_id=".$user['id']." and orders.gig_id=gigs.id and gigs.user_id=users.id LIMIT 6 ");

$this->Review->unbindModel(array('belongsTo' => array('Order')),false);
$options['joins'] = array(
								   array('table' => 'orders',
                                         'alias' => 'Order',
                                         'type' => 'INNER',
                                         'conditions' => array('Review.order_id=Order.id')),
                                   array('table' => 'gigs',
                                         'alias' => 'Gig',
                                         'type' => 'INNER',
                                         'conditions' => array('Gig.id=Order.gig_id')),
                                   array('table' => 'users',
                                         'alias' => 'User',
                                         'type' => 'INNER',
                                         'conditions' => array('User.id=Order.seller_id'))
                                                                        );
$options['fields']=array('*');
$options['conditions']=array('Gig.status'=>'Active','Order.user_id' => $user['id']);
$options['limit']='15';
$this->paginate=$options;
	 $orders=$this->paginate('Review');
	echo '<pre>';
	print_r($orders);
	die;
	echo '</pre>';
	 if(!empty($orders))
	 {
	$this->set('orders',$orders);
	 }
	 else
	 {
		  $this->Session->setFlash('No Records Found !');
	 }
	}

function editmanagework($id=NULL,$wstatus=NULL)
 {
		
   $this->checkSession();
   $this->set('wstatus',$wstatus);
   $order=$this->Order->find('all',array('conditions'=>array('Order.id'=>$id)));
   $this->set('order',$order);
 
   if(!empty($this->data))
	{
	  $userid=$this->Session->read('User.id');
	$funds=$this->Account->find('all',array('conditions'=>array('Account.user_id'=>$userid)));	
	  if($this->data['status']=='Active')
	   {
		   
		 $awt_fund=$funds[0]['Account']['awaiting_funds']-$order[0]['Gig']['price'];		
	     $up_fund= $funds[0]['Account']['upcoming_funds']+$order[0]['Gig']['price'];
		$acc['Account']['awaiting_funds']= $awt_fund;
		$acc['Account']['upcoming_funds']=$up_fund;	
		$acc['Account']['id']=$funds[0]['Account']['id']; 
		
		}
		else if($this->data['status']=='Cancelled')
		{
			$transaction=$this->Transaction->find('all',array('conditions'=>array('Transaction.order_id'=>$id)));
			
			$buyer_fund=$this->Account->find('all',array('conditions'=>array('Account.user_id'=>$order[0]['Order']['user_id'])));
		  $awt_fund=$funds[0]['Account']['awaiting_funds']-$order[0]['Gig']['price'];		
	    // $avbl_fund= $buyer_fund[0]['Account']['available_funds']+$order[0]['Gig']['price'];
		$avbl_fund= $buyer_fund[0]['Account']['available_funds']+$transaction[0]['Transaction']['amount'];
		$acc['Account']['awaiting_funds']= $awt_fund;
		$buyer_acc['Account']['available_funds']=$avbl_fund;
		$buyer_acc['Account']['id']=$buyer[0]['Account']['id'];	
		$acc['Account']['id']=$funds[0]['Account']['id']; 
		$this->Account->save($buyer_acc['Account']);
		}
		
			
			$ord['Order']=$this->data;
			$ord['Order']['id']=$id;
			$this->Order->save($ord['Order']);
			$this->Account->save($acc['Account']);
			$this->redirect('work');
			}
	}
	
// Balance Ammount in the account on Seller	
	function balance()
	{
	 $this->paginate = array('conditions' => array( "OR" => array ("Transaction.user_id" => $this->Session->read('User.id'),	"Transaction.receiver_id" =>$this->Session->read('User.id'))),'limit' =>'10','order' => array('Transaction.id' => 'DESC'));
	 $Order =$this->paginate('Transaction'); 
	 $this->set('Order',$Order);
	 $Account=$this->Account->findbyUser_id($this->Session->read('User.id')); 
	 $this->set('Account',$Account);
	}
	
	
	function compose($user_id=NULL,$rec_id=NULL)
	{
	
	  $this->checkSession();
	  $user=$this->User->findById($user_id);
	
	  $this->set('user',$user);
	 
	  $gig=$this->Recommend->findById($rec_id);
      $this->set('gig',$gig);
if(!empty($this->data))
  {
	 
   	$gigs['Message']=$this->data;
	$sent['Sentmessage']=$this->data;
	$gigs['Message']['from_users_id']=$user['User']['id'];
	$gigs['Message']['to_users_id']=$gig['Gig']['user_id'];
	$gigs['Message']['recommend_id']=$gig['Recommend']['id'];
	$gigs['Message']['date']=date('Y-m-d');
	$sent['Sentmessage']['sender_id']=$user['User']['id'];
	$sent['Sentmessage']['reciever_id']=$gig['Gig']['user_id'];
	$sent['Sentmessage']['recommend_id']=$gig['Recommend']['id'];
	$sent['Sentmessage']['date']=date('Y-m-d');
			
	if(!empty($this->data['attachment']['name']))
	   {
		if(strlen($this->data['attachment']['name'])>4)
		  {
			$uploaddir =  WWW_ROOT."uploads/attachment/";

	////////// Make sure the required directories exist, and create them if necessary/////////
             if(!is_dir($uploaddir))
			  {
				mkdir($uploaddir,true);
			  }
			
			$filetype = $this->getFileExtension($this->data['attachment']['name']);

			$filename= $this->data['attachment']['name'];
						
	///////// Generate a unique name for the image (from the timestamp)/////////
         /*   $id_unic = str_replace(".", "", strtotime ("now"));
                            
            $resizedfile = $uploaddir.$id_unic.".".$filetype;*/
			$resizedfile = $uploaddir.$filename;
					
			if (is_uploaded_file($this->data['attachment']['tmp_name']))
              {
	
				if(!move_uploaded_file($this->data['attachment']['tmp_name'],$resizedfile))
					{
							$this->Session->setFlash('Error Uploading File!.');
							$this->redirect('compose');
                       		exit();
					}

	/////////// Delete the temporary image  ////////////////////
                 unlink($this->data['attachment']['tmp_name']);
   /////////////// image File path/////////////////////////////
					//$gigs['Message']['attachment'] = $id_unic.".".$filetype;	
					$gigs['Message']['attachment'] = $filename;	
					$sent['Sentmessage']['attachment']=$filename;
				}
            }
		}
		else
		{
			$gigs['Message']['attachment']="";
			$sent['Sentmessage']['attachment']="";
		}
			
  /*  echo '<pre>';
	print_r($gigs);
	die;
	echo '</pre>';*/
	
			$this->Message->save($gigs['Message']);
			$this->Sentmessage->save($sent['Sentmessage']);
			$this->Session->setFlash('Successfully Sent !!!!');
			$this->redirect('/gigs/index');
		  }
	}
	
	
	
	######## List of Recommendation #######
	function recommendedlist($count=NULL) {
		 if ($this->Session->check('User'))
        {	
		$conditions=array('Recommend.user_id !=' =>$this->Session->read("User.id"));
		}
		else
		{
		$conditions=array('User.status'=>'Active');
		}
		
		  $this->Recommend->recursive = 0;
		  $this->paginate['Recommend']['conditions'] =$conditions;
		  $this->paginate['Recommend']['fields']=array('*');
		  $this->paginate['Recommend']['order'] = 'Recommend.id DESC';
		  $this->paginate['Recommend']['limit']=$count;
		  $recommendedlist=$this->paginate('Recommend');
		
		  return $recommendedlist;
		  
		  
		  
		
/*$recommendedlist=$this->Recommend->find('all', array('conditions' =>$conditions,'order' => array('Recommend.id DESC'),'limit' => 10));	*/
	//$this->set('recommendlist',$recommendedlist);
/*	 print_r($recommendlist);
  die;*/
	}
	
	##########  load More video in latest  #########
	function loadMore($page =1){		
		$this->layout = 'ajax';
		if ($this->Session->check('User'))
        {	
		$conditions=array('Recommend.user_id !=' =>$this->Session->read("User.id"));
		}
		else
		{
		$conditions=array('User.status'=>'Active');
		}
		$param = array('conditions' => $conditions,
					   'limit'=>(($page)*5).",5",'order' => array(
                    'Recommend.id' => 'desc'));
		
		$recommendedlist = $this->Recommend->find('all',$param);  
		
		$this->set('recommendlist',$recommendedlist); 
		$this->set('nextpage',$page+1); 	
	}
		
		function reply($id=NULL,$rcvr_id)
	{
	   $this->checkSession();
	 $user=$this->Session->read('User.id');
$msg=$this->Message->find('all',array('conditions'=>array('Message.id="'.$id.'" AND (Message.from_users_id="'.$user.'" OR Message.to_users_id="'.$user.'")')));
	
$parent=$this->Message->find('first',array('conditions'=>array('Message.parent_id'=>$id),'fields'=>'Message.parent_id'));
if(!empty($this->data))
  {
	
   	$gigs['Message']=$this->data;
	$sent['Sentmessage']=$this->data;
	$gigs['Message']['gigs_id']=$msg[0]['Message']['gigs_id'];
	$gigs['Message']['subject']=$msg[0]['Message']['subject'];
	$gigs['Message']['message_type']='R';
	$gigs['Message']['from_users_id']=$user;
	$gigs['Message']['to_users_id']=$rcvr_id;
	$gigs['Message']['message_id']=$msg[0]['Message']['id'];
	$gigs['Message']['date']=date('Y-m-d h:i:s');
	$sent['Sentmessage']['gigs_id']=$msg[0]['Message']['gigs_id'];
	$sent['Sentmessage']['subject']=$msg[0]['Message']['subject'];
	$sent['Sentmessage']['sender_id']=$user;
	$sent['Sentmessage']['message_type']='R';
	$sent['Sentmessage']['reciever_id']=$rcvr_id;
	$sent['Sentmessage']['message_id']=$msg[0]['Message']['id'];
	$sent['Sentmessage']['date']=date('Y-m-d h:i:s');
			
	if(!empty($this->data['attachment']['name']))
	   {
		   
		if(strlen($this->data['attachment']['name'])>4)
		  {
			$uploaddir =  WWW_ROOT."uploads/attachment/";

	////////// Make sure the required directories exist, and create them if necessary/////////
             if(!is_dir($uploaddir))
			  {
				mkdir($uploaddir,true);
			  }
			
			$filetype = $this->getFileExtension($this->data['attachment']['name']);

			$filename= $this->data['attachment']['name'];
						
	///////// Generate a unique name for the image (from the timestamp)/////////
         /*   $id_unic = str_replace(".", "", strtotime ("now"));
                            
            $resizedfile = $uploaddir.$id_unic.".".$filetype;*/
			$resizedfile = $uploaddir.$filename;
				
			
			if (is_uploaded_file($this->data['attachment']['tmp_name']))
              {
	
				if(!move_uploaded_file($this->data['attachment']['tmp_name'],$resizedfile))
					{
							$this->Session->setFlash('Error Uploading File!.');
							$this->redirect('compose');
                       		exit();
					}

	/////////// Delete the temporary image  ////////////////////
               unlink($this->data['attachment']['tmp_name']);
   /////////////// image File path/////////////////////////////
					//$gigs['Message']['attachment'] = $id_unic.".".$filetype;	
					$gigs['Message']['attachment'] = $filename;	
					$sent['Sentmessage']['attachment'] = $filename;	
				}
            }
		}
		else
		{
			$gigs['Message']['attachment']="";
			$sent['Sentmessage']['attachment']="";
		}
			
 /*echo '<pre>';
	print_r($this->Message->save($up));
	die;*/
	
			$this->Message->save($gigs['Message']);
			$this->Sentmessage->save($sent['Sentmessage']);
           
  if($parent==0 && $parent != $id)
  {
	  
	  $gigs['Message']['parent_id']=$id;
	  $gigs['Message']['message_id']=0;
	  $this->Message->create();
	  $this->Message->save($gigs['Message']);
	  $sent['Sentmessage']['parent_id']=$id;
	  $sent['Sentmessage']['message_id']=0;
	  $this->Sentmessage->create();
	  $this->Sentmessage->save($sent['Message']);
	  
  }
  if($msg[0]['Message']['to_users_id']==$user)
  {

 $sta= $this->Message->find('first',array('conditions'=>array('Message.parent_id'=>$id)));
	$up['Message']['id']=$sta ['Message']['id'];
	$up['Message']['status']='unread';
  $this->Message->create();
  $this->Message->save($up['Message']);

	  
  }
  else if($msg[0]['Message']['from_users_id']==$user)
  {
	 
 $up['Message']['id']=$id;
	$up['Message']['status']='unread';
  $this->Message->create();
  $this->Message->save($up['Message']);
  }
			#$this->redirect('/users/inbox');
			$this->redirect($this->referer(null, true)); 
			 
  }
	}
 

    function tw_authorize() {
		
		ini_set('include_path', ini_get('include_path').PATH_SEPARATOR . APP. 'vendors');
		App::import('Vendor', 'Zend_Loader', true, false, 'Zend/Loader.php');
		Zend_Loader::loadClass('Zend_Oauth');
		Zend_Loader::loadClass('Zend_Oauth_Consumer');

		$app_url = $this->getAppURL();
		$options = array(
			'callbackUrl' => $app_url.'/users/tw_callback',
			'siteUrl' => 'http://twitter.com/oauth',
			'consumerKey' => 'z5dxI5ypcifv8lcqy6Kiw',
			'consumerSecret' =>  'rsRPdXtSg55yebo071rwmkd8QswWSeLlqE9mTk'
		);  
		$consumer = new Zend_Oauth_Consumer($options);		
		// fetch a request token
		$token = $consumer->getRequestToken();
		// persist the token to storage
		$_SESSION['TWITTER_REQUEST_TOKEN'] = serialize($token);
		// redirect the user
		$consumer->redirect();
	}

  /*  function tw_callback()
	 {
		ini_set('include_path', ini_get('include_path').PATH_SEPARATOR . APP. 'vendors');
		App::import('Vendor', 'Zend_Loader', true, false, 'Zend/Loader.php');
		Zend_Loader::loadClass('Zend_Oauth');
		Zend_Loader::loadClass('Zend_Oauth_Consumer');
		Zend_Loader::loadClass('Zend_Json');

		$app_url = $this->getAppURL();
		$options = array(
          'callbackUrl' => $app_url.'/users/tw_callback',
          'siteUrl' => 'http://twitter.com/oauth',
          'consumerKey' => 'z5dxI5ypcifv8lcqy6Kiw',
          'consumerSecret' => 'rsRPdXtSg55yebo071rwmkd8QswWSeLlqE9mTk'
		);  
		$consumer = new Zend_Oauth_Consumer($options);	
		
		if (!empty($_GET) && isset($_SESSION['TWITTER_REQUEST_TOKEN'])) {
			if (!isset($_GET['denied'])) {
				$token = $consumer->getAccessToken($_GET, unserialize($_SESSION['TWITTER_REQUEST_TOKEN']));
				$_SESSION['TWITTER_ACCESS_TOKEN'] = serialize($token);
				//$token = unserialize($_SESSION['TWITTER_ACCESS_TOKEN']);
				# Now that we have an Access Token, we can discard the Request Token
				$_SESSION['TWITTER_REQUEST_TOKEN'] = null;
				//check user on users table by tw_id
				$user = $this->User->find('first', array('conditions' => array('User.tw_id' =>$token->user_id)));


				//if empty/ not found then insert into table
				if(empty($user))
				{
					# store access token into current user's record
					 $this->data['User']['tw_id'] =$token->user_id;
					 $this->data['User']['active']= 1;
					$this->data['User']['password']=$this->randomString();
					$this->data['User']['username'] =$token->user_id;
					$this->data['User']['name'] = $token->screen_name;
					$this->data['User']['tw_access_token'] = $token->oauth_token;
					$this->data['User']['tw_access_secret'] = $token->oauth_token_secret;
					
						if ($this->User->save($this->data)) 
						{
							#$post_id = $this->Session->read('post_id');
							#$this->Session->delete('post_id');
						$this->Session->write('tw_user',$token->screen_name);
        						$this->redirect('/gigs/index');	
						}
					
	}


				else 
				{
					
/*$this->Session->setFlash(__('<font color="red">Some other user has already added this twitter account.</font>', true));*/
	/*				$this->Session->write('tw_user',$token->screen_name);
                                                        $this->redirect('/gigs/index');
		}
			} else 
			{
				$this->Session->setFlash(__('<font color="red">You denied access to your twitter account.</font>', true));
				$this->redirect('/gigs/index');	
			}
		} else {
			// Mistaken request? Some malfeasant trying something?
			$this->Session->setFlash('<font color="red">Invalid callback request.</font>');
			$this->redirect('/gigs/index');
		}
	}*/

 function tw_callback()
	 {
		ini_set('include_path', ini_get('include_path').PATH_SEPARATOR . APP. 'vendors');
		App::import('Vendor', 'Zend_Loader', true, false, 'Zend/Loader.php');
		Zend_Loader::loadClass('Zend_Oauth');
		Zend_Loader::loadClass('Zend_Oauth_Consumer');
		Zend_Loader::loadClass('Zend_Json');

		$app_url = $this->getAppURL();
		$options = array(
          'callbackUrl' => $app_url.'/users/tw_callback',
          'siteUrl' => 'http://twitter.com/oauth',
          'consumerKey' => 'z5dxI5ypcifv8lcqy6Kiw',
          'consumerSecret' => 'rsRPdXtSg55yebo071rwmkd8QswWSeLlqE9mTk'
		);  
		$consumer = new Zend_Oauth_Consumer($options);	
		
		if (!empty($_GET) && isset($_SESSION['TWITTER_REQUEST_TOKEN'])) {
			if (!isset($_GET['denied'])) {
				$token = $consumer->getAccessToken($_GET, unserialize($_SESSION['TWITTER_REQUEST_TOKEN']));
				$_SESSION['TWITTER_ACCESS_TOKEN'] = serialize($token);
				//$token = unserialize($_SESSION['TWITTER_ACCESS_TOKEN']);
				# Now that we have an Access Token, we can discard the Request Token
				$_SESSION['TWITTER_REQUEST_TOKEN'] = null;
				//check user on users table by tw_id
		if(!empty($token))
		{			if(!$this->Session->check('User')) 
					{
				$user = $this->User->find('first', array('conditions' => array('User.tw_id' => $token->user_id,'User.status'=>'Active')));
				//if empty/ not found then insert into table
				if(empty($user))
				{
					# store access token into current user's record
					$this->data['User']['username'] = $token->user_id;
					$this->data['User']['password']=$this->randomString();
					$this->data['User']['active']=1 ;
					$this->data['User']['tw_id'] = $token->user_id;
					$this->data['User']['name'] = $token->screen_name;
					$this->data['User']['tw_access_token'] = $token->oauth_token;
					$this->data['User']['tw_access_secret'] = $token->oauth_token_secret;
					
						if ($this->User->save($this->data)) 
						{
							$this->Session->setFlash("Your Account has been created successfully");
							#$post_id = $this->Session->read('post_id');
							$u = $this->User->read();
						$this->setSession($u['User']);
								$this->redirect('/gigs/index');
								
						}
					
				} 
				else{
							
						$this->setSession($user['User']);
						
							$this->redirect('/gigs/index');
						} 
				           
			}
			
					
			
			else
					{
						
						if ($this->Session->check('User'))
						{ 
							$tw_user = $this->User->find('first',array('conditions' => array('User.tw_id' => $token->user_id,'User.status'=>'Active')));
							if (is_array($tw_user))
							{
								$this->setSession($tw_user['User']);
								
								
								$this->redirect('/gigs/index');
							}
						}	
					}
			}
			}
			else 
			{
				$this->Session->setFlash(__('<font color="red">You denied access to your twitter account.</font>', true));
				$this->redirect('/gigs/index');	
			}
		} else {
			// Mistaken request? Some malfeasant trying something?
			$this->Session->setFlash('<font color="red">Invalid callback request.</font>');
			$this->redirect('/gigs/index');
		}
	}
/************ Twitter Integration Ends Here ****************/

}
?>
