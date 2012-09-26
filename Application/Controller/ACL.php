<?php

/**
 * Manage the Access Control List
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Controller_ACL extends Controller
{
    
    public function __construct()
    {   
        parent::__construct();

    }
    
   /**
    * Check if a user has access to a control
   	*/
    public function hasControl($control)
    {
        $ranksAllowed = explode(',', $this->load->Rev_Configure()->config->acl->{$control});

        if(in_array($this->load->Controller_User()->getRank(), $ranksAllowed))
        {
            return true;
        }

        return false;
    }

    /**
    * Check if a user has access to a control
    */
    public function hasControlCheck($rank, $control)
    {
        $ranksAllowed = explode(',', $this->load->Rev_Configure()->config->acl->{$control});

        if(in_array($rank, $ranksAllowed))
        {
            return true;
        }

        return false;
    }

   /**
    * Add a control to the list
   	*/
    public function addControl($control, $value)
    {
        $this->load->Rev_Configure();

        $this->rConfigure->config->acl->{$control} = $value;

        $this->rConfigure->set('Config', $this->rConfigure->config);
    }

   /**
    * Delete a control from the list
   	*/
    public function deleteControl($control)
    {
        $this->load->Rev_Configure();

        unset($this->rConfigure->config->acl->{$control});

        $this->rConfigure->set('Config', $this->rConfigure->config);
    }
    
}

?>