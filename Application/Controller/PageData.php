<?php

/**
 * Handle page data
 *
 * @author Kryptos
 *
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Controller_PageData extends Controller
{
    
    public function __construct()
    {   
        parent::__construct();

    }
    
   /**
    * Get the PageData for the current page
   	*/
    public function getPageData($page)
    {
        if($page != null)
        {   
            if(file_exists(PAGEDATA . $this->rConfigure->config->skin->name . DS . ucfirst(strtolower($page)) . '.php'))
            {
                $x = 'Controller_PageData_' . $this->rConfigure->config->skin->name . '_' . str_replace('/', '_', ucfirst(strtolower($page)));

                $this->load->$x();
            }   
            elseif(file_exists(PAGEDATA . $this->rConfigure->config->skin->pagedata->default . DS . ucfirst(strtolower($page)) . '.php'))
            {
                $x = 'Controller_PageData_' . $this->rConfigure->config->skin->pagedata->default . '_' . str_replace('/', '_', ucfirst(strtolower($page)));

                $this->load->$x();
            }
        }
    }
    
}

?>