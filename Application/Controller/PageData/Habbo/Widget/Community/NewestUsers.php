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
        
class Community_NewestUsers extends Controller implements iWidget
{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->Controller_User();

        $this->Initialize(18);
    }

    public function Initialize($limit = null)
    {
        $this->load->Controller_User();

        $getUsers = $this->cUser->mUser->getNewestUsers($limit);
        $number = 0;

        foreach($getUsers as $key => $value)
        {
            foreach($value as $k => $v)
            {
                foreach($this->mModel->emu->users as $y => $x)
                {
                    if($k == $x)
                    {
                        $this->vView->driver->assign('random->' . $y, $v, true);
                    }
                }
            }
            
            $this->Render($k[$v['id']], $number);
            $number++;
        }
    }

    public function Submit()
    {
        
    }

    public function Render($id = null, $number = null)
    {
        $this->vView->driver->assign('random->online', $this->cUser->mUser->isOnline($id), true);
        $this->vView->driver->assign('number', $number, true);
            
        $this->vView->driver->assign('widget->random->habbos', $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Community/NewestUsers/Item")));
    }
    
}

?>
