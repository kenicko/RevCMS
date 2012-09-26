<?php

/**
 * Logout user
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Quickregister_User extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
       
        $this->load->Controller_User()->access(false, true, 'me');

        if($_SESSION['reg']['1'] != true) $this->vView->redirect('quickregister/start');
    }
    
}

?>
