<?php

/**
 * Handle languages accordingly
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
    
class View_Language extends View
{
    
   /**
    * Retrieve the language file for this theme and then call it
   	*/
    public function __construct()
    {   
        parent::__construct();
        
        if(file_exists(LANGS . "{$this->load->Rev_Configure()->config->skin->name}/{$this->rConfigure->config->language->name}.php"))
        {
            require LANGS . "{$this->load->Rev_Configure()->config->skin->name}/{$this->rConfigure->config->language->name}.php";
            parent::$language = $LANG[strtolower($this->load->Rev_Configure()->config->skin->name)];
        }
    }
    
}

?>