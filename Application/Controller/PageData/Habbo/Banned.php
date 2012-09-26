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
        
class Controller_PageData_Habbo_Banned extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
       
        $this->load->Controller_User()->access(true, false, 'index');

        $this->cUser->getBan();
        
        $this->cUser->logout();

    }
       
}

?>
