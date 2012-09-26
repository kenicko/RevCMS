<?php

/**
 * Global class loader - Probably the single most important file in all the Framework
 *
 * @author Kryptos
 * @author RastaLulz
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');

class Loader
{
    
    public static $classes = array();
    
    public $URL, $blockedFiles = array('.', '..', '.DS_STORE');

    public function __construct() 
    {
        global $URL;
        
        $this->url = $URL;   
    }
    
   /**
    * Check if someone is trying to instantiate a class, if they are - do it
   	*/
    public function __call($method, $args = null)
    {   
        $instance =& getInstance();
        if(!is_object(self::$classes[$method]))
        {       
            //IMMA B CHARGIN MA LAZER!11!!!1!1!ONE!!!ELEVEN!
            self::$classes[$method] = new $method((count($args) > 0 ? $args : null ) ); 
        }
        
        if(!is_object($instance->$method) && !is_null($method))
        {
            $instance->{getClass($method)} = self::$classes[$method];
        }
        
        return self::$classes[$method];
    }


    /**
     * Call a Widget
     */
    public function widget($widget)
    {
        $urlWidget = str_replace('_', '/', $widget);
        require_once PAGEDATA . $this->Rev_Configure()->config->skin->name . DS . 'Widget' . DS . $urlWidget . '.php';
        
        self::$classes[$widget] = new $widget(); 
        return self::$classes[$widget];
    }


   /**
    *
    */
    public function vDriver()
    {
        $driver = $this->Rev_Configure()->config->skin->driver;
        require_once VIEW_DRIVER . $driver . DS . $driver . '.php';
        
        self::$classes[$driver] = new $driver(); 
        return self::$classes[$driver];
    }


   /**
    * Call a Helper
   	*/   
    public function helper($helper)
    {
        $url = HELPERS . "{$helper}.php";
        
        if(file_exists($url))
            require_once $url;
        else   
            $this->Library_Log()->writeError("Could not find helper {$helper} on {$url}", 4);

    }
   
}

?>
