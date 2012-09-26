<?php

/**
 * Handle avatar information
 *
 * @author Kryptos
 */

/**
 * Deny direct file access 
 */
    if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); } 
  
class Controller_Avatar extends Controller 
{
    
    public function __construct()
    {  
        parent::__construct();
        
        $this->load->Model_Avatar();
    }

    public function addAvatar($user, $figure, $gender)
    {
        $password = $this->load->Controller_User()->mUser->getInfo($this->load->Controller_User()->getUsername(), 'password');
        $this->load->Controller_User()->mUser->insert($user, $password, $this->load->Controller_User()->getEmail(), $this->rConfigure->config->user->motto, $this->rConfigure->config->user->credits, $this->rConfigure->config->user->pixels, $this->rConfigure->config->user->rank, $figure, $gender);
    }
    
    public function changeAvatar($user)
    {
	    if($this->mAvatar->ownsAvatar($this->load->Controller_User()->getEmail(), $user))
	    {
	        $this->load->Controller_User()->setSession($user);
	
	        $this->load->Controller_User()->updateInfo($user, 'last_online', time());
	        $this->load->Controller_User()->updateTicket();
        }
        
        $this->vView->redirect('me');
    }

}
?>