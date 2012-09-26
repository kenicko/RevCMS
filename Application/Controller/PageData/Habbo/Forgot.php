<?php

/**
 * Logout user
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Forgot extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
       
        $this->load->Controller_User()->access(false, true, 'me');
        
        $this->sendPassword();
    }
    
    private function sendPassword()
    {
    	if($_SERVER['REQUEST_METHOD'] == 'POST')
    	{
	    	if($this->load->Model_User()->isEmailTaken($_POST['emailAddress']))
	    	{
	    		$newPass = GeneratePassword(10, true, true, true, false);
	    		$code = GeneratePassword(32, true, true, true, false);

	    		$this->load->Model_User()->insertActivationCode($_POST['emailAddress'], $this->mModel->emu->register['hash'], $code);
		    	$this->sendEmail($newPass, $code);
		    }
		}
		
		$this->vView->redirect('index');
    }
    
    private function sendEmail($newPass, $code)
    {
	 	$this->load->Library_Email($_POST['emailAddress'], 'noreply@revhotel.com', 'Your new RevHotel password!', 'Hello, we have reset your password. New Password: ' . $newPass . ' - Please go first to this activation link: ' . $this->rConfigure->config->site->url . 'activate&code=' . $code);  
    }
    
}

?>
