<?php

/**
 * Handle avatars
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Identity_Use extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->Controller_Avatar();
        $this->load->Controller_User()->access(true, false, 'index');

        $this->changeAvatar($_GET['avatar']);

    }

    private function changeAvatar($avatar)
    {
        if($avatar != null)
        {
            $this->cAvatar->changeAvatar($avatar);
        }
    }
    
}

?>
