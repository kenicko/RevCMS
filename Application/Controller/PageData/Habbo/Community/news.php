<?php

/**
 * Description of Me
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Community_news extends Controller
{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->Controller_Article();

        $this->load->Controller_User()->access(true, false, 'index');

        $this->cArticle->getArticle($_GET['id']);

        $this->cArticle->getNewsList($_GET['id']);
        
        $this->checkRank();
    }
    
    private function checkRank()
    {
	    if($this->load->Controller_ACL()->hasControl('editnews'))
	    {
		    $this->vView->driver->assign('news->delete', '<a href="{$site->url}community/news&id=' . $_GET['id'] . '&action=delete">Delete</a>');
	    }
	    
	    if(isset($_GET['action']) && $_GET['action'] == 'delete')
	    {
	    	if($this->load->Controller_ACL()->hasControl('editnews'))
	    	{
		    	$this->cArticle->deleteArticle($_GET['id']);
		    }
	    }
    }

    
}

?>
