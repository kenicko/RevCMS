<?php

/**
 * Description of Me
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Client extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
       
        if($this->rConfigure->config->site->maintenance === 'true')
        {
        	if($this->load->Controller_User()->loggedIn())
        	{
	        	if($this->load->Controller_ACL()->hasControl('moderator'))
	        	{
		        	return;
	        	}
	        }
        }
        
        $this->load->Controller_User()->access(true, false, 'index');

    }    
}

?>
