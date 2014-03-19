 <?php
#App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));
class TestsController extends AppController
{
	var $name = 'Tests';
	var $helpers = array('Html', 'Form', 'Javascript','Session','Ajax');
	var $components = array('Session', 'Twitter');
	var $uses = array();
	
	function getAppURL() {
		$hostURL = 'http';
		if (isset($_SERVER['HTTPS'])) {
			$pageURL .= 's';
		}
		$hostURL .= '://'.$_SERVER['HTTP_HOST']; 
		return $hostURL;
	}
	
    function tw_authorize() {
		$this->layout=false;
		$app_url = $this->getAppURL();
		$callbackUrl=$app_url.'/tests/tw_callback';
		$consumer_key = 'z5dxI5ypcifv8lcqy6Kiw';
		$consumer_secret='rsRPdXtSg55yebo071rwmkd8QswWSeLlqE9mTk';
		$this->Twitter->setup($consumer_key, $consumer_secret, false);
		$this->Twitter->connect($callbackUrl);
		exit;
	}
 function tw_callback()
	 {
		$this->layout=false;
		$app_url = $this->getAppURL();
		$callbackUrl=$app_url.'/users/tw_callback';
		$consumer_key = 'z5dxI5ypcifv8lcqy6Kiw';
		$consumer_secret='rsRPdXtSg55yebo071rwmkd8QswWSeLlqE9mTk';
		$this->Twitter->setup($consumer_key, $consumer_secret, false);
		$this->Twitter->callback($_REQUEST['oauth_token'], $_REQUEST['oauth_verifier']);
		print_r($_SESSION);exit;
		
		
		
		if (!empty($_GET) && isset($_SESSION['TWITTER_REQUEST_TOKEN'])) {
			if (!isset($_GET['denied'])) {
				$token = $consumer->getAccessToken($_GET, unserialize($_SESSION['TWITTER_REQUEST_TOKEN']));
				$_SESSION['TWITTER_ACCESS_TOKEN'] = serialize($token);
				//$token = unserialize($_SESSION['TWITTER_ACCESS_TOKEN']);
				# Now that we have an Access Token, we can discard the Request Token
				$_SESSION['TWITTER_REQUEST_TOKEN'] = null;
				//check user on users table by tw_id
		if(!empty($token))
		{
		
			if(!$this->Session->check('User')) 
					{
				$user = $this->User->find('first', array('conditions' => array('User.tw_id' => $token->user_id)));
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
							$tw_user = $this->User->find('first',array('conditions' => array('User.tw_id' => $token->user_id)));
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