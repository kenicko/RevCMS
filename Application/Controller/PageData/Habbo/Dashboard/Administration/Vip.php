<?php

/**
 * Index of Dashboard
 *
 * @author Kryptos
 */
class Controller_PageData_Habbo_Dashboard_Administration_Vip extends Controller
{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->Controller_User()->access(true, false, 'Dashboard/Main', true);

        if(!$this->load->Controller_ACL()->hasControl('vip'))
		{
			$this->vView->redirect('Dashboard/Main');
    	}
    }       
    
}

?>
