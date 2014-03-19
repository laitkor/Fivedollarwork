<?php
class AppController extends Controller {
	var $helpers = array('Html', 'Form', 'Javascript','Session','Ajax');
	var $components = array('Session', 'Email','RequestHandler','Cookie');
	var $uses = array('Gig','User','Category','Gigsprice','Setting','Recommend','Content');
	
  
	##### Setting up default layout #####
	function beforeFilter()
    {	
	//App::import('vendor', 'facebook');
	$this->listCategory();
	$this->gigsprice();
	$this->websiteSetting();
	//$this->recommendedlist();
	$this->myrecommendedlist();
	
	}
	  
	########  Set Website Setting #######
	 public function websiteSetting(){
		$setting=$this->Setting->find('first',array('conditions' =>array('Setting.id' => '1')));
		$this->set('setting',$setting);
	 }

	
	########  List of Category #######
	 public function listCategory(){
		$category=$this->Category->find('all',array('conditions' =>array('Category.status' => 'Active') ,'order' => array('Category.name' => 'ASC')));
		$this->set('listcategory',$category);
	 }
	########  List of Gigs Price #######
	 public function gigsprice(){
		$gigsprice=$this->Gigsprice->find('all',array('conditions' =>array('Gigsprice.status' => 'Active') ,'order' => array('Gigsprice.price' => 'ASC')));
		if(!empty($gigsprice))
		{
		$this->set('gigsprice',$gigsprice);
		}
	 }

	
	#######  Check User Session ##########
	 function checkSession($send_return = false)
    {
        if (!$this->Session->check('User'))
        {			
            $this->Session->setFlash('Please login first!');
			  if(!$send_return){
			// Force the user to login
            $this->redirect('/users/signin'); 
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
			 $record=$this->Session->read('User.id');
			 $result=$this->User->query("update users set updated = '".date("Y-m-d H:i:s")."' where id = '".$record."' ");
			  
		}
    } 

	########  Set User Session #######
	 public function setSession($user_arr = ""){
		 if(is_array($user_arr)){
			// session information to remember this user as 'logged-in'.                
			$this->Session->write('User', $user_arr);			
		 }
	 }
	 
	 	########  Set Admin Session #######
	 public function setadminSession($user_arr = ""){
		 if(is_array($user_arr)){
			// session information to remember this user as 'logged-in'.                
			$this->Session->write('Admin', $user_arr);			
		 }
	 }

	 
######## Set time ago #######
public function _ago($tm,$rcs = 0) {
$cur_tm = time(); $dif = $cur_tm-$tm;
$pds = array('second','minute','hour','day','week','month','year','decade');
$lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
$no = floor($no);
if($no < 0) $no =1;
if($no > 1)
$pds[$v] .='s';
$x=sprintf("%d %s ",$no,$pds[$v]);

if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0))
$x .= time_ago($_tm);

return $x." ago";
}
	 
	 
 	#############  Send Mail to User ###################################################
		function _sendUserMail($id,$subject,$template,$to="",$sendadmin) {
		$this->Email->to = empty($to)?$this->Session->read('User.email'):$to;
		if(isset($sendadmin) and $sendadmin=='Y')
		{
		$this->Email->bcc = array(ADMIN_EMAIL);  
		}
		$this->Email->subject = $subject;
		$this->Email->replyTo = SUPPORT_EMAIL;
		$this->Email->from = SITE_NAME.' Team '.SUPPORT_EMAIL;
		$this->Email->template = $template; // note no '.ctp'
		$this->Email->_debug = true;
		///////////// SMTP Setting ///////////////
		
		/* SMTP Options */
		if(1){  //Set to 0 if you want to send with Localhost
		  $this->Email->smtpOptions = array(
				'port'=>'465',
				'timeout'=>'30',
				'host'=>'ssl://smtp.gmail.com',
				'username'=>'fivedollarwork@gmail.com',
				'password'=>'m2n1shlko',				
		   );
		
			/* Set delivery method */
			$this->Email->delivery = 'smtp';
		
		}		
		/////////////////////////////////////////
		
		//Send as 'html', 'text' or 'both' (default is 'text')
		$this->Email->sendAs = 'html'; // because we like to send pretty mail
				
		//Set view variables as normal
		//$this->set('User', $User['User']);
		//$this->set('Stat',$stats);
		//Set view site url
		$this->set('siteurl', SITE_URL);
		
		//Do not pass any args to send()
		$this->Email->send();
	 }
     
	// Get File Extension  
	 function getFileExtension($str) {

        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
	
	

   // Deletes the image
    function delete_image($path) {
        unlink($path);
    }
	
	// crop the image
	    function crop_img($imgname, $scale, $filename,$filetype) {
        switch($filetype){
            case "jpeg":
            case "jpg":
              $img_src = imagecreatefromjpeg ($imgname);
             break;
             case "gif":
              $img_src = imagecreatefromgif ($imgname);
             break;
             case "png":
              $img_src = imagecreatefrompng ($imgname);
             break;
        }

        $width = imagesx($img_src);
        $height = imagesy($img_src);
        $ratiox = $width / $height * $scale;
        $ratioy = $height / $width * $scale;

        //-- Calculate resampling
        $newheight = ($width <= $height) ? $ratioy : $scale;
        $newwidth = ($width <= $height) ? $scale : $ratiox;

        //-- Calculate cropping (division by zero)
        $cropx = ($newwidth - $scale != 0) ? ($newwidth - $scale) / 2 : 0;
        $cropy = ($newheight - $scale != 0) ? ($newheight - $scale) / 2 : 0;

        //-- Setup Resample & Crop buffers
        $resampled = imagecreatetruecolor($newwidth, $newheight);
        $cropped = imagecreatetruecolor($scale, $scale);

        //-- Resample
        imagecopyresampled($resampled, $img_src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        //-- Crop
        imagecopy($cropped, $resampled, 0, 0, $cropx, $cropy, $newwidth, $newheight);

        // Save the cropped image
        switch($filetype)
        {

            case "jpeg":
            case "jpg":
             imagejpeg($cropped,$filename,80);
             break;
             case "gif":
             imagegif($cropped,$filename,80);
             break;
             case "png":
             imagepng($cropped,$filename,80);
             break;
        }
    }

// Resize the image and save the given location
    function resize_img($imgname, $size, $filename,$filetype)    {
        switch($filetype) {
            case "jpeg":
            case "jpg":
            $img_src = imagecreatefromjpeg ($imgname);
            break;
            case "gif":
            $img_src = imagecreatefromgif ($imgname);
            break;
            case "png":
           $img_src = imagecreatefrompng ($imgname);
            break;
        }
        $true_width = imagesx($img_src);
        $true_height = imagesy($img_src);
        if ($true_height>=$true_width)
        {
            $height = $size;
            $width = ($height/$true_height)*$true_width;
        }
        else
        {
            $height = $size;
            $width = ($height/$true_height)*$true_width;
        }
		$img_des = imagecreatetruecolor($width,$height);
		if($filetype=='png')
		{
 		// enable alpha blending on the destination image. 
		imagealphablending($img_des, true); 
		// Without this the image will have a black background instead of being transparent. 
		$transparent = imagecolorallocatealpha($img_des,0, 0,0, 127); 
		imagefill($img_des, 0, 0, $transparent ); 
		//
		}
        imagecopyresampled($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
		if($filetype=='png')
		{
		imagealphablending($img_des, false); 
		// save the alpha 
		imagesavealpha($img_des,true); 
        // Save the resized image
		}
        switch($filetype)
        {
            case "jpeg":
            case "jpg":
             if(!imagejpeg($img_des,$filename,100))
			 {
			 $this->Session->setFlash('Error Uploading File!.');
			 $this->redirect($_SERVER['REQUEST_URI']);
			 exit();
			 }
             break;
             case "gif":
             if(!imagegif($img_des,$filename,100))
			 {
			 $this->Session->setFlash('Error Uploading File!.');
			 $this->redirect($_SERVER['REQUEST_URI']);
			 exit();
			 }
             break;
             case "png":
             if(!imagepng($img_des,$filename,9))
			 {
			 $this->Session->setFlash('Error Uploading File!.');
			 $this->redirect($_SERVER['REQUEST_URI']);
			 exit();
			 }
             break;
        }
    }


// Resize the image and display
    function resize_imgdisplay($image_path,$width, $height)    {
		$imgname=urldecode($image_path);
		$filetype = $this->getFileExtension($imgname);
        switch($filetype) {
            case "jpeg":
            case "jpg":
            $img_src = imagecreatefromjpeg ($imgname);
            break;
            case "gif":
            $img_src = imagecreatefromgif ($imgname);
            break;
            case "png":
            $img_src = imagecreatefrompng ($imgname);
            break;
        }

        $true_width = imagesx($img_src);
        $true_height = imagesy($img_src);

        if ($true_width>$width)
        {
            $width=$width;
        }
		if ($true_height>$height)
        {
            $height=$height;
        }
        $img_des = imagecreatetruecolor($width,$height);
        imagecopyresampled($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
		
		        // Save the resized image
        switch($filetype)
        {
            case "jpeg":
            case "jpg":
            imagejpeg($img_des, null, 100);
			 header('Content-Type: image/jpeg');
             break;
             case "gif":
             imagegif($img_des, null, 100);
			header('Content-Type: image/gif');
             break;
             case "png":
             imagepng($img_des, null, 100);
			 header('Content-Type: image/png');
             break;
        }
		unlink($img_src);
		unlink($img_des);
		exit();
    }



	######## List of My Recommendation #######
	function myrecommendedlist() {
		if ($this->Session->check('User'))
        {
				
		$myrecommendedlist=$this->Recommend->find('all', array('conditions' =>array('Recommend.user_id' =>$this->Session->read("User.id")),'order' => array('Recommend.id DESC'),'limit' => 5));	 	
	$this->set('myrecommendedlist',$myrecommendedlist);
		}
	}

	
		######## Remove My Recommendation #######
	function removerecommended($id="") {
		//Checking user login
		$this->checkSession();
		if(!empty($id))
		{
			$this->Recommend->delete($id);
			$this->Session->setFlash("Your Recommendation has been removed.");
			$this->redirect('/');

		}
		else
		{
			$this->redirect('/');
		}
		
	}

function test()
{
	$strImagePath=WWW_ROOT."uploads/feat-icon.png";
	$imgPng = imagecreatefrompng($strImagePath);
imagealphablending($imgPng, true);
imagesavealpha($imgPng, true);

/* Output image to browser */
header("Content-type: image/png");
imagepng($imgPng, NULL, 100); 
}

	
}
?>
