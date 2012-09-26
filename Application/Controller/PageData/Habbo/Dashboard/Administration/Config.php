<?php

/**
 * Index of Dashboard
 *
 * @author Kryptos
 */
class Controller_PageData_Habbo_Dashboard_Administration_Config extends Controller
{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->Controller_User()->access(true, false, 'me', true);

        if(!$this->load->Controller_ACL()->hasControl('configuration'))
		{
			$this->vView->redirect('Dashboard/Main');
    	}

        $results = scandir(THEMES);

        foreach ($results as $result) 
        {
            if ($result === '.' or $result === '..') continue;

            if (is_dir(THEMES . $result)) {
                $this->vView->driver->assign('skins', "<option value={$result}>{$result}</option>");
            }
        }
    }       
    
}

?>
