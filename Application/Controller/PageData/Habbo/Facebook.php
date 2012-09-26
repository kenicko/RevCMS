<?php

/**
 * Logout user
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Facebook extends Controller
{

	private $lib;
    
    public function __construct()
    {
        parent::__construct();

        $this->lib = $this->load->Library_Facebook(array('appId'  => '','secret' => '', 'cookie' => true));
       
        $this->load->Controller_User()->access(false, true, 'me');

        $this->Login();
    }

    private function Login()
    {
    	$user = $this->lib->facebook->getUser();

		if(!is_null($user)) 
		{
        	$user_profile = $this->lib->facebook->api('/me');

        	print_r($user);print_r($user_profile);die;

    		return;
		} 


    	header("Location: ".$this->lib->facebook->getLoginUrl());

    }
    
}

?>
