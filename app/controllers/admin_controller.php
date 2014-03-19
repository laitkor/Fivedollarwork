<?php
class AdminController extends AppController
{
	var $name = 'Admin';
	var $helpers = array('Html', 'Form', 'Javascript','Session','Ajax');
	var $components = array('Session', 'Email','RequestHandler');
	var $uses = array('Gig','User','Category','Gigsprice','Recommend','Setting','Content','Order','Like','Withdraw','Rating');
	var $layout = "admin";  //this will use the layout 
	var $paginate;    //defining the pagination defaults in the $paginate controller variable


function index()
	{
		$this->checkadminSession();
		$this->paginate = array('limit' =>6,'conditions'=>array('User.user_type'=>'User','User.status !='=> 'Deleted'),'order' => array('User.id' => 'DESC'));
	    $user =$this->paginate('User');
#	$user=$this->User->find('all',array('conditions'=>array('User.user_type'=>'User')));
$this->set('user',$user);
	
	}

	
	#######  Check User Session ##########
	 function checkadminSession($send_return = false)
    {
        if (!$this->Session->check('Admin'))
        {			
            $this->Session->setFlash('Please login first!');
			  if(!$send_return){
			// Force the user to login
            $this->redirect('/'); 
            exit();
			  }
			  else
			  {
				  return true;
			  }
        }
		else
		{
			 //update updated date and time record  in users table
			 $record=$this->Session->read('Admin.id');
			 $result=$this->User->query("update users set updated = '".date("Y-m-d H:i:s")."' where id = '".$record."' ");
			  
		}
    } 




	########  Admin Change Password #######
function changepassword() {
		//Checking user login
		$this->checkadminSession();
	  $record=$this->Session->read(); //read session values
			    if (!empty($this->data)) { 		 
			  $user=$this->User->findByUsername($record['Admin']['username']);
			   if (!empty($user)) {
				//check password is correct or not
				if(md5($this->data['password']) == $user['User']['password']){
		        //query for update new password	
			    $result=$this->User->query("update users set password='".md5($this->data['newpassword'])."', updated = '".date("Y-m-d H:i:s")."' where username ='".$record['Admin']['username']."'");
				$us=$this->User->findByUsername($record['Admin']['username']);
				   $this->setadminSession($us['User']);
                   $this->Session->setFlash('You have successfully changed your password!');
				}else {
				      //Set Error for invalid password
					$this->Session->setFlash("Invalid Password!");
				}
			}
		 }

	}
	
		########  Change Website Title #######
	function changetitle() {
		$this->checkadminSession();
		if(!empty($this->data))
		{
			$this->Setting->query("update settings set title = '".$this->data['title']."' where id = '1' ");
           	$this->Session->setFlash('You have successfully changed Website Title!');
			$this->redirect('/admin/changetitle'); 
		}
	}
	
