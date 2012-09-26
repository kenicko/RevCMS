<?php

/**
 * Index of Dashboard
 *
 * @author Kryptos
 */
class Controller_PageData_Habbo_Dashboard_Administration_Addcampaign extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->Controller_User()->access(true, false, 'Dashboard/Main', true);

        if(!$this->load->Controller_ACL()->hasControl('addcampaign'))
		{
			$this->vView->redirect('Dashboard/Main');
    	}
    }       
    
}

?>
