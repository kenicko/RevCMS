<?php

/**
 * Handle user information
 *
 * @author Kryptos
 */

/**
 * Deny direct file access 
 */
    if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); } 
  
class Controller_User extends Controller 
{
    
    private $SensitiveData = array('password', 'seckey');
    private $NoCache = array('motto', 'pixels', 'credits');
    
    public function __construct()
    {  
        parent::__construct();
        
        $this->load->Model_User();
        $this->load->Library_Validate();

        if($this->loggedIn())
        {
            $this->getStoredInfo();

            $this->vView->driver->assign('user->sso', $this->mUser->getTicket($this->getID()));
        }

        $this->vView->driver->assign('online', $this->mUser->getOnline());
    }
    
   /**
    * Used to SET and GET User Information
   	*/
    public function __call($method, $arg) 
    {
        if(!method_exists($this, $method))
        {
            switch (substr($method, 0, 3)) 
            {
                case 'get':
                    $key = strtolower(substr($method,3));
                    return (isset($_SESSION['user'][$key]) ? $_SESSION['user'][$key] : $this->getInfo($this->getUsername(), $key));
                break;
        
                case 'set':
                    $key = strtolower(substr($method,3));

                    $_SESSION['user'][$key] = is_array($arg) ? $arg[0] : $arg;
                    return $this;
                break;
            }
        }
    }
   
    /**
    * Check of the user is logged in
   	*/
    public function loggedIn()
    {
        return (isset($_SESSION['user']['loggedin']) ? true : false);
    }
    
   /**
    * Used by PageDatas to check if a user has the right to be on their page
   	*/
    public function access($allowUser, $allowGuest, $redirection = null, $allowMaintenance = false)
    {
        if($this->rConfigure->config->site->maintenance !== 'true' || $allowMaintenance === true)
        {
            if($this->loggedIn() && $allowUser != true)
            {
                if($redirection != null)
                {
                    $this->vView->redirect($redirection);
                    return;
                }
            }
        
            if(!$this->loggedIn() && $allowGuest != true)
            {
                if($redirection != null)
                {
                    $this->vView->redirect($redirection);
                    return;
                }  
            }
            
            return;
        }
        else
        {
            $this->vView->redirect('maintenance');
        }
    }

   /**
    * Retrieve all the user's info and assign it to template parameters
   	*/
    public function getStoredInfo()
    {
        foreach($_SESSION['user'] as $key => $value)
        {
            if($key == 'last_online' || $key == 'account_created')
            {
                $value = date('d.m.y', $value);
            }

            foreach($this->mModel->emu->users as $k => $v)
            {
                if($key == $v)
                {
                    $this->vView->driver->assign('user->' . $k, $value, true);
                }
            }
        }
        
        foreach($this->NoCache as $key)
        {
        	$req = 'get' . $key;
        	$this->vView->driver->assign('user->' . $key, $this->{$req}(), true);
        }
    }

    /**
    * Update the Info of a user
    */
    public function updateInfo($user, $key, $value)
    {
        $set = 'set' . ucfirst($key);
        $this->{$set}($value);
        $this->load->Model_User()->updateInfo($user, $key, $value);
    }

   /**
    * Update the SSO Ticket of the User
   	*/
    public function updateTicket()
    {   
        $this->load->Model_User()->updateTicket($this->getID(),'Rev-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33));
    }
    
    /**
     * Insert an SSO ticket to the user
     */
     public function insertTicket()
     {
	     $this->load->Model_User()->insertTicket($this->getID(),'Rev-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33));
     }
    
   /**
    * Set the required Sessions for the user to be logged in
   	*/
    public function setSession($user)
    {
        $this->setLoggedIn(true);
        
        if($this->lValidate->validEmail($user)) $this->setEmail($user); else $this->setUsername($user);

        $this->parseInformation($user);
        $this->insertTicket();
    }

   /**
    * Call the User Model and get specific information
   	*/
    public function getInfo($username, $key)
    {
        return $this->mUser->getInfo($username, $key);
    }
    
   /**
    * Get all the user's information and assign it to Sessions
   	*/
    private function parseInformation($user)
    {           
        foreach($this->load->Model_User()->getInfo($user) as $values)
        {
            foreach($values as $info => $value)
            {
                if(!in_array($info, $this->NoCache) && !in_array($info, $this->SensitiveData))
                {
                    $set = 'set' . ucfirst($info);
                    $this->{$set}($value);
                }
            }
        }
    }
    
   /**
    * Update a user's password with Forgot Password feature
    */
    public function forgotPassword($code)
    {
    	$codeExists = $this->mUser->codeExists($code);
    	
	    if($codeExists != false)
	    {
		    $this->updateInfo($codeExists['email'], 'password', $codeExists['newpw']);
	    }
	    
	    $this->vView->redirect('index');
    }

   /**
    * Terminate the user's session and redirect him to Index
   	*/
    public function logout()
    {
        if($this->loggedIn())
        {
            session_destroy();
        }
    }

}
?>