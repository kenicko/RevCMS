<?php

/**
 * Index of Dashboard
 *
 * @author Kryptos
 */
class Controller_PageData_Habbo_Dashboard_Main extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->Controller_User()->access(true, false, 'index', true);

 		if(!$this->load->Controller_ACL()->hasControl('moderator'))
		{
			$this->vView->redirect('me');
    	}

    }       
    
}

?>
