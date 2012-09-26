<?php

/**
 * Index of Dashboard
 *
 * @author Kryptos
 */
class Controller_PageData_Habbo_Dashboard_Administration_Addbot extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->Controller_User()->access(true, false, 'Dashboard/Main', true);

        if(!$this->load->Controller_ACL()->hasControl('addbot'))
		{
			$this->vView->redirect('Dashboard/Main');
    	}
    }       
    
}

?>