		########  Change Website Logo #######
	function changelogo() {
		$this->checkadminSession();
		if(!empty($this->data))
		{
					if(!empty($this->data['showlogo']) and $this->data['showlogo']=='1')
					{
					$condition['show_logo'] = $this->data['showlogo'];
					}
					else
					{
					$condition['show_logo'] = '0';
					}
		if(!empty($this->data['logo']))
		{
					if(strlen($this->data['logo']['name'])>4){
			$uploaddir =  WWW_ROOT."uploads/";
			
			// Make sure the required directories exist, and create them if necessary
           if(!is_dir($uploaddir)){mkdir($uploaddir,true);}
			
			$filetype = $this->getFileExtension($this->data['logo']['name']);
            $filetype = strtolower($filetype);
			 if (($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png"))
                    {
				$this->Session->setFlash("Please enter a value with a valid extension.");
				$this->redirect('/admin/changelogo');
                    }
                    else
                    {
                        // Get the logo size
                        list($width, $height, $type, $attr)= getimagesize($this->data['logo']['tmp_name']);
					$filename = "logo";
                    $filename.= ".";
                    $filename.=$filetype;
                    $resizedfile = $uploaddir.$filename;
					if (is_uploaded_file($this->data['logo']['tmp_name']))
                    {
					if($height<45)
					{
						if(!move_uploaded_file($this->data['logo']['tmp_name'],$resizedfile))
						{
							$this->Session->setFlash('Error Uploading File!.');
							$this->redirect('/admin/changelogo');
                       		exit();
						}
					}
					else
					{
                    $this->resize_img($this->data['logo']['tmp_name'], 45, $resizedfile,$filetype);         }
						//}
                     // Delete the temporary logo
                    unlink($this->data['logo']['tmp_name']);
					// logo File path
					$condition['logo'] = $filename;
					}
					}
					}
					$condition['id'] = '1';
					if ($this->Setting->save($condition))
					{
					$this->Session->setFlash('You have successfully changed Website Logo!');
					$this->redirect('/admin/changelogo');
					}else {
						$error_msg = ($this->Setting->invalidFields());
						$this->Session->setFlash($error_msg);
						$this->redirect('/admin/changelogo');
					}

		}	
		}
	}
	
		########  List Website Page Content #######
	function cms() {
		$this->checkadminSession();
		$content=$this->Content->find('all',array('order' => array('Content.id' => 'ASC')));
		$this->set('content',$content);
	}
		########  Edit Website Page Content #######
	function editcms($id=NULL) {
		$this->checkadminSession();
		if(!empty($this->data))
		{
		$this->Setting->query("update contents set content = '".mysql_real_escape_string($this->data['cms_content'])."' where id = '".$id."' ");
           	$this->Session->setFlash('You have successfully changed Page Content!');
			$this->redirect('/admin/editcms/'.$id); 	
			}
		$content=$this->Content->findbyId($id);
		$this->set('content',$content);
	}
	
	
	########  Set Payment API Details of Paypal and Authorize.net #######
	function paypalid() {
		$this->checkadminSession();
		if(!empty($this->data))
		{
			$this->Setting->query("update settings set authorizenet_login='".$this->data['authorizenet_login']."', authorizenet_key='".$this->data['authorizenet_key']."' , paypal_username='".$this->data['paypal_username']."' , paypal_password='".$this->data['paypal_password']."' , paypal_signature='".$this->data['paypal_signature']."' where id = '1' ");
           	$this->Session->setFlash('You have successfully changed Payment API Details!');
			$this->redirect('/admin/paypalid'); 
		}
	}

	########  User Logout #######
	function signout()    {        
		$this->Session->delete('Admin');    
		$this->Session->setFlash('Successfully Sign Out');  
		$this->redirect('/');    
	}
	function deleteuser($id=NULL)
	{
	 $this->User->id=$id;
	  $this->User->status='Deleted';
	  $this->User->save($this->User);
	
	$gig= $this->Gig->query("update gigs set status='Deleted' where user_id='".$id."'");
	  $this->Like->deleteAll(array('Like.user_id'=>$id));
	   $this->Recommend->deleteAll(array('Recommend.user_id'=>$id));
	  //$this->redirect('index');
	  $this->redirect($this->referer(null, true)); 
	}
	function status($status,$id=NULL)
	{
		$user['User']=$this->data;
		if($status=='Active')
		{
		  
		  $user['User']['id']=$id;
		  $user['User']['status']='Inactive';
		 
		}
		else
		{
			 $user['User']['id']=$id;
		  $user['User']['status']='Active';

		}
		 $this->User->save($user);
		// $this->redirect('index');
		$this->redirect($this->referer(null, true)); 
	}
	function adminusers()
	{
		$this->checkadminSession();
		//$this->Session->setFlash('You have successfully changed your password!');
		//$this->redirect('/');
		$user=$this->User->find('all',array('conditions'=>array('User.user_type'=>'Modifier')));
		$this->set('user',$user);
	}
	function category()
	{
		$this->checkadminSession();
		$this->paginate = array('limit' =>6,'order' => array('Category.id' => 'ASC'));
		$cat=$this->paginate('Category');
		
		
	
		$this->set('category',$cat);
	}
	function deletecat($id=NULL)
	{
	 $this->Category->delete($id);
	//$this->redirect('category');
	$this->redirect($this->referer(null, true)); 
	}
	function addcategory()
	{
			$this->checkadminSession();
			if(!empty($this->data))
			{
				$category['Category']=$this->data;
				$this->Category->save($category);
			}
	}
	function editcat($id=NULL)
	{
		$this->checkadminSession();
		$cat=$this->Category->find('all',array('conditions'=>array('Category.id'=>$id)));
		$this->set('cat',$cat);
		if(!empty($this->data))
		{
			$cat['Category']=$this->data;
			$cat['Category']['id']=$id;

			$this->Category->save($cat);
			$this->redirect('category');
		}
		
		
	}
	function gigs()
	{
		
		$this->paginate = array('conditions'=>array('Gig.status !='=>'Deleted'),'limit' =>6,'order' => array('Gig.id' => 'ASC'));
	    $gig =$this->paginate('Gig');
		
		$this->set('gig',$gig);
	}
	function recommend()
	{
		$this->checkadminSession();
		$this->paginate = array('limit' =>6,'order' => array('Recommend.id' => 'ASC'));
		$rec=$this->paginate('Recommend');
		$this->set('recommend',$rec);
		
	}
	function delrecommend($id=NULL)
	{
	  $this->Recommend->delete($id);
	 // $this->redirect('recommend');
	 $this->redirect($this->referer(null, true)); 
	}
	function multiplegigs()
	{
	$this->paginate = array('limit' =>6 ,'order' => array('Gigsprice.id' => 'ASC'));
	 $gigprice= $this->paginate('Gigsprice');
	 $this->set('gigprice',$gigprice);
	 
	}
	function delgigprice($id=NULL)
	{
	 $this->Gigsprice->delete($id);
	// $this->redirect('multiplegigs');
	$this->redirect($this->referer(null, true)); 
	}
	function addmultiplegigs()
	{
		if(!empty($this->data))
		{
			if($this->data['price'] > 0 && $this->data['price'] < 5)
			{
	          $this->Session->setFlash('Gigs Price Should Be More Than 5$ <br />Please Enter Again');         
			}
			else
			{
			   $this->Gigsprice->save($this->data);
	  $this->Session->setFlash('Successfully Added');
			}
		}
	}
	function commission()
	{
	 $comm=$this->Setting->find('all');
	 $this->set('comm',$comm);
	 if(!empty($this->data))
	 {
		
		 $com['Setting']=$this->data;
		 
		$com['Setting']['id']=$comm['0']['Setting']['id'];
	   $this->Setting->save($com['Setting']);
	   $this->Session->setFlash('Successfully Updated!!!');
	   $this->redirect('commission');
	 }
	}
	function deletegig($id=NULL)
	{
		$this->Gig->query("update gigs set status='Deleted' where id='".$id."'");
		$this->Like->deleteAll(array('Like.gig_id'=>$id));
		$this->Rating->deleteAll(array('Rating.gig_id'=>$id));
		//$this->redirect('gigs');
		$this->redirect($this->referer(null, true)); 
	}
	function featured($id=NULL)
	{
		$gigid=$this->Gig->find('first',array('conditions'=>array('Gig.id'=>$id)));
		$gigid['Gig']['id']=$id;
		if($gigid['Gig']['featured']=='Y')
		{
			$gigid['Gig']['featured']='N';
		}
		else
		{
			$gigid['Gig']['featured']='Y';
		}
		$this->Gig->save($gigid);
		/*$this->redirect('gigs');*/
		$this->redirect($this->referer(null, true)); 
	}
	function orders()
	{
	  $this->checkadminSession();
	  $this->paginate=array('conditions'=>array('Order.status !='=>'Cancelled'),'limit'=>6,'order' => array('Order.id' => 'ASC'));
	  $orders=$this->paginate('Order'); 
	  
			 $this->set('orders',$orders); 
			
		  	
	}
	function deleteorder($id=NULL)
	{
		$order=$this->Order->find('all',array('conditions'=>array('Order.id'=>$id,'Order.status !='=>'Cancelled')));
		$orders['Order']=$order;
		$orders['Order']['id']=$id;
		$orders['Order']['status']='Cancelled';
		$this->Order->save($orders);
		$this->redirect('orders');
		
	}
	
	########  Withdraw Request #######
	function transaction() {
	  $this->checkadminSession();
	  $this->paginate = array('conditions' => array("Withdraw.status" =>'Pending'),'limit' =>'15','order' => array('Withdraw.id' => 'DESC'));
	 $Withdraw =$this->paginate('Withdraw'); 
	 $this->set('Withdraw',$Withdraw);
	}
	########  Pay Withdraw Amount #######
	function payout($id=NULL) {
		$this->checkadminSession();
		$Withdraw =$this->Withdraw->findbyId($id); 
		if(!empty($Withdraw))
		{
			$this->set('withdraw',$Withdraw);
			if(!empty($this->data))
			{
			$this->data['id']=$Withdraw['Withdraw']['id'];
			$this->data['payble_amount']=($Withdraw['Withdraw']['amount']-$this->data['commission']);
			$this->data['payout_datetime']=date('Y-m-d H:i:s',time());
			$this->data['status']='Completed';
			 	if($this->Withdraw->save($this->data))
				{
					$this->Session->setFlash("Withdraw request payment made succesfully.");
					$this->redirect('/admin/transaction');								
				}
				else
				{
					$this->Session->setFlash("Withdraw request payment made Unsuccesfully.");
					$this->redirect('/admin/transaction');								
				}
			}
		}
		else
		{
			$this->Session->setFlash("Invalid Withdraw Request Details!");
			$this->redirect('/admin/transaction');								
		}
	}

	
}
?>