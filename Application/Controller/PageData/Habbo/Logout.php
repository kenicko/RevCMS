<?php

/**
 * Logout user
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Logout extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
       
        $this->load->Controller_User()->access(true, false, 'index');
        
        $this->cUser->logout();
        
        $this->vView->redirect('index');

    }
    
}

?>
