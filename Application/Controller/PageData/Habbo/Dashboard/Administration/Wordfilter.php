<?php

/**
 * Index of Dashboard
 *
 * @author Kryptos
 */
class Controller_PageData_Habbo_Dashboard_Administration_Wordfilter extends Controller
{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->Controller_User()->access(true, false, 'Dashboard/Main', true);

        if(!$this->load->Controller_ACL()->hasControl('iplookup'))
        {
            $this->vView->redirect('Dashboard/Main');
        }
        
        $this->Run(); 
    }       

    private function Run()
    {
    	if(isset($_POST['filter']) && isset($_POST['word']))
		{
			$this->cUser->mUser->insertFilter($_POST['word']);
            $this->load->Library_Log()->Log("The user: " . $this->load->Controller_User()->getUsername() . " added a filter to {$_POST['word']}");
					
		}
    }
    
}

?>
