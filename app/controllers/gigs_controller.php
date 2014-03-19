<?php

class GigsController extends AppController
{
    var $name = 'Gigs';
	var $helpers = array('Html', 'Form', 'Javascript','Session','Ajax');
	var $components = array('Session', 'Email','RequestHandler');
	var $uses = array('Gig','User','Category','Gigsprice','Content','Message','Like','Rating','Sentmessage');
	var $paginate;
	/*function beforeFilter()
    {	
		parent::beforeFilter();

	}*/
	// List of Gigs 
	function index()
	{
				$this->Session->write('Tab','index');
		
		$this->paginate = array('conditions' =>array('Gig.status'=>'active','User.status'=>'Active'), 'limit' =>6);
		$gig =$this->paginate('Gig'); 
			
			 $user_id=$this->Session->read('User.id');
			$like=$this->Like->find('all',array('conditions'=>
			array('Like.user_id'=>$user_id)));
			
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
			}
			$this->set('like',$like);

		foreach($gig as $LK =>$VL)
			{
			
				$seaLIKE = $VL['Gig']['id'];
				if (isset($newLike) && array_key_exists($seaLIKE,$newLike))
				{ 
					if($newLike[$seaLIKE] = $user_id )
					$gig[$LK]['Gig']['like_user'] = $newLike[$seaLIKE];	
				}

			
			}

 
	$this->set('allgigs',$gig);
	}
	
	
	// Display CMS Page
	function cms($id)
	{
	if(!empty($id))
	{
		$content=$this->Content->find('first', array('conditions' =>array('Content.id' => $id)));
		if(!empty($content))
		{
			$this->set('Content',$content);
		}
		else
		{
			$this->redirect('/');
		}
	}
	else
	{
		$this->redirect('/');
	}
	}
	
	// Customer Service Page
	function customerservice() {
		if(!empty($this->data))
		{
			$this->set('record',$this->data);
			$this->_sendUserMail('','Contact Help Desk','customerservice',$this->data['email'],'Y');
			$this->Session->setFlash('Your request had been send successfully');  
		}

	}
	
	// Invite Friend
	function invite() {
		
		if(!empty($this->data))
		{
			$this->set('record',$this->data);
			$subject=$this->data['email'].' sent you an invitation to '.SITE_URL;
			$this->_sendUserMail('',$subject,'invite',$this->data['friendemail']);
			/*if($this->data['friendemail2']!='')
			{
			$this->_sendUserMail('',$subject,'invite',$this->data['friendemail2']);
			}
			if($this->data['friendemail3']!='')
			{
			$this->_sendUserMail('',$subject,'invite',$this->data['friendemail3']);
			}*/
			$this->Session->setFlash('Your email has been sent to your friend(s).');  
		}
	
	}
	function ordergig($id=NULL)
	{
	 $user_id=$this->Session->read('User.id');
	 $this->set('user_id',$user_id);
	  $gigId=$this->Gig->find('first',array('conditions'=>array('Gig.id'=>$id)));
		
	   $user_gig=$this->Gig->find('all',array('conditions'=>array('Gig.user_id'=>$gigId['User']['id'],'Gig.status'=>'Active','Gig.id !='=>$id),'limit'=>10,'order'=>'Gig.date DESC'));
		
		$rel_gig=$this->Gig->find('all',array('conditions'=>array('Gig.category_id'=>$gigId['Gig']['category_id'],'Gig.status'=>'Active','Gig.id !='=>$id),'limit'=>10,'order'=>'Gig.date DESC'));
		
		 $ago=$this->_ago(strtotime($gigId['Gig']['date']));
		
		$key=explode(',',$gigId['Gig']['keywords_tags']);
		
		$this->set('relgig',$rel_gig);
		$this->set('usersgig',$user_gig);
		$this->set('gigId',$gigId);
		 $this->set('ago',$ago);
		 $this->set('key',$key);
		
	}
	function compose($user_id=NULL,$gig_id=NULL)
	{
	$this->checkSession();
			
	  $user=$this->User->findById($user_id);
	
	  $this->set('user',$user);
	 
	  $gig=$this->Gig->findById($gig_id);
      $this->set('gig',$gig);
if(!empty($this->data))
  {
    $gigs['Message']=$this->data;
	$sent['Sentmessage']=$this->data;
	$gigs['Message']['from_users_id']=$user['User']['id'];
	$gigs['Message']['to_users_id']=$gig['Gig']['user_id'];
	$gigs['Message']['gigs_id']=$gig['Gig']['id'];
	$gigs['Message']['date']=date('Y-m-d h:i:s');
	$sent['Sentmessage']['sender_id']=$user['User']['id'];
	$sent['Sentmessage']['reciever_id']=$gig['Gig']['user_id'];
	$sent['Sentmessage']['gigs_id']=$gig['Gig']['id'];
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
               //  unlink($this->data['attachment']['tmp_name']);
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
			
  /*  echo '<pre>';
	print_r($gigs);
	die;
	echo '</pre>';*/
			$this->Message->save($gigs['Message']);
			$this->Sentmessage->save($sent['Sentmessage']);
			$this->Session->setFlash('Successfully Sent !!!!');
			$this->redirect('ordergig/'.$gig['Gig']['id']);
		  }
	}
	function like($id=NULL)
	{  
	#print_r($this->params); exit;
	#print_r($this->data);
	#die;
	    $user_id=$this->Session->read('User.id');
     	$likes['Like']=$this->data;
		$likes['Like']['user_id']=$user_id;
		$likes['Like']['gig_id']=$id;
		$this->Like->save($likes);
		$this->redirect($this->referer(null, true)); 
		#$this->redirect("/");
		//$tab= $this->Session->read('Tab');
		//$this->redirect($tab);

	}
	function unlike($id=NULL)
	{
		#print_r($this->params);
		#print_r($this->data);
		#die;
		$user_id=$this->Session->read('User.id');
		$this->Like->query("delete from likes where user_id='$user_id' and gig_id='$id'");
		$this->redirect($this->referer(null, true));
		//$tab= $this->Session->read('Tab');
		//$this->redirect($tab);
	}
	function mostpopular()
	{
				$this->Session->write('Tab','mostpopular');
				$this->Gig->unbindModel(array('belongsTo' => array('Category')),false);
				////////////////////////
				$this->paginate = array(
                    'conditions' => array('Gig.status'=>'Active','User.status'=>'Active'),
                    'fields'=>array('Gig.*','User.*','COUNT(`Like`.`gig_id`) as `entity_count`'),
                    'joins' => array('RIGHT JOIN `likes` AS `Like` ON `Like`.`gig_id` = `Gig`.`id`'),
                    'group' => '`Like`.`gig_id`',
					'order'=>'entity_count DESC',
					'limit'=>'6'                   
                );
				$gig =  $this->paginate('Gig');
				
               /*$this->Like->unbindModel(array('belongsTo' => array('Gig', 'User')),false);
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
$options['fields']=array('*',count('Like.gig_id').' AS cnt ');
$options['conditions']=array('Gig.status'=>'Active');
$options['group']=array('Like.gig_id');

$options['order']=array('cnt'=>'DESC');
$options['limit']='6';
$this->paginate=$options;
$data = $this->paginate('Like');*/
//$this->set('questions',$data);                        
	
     
	 
			 $user_id=$this->Session->read('User.id');
			$like=$this->Like->find('all',array('conditions'=>
			array('Like.user_id'=>$user_id)));
			#pr($like);
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
			}
			#pr($newLike);
	      foreach($gig as $LK =>$VL)
			{
				#pr($VL['Gig']['id']);	
				$seaLIKE = $VL['Gig']['id'];
				
				if (isset($newLike) && array_key_exists($seaLIKE,$newLike))
				{ #echo "vinod"; exit;
					if($newLike[$seaLIKE] = $user_id )
					$gig[$LK]['Gig']['like_user'] = $newLike[$seaLIKE];	
				}
			
			}
           $this->set('allgigs',$gig);

   $this->set('like',$like);

	}
	function category($id=NULL)
	{
		$this->Session->write('Tab','category/'.$id);
		 $this->paginate = array('conditions' =>array('Gig.status'=>'active','Gig.category_id'=>$id,'User.status'=>'Active'),'limit' =>6);
		$gig =$this->paginate('Gig'); 
			 $user_id=$this->Session->read('User.id');
			$like=$this->Like->find('all',array('conditions'=>
			array('Like.user_id'=>$user_id)));
			
			#pr($like);
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
			}
			#pr($newLike);
	foreach($gig as $LK =>$VL)
			{
				#pr($VL['Gig']['id']);	
				$seaLIKE = $VL['Gig']['id'];
				
				if (isset($newLike) && array_key_exists($seaLIKE,$newLike))
				{ #echo "vinod"; exit;
					if($newLike[$seaLIKE] = $user_id )
					$gig[$LK]['Gig']['like_user'] = $newLike[$seaLIKE];	
				}
			
			}
						$this->set('allgigs',$gig);
		

		   $this->set('like',$like);


	}
	function latest()
	{
		$this->Session->write('Tab','latest');
     		   $this->paginate = array('conditions' =>array('Gig.status'=>'active','User.status'=>'Active'),
	  'order'=>array('date desc'), 'limit' =>6);
		$gig =$this->paginate('Gig');
			 $user_id=$this->Session->read('User.id');
			$like=$this->Like->find('all',array('conditions'=>
			array('Like.user_id'=>$user_id)));
			
			#pr($like);
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
			}
			#pr($newLike);
	foreach($gig as $LK =>$VL)
			{
				#pr($VL['Gig']['id']);	
				$seaLIKE = $VL['Gig']['id'];
				
				if (isset($newLike) && array_key_exists($seaLIKE,$newLike))
				{ #echo "vinod"; exit;
					if($newLike[$seaLIKE] = $user_id )
					$gig[$LK]['Gig']['like_user'] = $newLike[$seaLIKE];	
				}
			
			}
						$this->set('allgigs',$gig);

		   $this->set('like',$like);
 
	
		
	}
	function searchgig()
	{
			$search=$this->data['search'];
			
			$this->set('search',$search);
			
			$dollar=strstr($search,'$');
			if($dollar==true)
			{
			  $search=substr($search,1);
			}
		$this->paginate = array('conditions'=>array('User.status'=>'Active','Gig.status'=>'active',
'OR'=>array('Gig.title LIKE '=>'%'.$search.'%','Gig.keywords_tags LIKE '=>'%'.$search.'%', 'Gig.description LIKE '=>'%'.$search.'%', 'Gig.price LIKE '=>'%'.$search.'%')), 'limit' =>6);
		$gig =$this->paginate('Gig');
		if(!empty($gig))
		{
			 $user_id=$this->Session->read('User.id');
			$like=$this->Like->find('all',array('conditions'=>
			array('Like.user_id'=>$user_id)));
			
			#pr($like);
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
			}
			#pr($newLike);
	foreach($gig as $LK =>$VL)
			{
				#pr($VL['Gig']['id']);	
				$seaLIKE = $VL['Gig']['id'];
				
				if (isset($newLike) && array_key_exists($seaLIKE,$newLike))
				{ #echo "vinod"; exit;
					if($newLike[$seaLIKE] = $user_id )
					$gig[$LK]['Gig']['like_user'] = $newLike[$seaLIKE];	
				}
			
			}
						$this->set('allgigs',$gig);

		   $this->set('like',$like);
 
	
		}
		else
		{
			$this->Session->setFlash('There has no gig found');
		}
	/*	$search=$this->data['search'];
$gig=$this->Gig->find('all',array('conditions'=>array(
'OR'=>array('Gig.title LIKE '=>'%'.$search.'%','Gig.keywords_tags LIKE '=>'%'.$search.'%', 'Gig.description LIKE '=>'%'.$search.'%', 'Gig.price LIKE '=>'%'.$search.'%'))));
#$gig=$this->Gig->query("select * from gigs WHERE title LIKE '%".$search."%' OR keywords_tags LIKE '%".$search."%' OR description LIKE '%".$search."%' OR price LIKE '%".$search."%'");
	
	
	$this->set('allgigs',$gig);*/
	}
	function bestrating()
	{
	  $this->Session->write('Tab','bestrating');
        $this->paginate = array('conditions'=>array('User.status'=>'Active','Gig.status'=>'active'),'order'=>array('ratingavg desc'), 'limit' =>6);
		$gig =$this->paginate('Rating');
		$user_id=$this->Session->read('User.id');
			$like=$this->Like->find('all',array('conditions'=>
			array('Like.user_id'=>$user_id)));
			
			#pr($like);
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
			}
			#pr($newLike);
	foreach($gig as $LK =>$VL)
			{
				#pr($VL['Gig']['id']);	
				$seaLIKE = $VL['Gig']['id'];
				
				if (isset($newLike) && array_key_exists($seaLIKE,$newLike))
				{ #echo "vinod"; exit;
					if($newLike[$seaLIKE] = $user_id )
					$gig[$LK]['Gig']['like_user'] = $newLike[$seaLIKE];	
				}
			
			}
						$this->set('allgigs',$gig);

		   $this->set('like',$like);
 
	}
	function sendEmail($id)
	{	 
	$this->checkSession();
	  $user=$this->Session->read('User');
	  $this->set('user',$user);
	 $gigs= $this->Gig->find('all',array('conditions'=>array('Gig.id'=>$id)));
       $this->set('gigId',$gigs);	
	   $this->Email->to = $user['email']; 
        $this->Email->subject = '5$ Work Gig:'.$gigs[0]['Gig']['title']; 
        $this->Email->template = 'send_email';
$this->Email->sendAs = 'html';

        $this->Email->from = '5$ Work <info@5$ Work.com>'; 
        //Set the body of the mail as we send it. 
        //Note: the text can be an array, each element will appear as a 
        //seperate line in the message body. 
        if ( $this->Email->send() ) { 
            $this->Session->setFlash('Mail has been sent successfully on your email Id'); 
        } else { 
            $this->Session->setFlash('Mail has not been sent'); 
        } 
		$this->redirect('index');
	 	
	}
	function getprice($price)
	{
			$this->Session->write('Tab','auto');
		 $this->paginate = array('conditions' =>array('Gig.status'=>'active','Gig.price'=>$price,'User.status'=>'Active'),'limit' =>6);
		 
		$gig =$this->paginate('Gig'); 
		$this->set('price',$price);
		
		

			 $user_id=$this->Session->read('User.id');
			$like=$this->Like->find('all',array('conditions'=>
			array('Like.user_id'=>$user_id)));
			
			#pr($like);
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
			}
			#pr($newLike);
	foreach($gig as $LK =>$VL)
			{
				#pr($VL['Gig']['id']);	
				$seaLIKE = $VL['Gig']['id'];
				
				if (isset($newLike) && array_key_exists($seaLIKE,$newLike))
				{ #echo "vinod"; exit;
					if($newLike[$seaLIKE] = $user_id )
					$gig[$LK]['Gig']['like_user'] = $newLike[$seaLIKE];	
				}
			
			}
			if(!empty($gig))
			{
						$this->set('allgigs',$gig);
			$this->set('like',$like);
			}
			else
			{
			  $this->Session->setFlash('No Gigs Found');
			}
			

		   

	}
	function tags($search)
     {
		 				
	$this->paginate = array('conditions'=>array('User.status'=>'Active',
'OR'=>array('Gig.title LIKE '=>'%'.$search.'%','Gig.keywords_tags LIKE '=>'%'.$search.'%',
'Category.name LIKE '=>'%'.$search.'%')), 'limit' =>6);
		$gig =$this->paginate('Gig');
		if(!empty($gig))
		{
			 $user_id=$this->Session->read('User.id');
			$like=$this->Like->find('all',array('conditions'=>
			array('Like.user_id'=>$user_id)));
			
			#pr($like);
			foreach($like as $kL => $vL)
			{
				$gigsid = $vL['Like']['gig_id'];	
				$newLike[$gigsid] = $vL['Like']['user_id'];	
			}
			#pr($newLike);
	foreach($gig as $LK =>$VL)
			{
				#pr($VL['Gig']['id']);	
				$seaLIKE = $VL['Gig']['id'];
				
				if (isset($newLike) && array_key_exists($seaLIKE,$newLike))
				{ #echo "vinod"; exit;
					if($newLike[$seaLIKE] = $user_id )
					$gig[$LK]['Gig']['like_user'] = $newLike[$seaLIKE];	
				}
			
			}
						$this->set('allgigs',$gig);

		   $this->set('like',$like);
 
	
		}
		else
		{
			$this->Session->setFlash('There has no gig found');
		}
	
	 }
}

?>
