<?php

/**
 * Description of Staff
 *
 * @author Joopie
 */

   /**
    * Deny direct file access
    */
    
    defined('IN_INDEX') or die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Community_Staff extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
   
        $this->load->Controller_User()->access(true, false, 'index');

        $this->getStaff();

    }

    private function getStaff()
    {
    	$staff = $this->cUser->mUser->getStaff();
		
		if (empty($staff))
		{
			return;
		}
		
		//get ranks and parse it
		$ranks = array();
		$temp = $this->cUser->mUser->getRanks();
		foreach ($temp as $value)
		{
			$ranks[$value['id']] = $value['name'];
		}
		unset($temp);
		
		//parse data
		$content = '';
		$oddeven = 'even';
		$last_rank = null;
    	foreach($staff as $key => $value)
    	{
    		$oddeven = ($oddeven == 'even') ? 'odd' : 'even';
    		
    		if ($value['rank'] != $last_rank || empty($last_rank))
    		{
    			if (!empty($last_rank))
    			{
    				$content .= $this->vView->driver->getFile("Widgets/Community/Staff/end");
    			}
    			
    			$this->vView->driver->assign('widget->staff->title', $ranks[$value['rank']], true);
    			$content .= $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Community/Staff/start"));
    			
    			$oddeven = 'odd';
    			$last_rank = $value['rank'];
    		}
    		
    		$this->vView->driver->assign('staff->oddeven', $oddeven, true);
    		
    		$this->vView->driver->assign('staff->username', $value['username'], true);
            $this->vView->driver->assign('staff->motto', $value['motto'], true);
            $this->vView->driver->assign('staff->look', $value['look'], true);
            $this->vView->driver->assign('staff->online', ($value['online'] == 1 ? 'Online' : 'Offline'), true);
            $this->vView->driver->assign('staff->last_online', date('M j, Y g:i:s A', $value['last_online']), true);
            
            $content .= $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Community/Staff/item"));
    	}
    	
    	$content .= $this->vView->driver->getFile("Widgets/Community/Staff/end");
    	
    	$this->vView->driver->assign('widget->staff->container', $content);
    }

}

?>
