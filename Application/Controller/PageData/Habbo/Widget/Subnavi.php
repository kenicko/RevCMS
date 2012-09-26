<?php

/**
 * Login widget
 *
 * @author Kryptos
 */
class Subnavi extends Controller implements iWidget
{
	
    public function __construct()
    {
        parent::__construct();

        $this->Initialize();
    }

    public function Initialize()
    {
    	if($this->load->Controller_ACL()->hasControl('moderator'))
        {
            $this->vView->driver->assign('Dashboard', '<a href="{$site->url}Dashboard/Main" class="new-button red-button"><b>Dashboard</b><i></i></a>');
        }
    }

    public function Submit()
    {

    }

    public function Render()
    {

    }

}

?>
