<?php

/**
 * Create news
 *
 * @author Kryptos
 */
 
class Controller_PageData_Habbo_Dashboard_Administration_News extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->Controller_User()->access(true, false, 'Dashboard/Main', true);

        if(!$this->load->Controller_ACL()->hasControl('addnews'))
		{
			$this->vView->redirect('Dashboard/Main');
    	}
	    
	    $this->getImages();
    }       
    
    private function getImages()
    {
    	$option = '';
    	
		if($handle = opendir('Public/Themes/' . $this->rConfigure->config->skin->name . '/Dashboard/newsImages/'))
		{	
			while(false !== ($file = readdir($handle)))
			{
				if($file == '.' || $file == '..')
				{
					continue;
				}		
	
				$option .= '<option value="' . $this->rConfigure->config->site->url . 'Public/Themes/' . $this->rConfigure->config->skin->name . '/Dashboard/newsImages/' . $file . '"';
	
			
				$option .= '>' . $file . '</option>';
			}
		}
		
		$this->vView->driver->assign('news->images', $option);
    }
    
}

?>
