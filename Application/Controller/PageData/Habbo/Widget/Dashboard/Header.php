<?php

/**
 * Header of Dashboard
 *
 * @author Kryptos
 */
class Dashboard_Header extends Controller implements iWidget
{
    public function __construct()
    {
        parent::__construct();

        $this->Initialize();
    }

    public function Initialize()
    {
        $this->load->Controller_User()->access(true, false, 'index', true);

        if(!$this->load->Controller_ACL()->hasControl('moderator'))
        {
            $this->vView->redirect('Dashboard/Main');
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
