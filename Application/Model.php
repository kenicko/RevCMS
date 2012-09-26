<?php

/**
 * Handle the connection with the database, do queries, fetch data, etc.
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 

class Model extends Controller
{
    
    public $driver;

    public $emu;
    
    public static $queries = 0;
    
    public function __construct()
    {   
        $this->InitializeDAO();
    }

   /**
    * Get our driver interfaces and call our Database file
   	*/
    public function InitializeDAO()
    {
        $this->getInterfaces();

        $driver = 'Model_Driver_' . $this->load->Rev_Configure()->config->DB->driver;
        $this->driver = $this->load->$driver();

        # Get database #
        
        $this->emu = include DATA . $this->load->Rev_Configure()->config->DB->emulator . '.php';
    }

   /**
    * Require/Include our interfaces
   	*/
    private function getInterfaces()
    {
        foreach(glob(MODEL_DRIVER . 'SQL/Interface/*.php') as $interface)
        {
            require_once $interface;
        }
    }
    
    public function __get($key)
    {
        $instance =& $this->getInstance();
        return $instance->$key;
    }
}
?>
