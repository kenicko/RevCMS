<?php

/**
 * Controll the Model and the View.
 *
 * @author Kryptos
 * @author Pure
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
 
class Controller
{
    
    public $Model, $View;
    
    public static $instance;
    
    public $write = true;

        /**
         * Load classes and call the controllerManager
         */
		public function __construct()
		{      
			
    		self::$instance =& $this;
            
       	 	$this->load = load_class('Loader', 'Rev');
            
        	$this->InitializeErrorHandling();

        	$this->InitializeConfig();

        	$this->InitializeSessionHandling();

       		$this->load->View();

        	$this->load->Model();
		}
        
        /**
         * Build the template and assign a controller to the page.
         */
        public function InitializeRendering()
        {   
            if($this->write != false)
            {
                $this->vView->driver->render($this->load->url);
                return;
            }
        }

        /**
         * Retrieve the configuration file and build an object for it
         */
        private function InitializeConfig()
        {
            $this->load->Rev_Configure();
        }
        
        /**
         * Initialize the Sessions
         */
        private function InitializeSessionHandling()
        {
            $this->load->Library_Session();
        }

        /**
         * Call the Error Handler
         */
        private function InitializeErrorHandling()
        {
            $this->load->helper('ErrorHandler');
        }

        /**
         * Initialize our Logging class
         */
        private function InitializeLogger()
        {
            $this->load->Library_Log();
        }
        
	    /**
         * Gets the instance of the current class
         */
        public static function &getInstance()
        {
            return self::$instance;
        }
        
}
?>