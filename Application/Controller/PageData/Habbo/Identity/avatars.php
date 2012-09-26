<?php

/**
 * Handle avatars
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Identity_Avatars extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->Controller_Avatar();
        $this->load->Controller_User()->access(true, false, 'index');

        $this->GetInfo();

    }

    private function GetInfo()
    {
        $getAvatars = $this->cAvatar->mAvatar->getAvatars($this->load->Controller_User()->getEmail(), $this->load->Controller_User()->getUsername());

        if($getAvatars != null)
        {
            foreach($getAvatars as $key => $value)
            {
                foreach($value as $k => $v)
                {
                    foreach($this->mModel->emu->users as $y => $e)
                    {
                        if($e == $k)
                        {
                            if($y == 'last_online')
                            {
                                $v = date('d.m.y', $v);
                            }

                            $this->vView->driver->assign('user->global->' . $y, $v, true);
                        }
                    }
                }

                $this->vView->driver->assign('widget->avatars', $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Identity/avatar")));
            }
        }

        $email = explode('@', $this->load->Controller_User()->getEmail());
        $this->vView->driver->assign('user->email->1', $email[0]);
    }
    
}

?>
