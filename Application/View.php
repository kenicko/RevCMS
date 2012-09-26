<?php

/**
 * Render and filter the template
 *
 * @author Kryptos
 * @author RastaLulz
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class View extends Controller
{   

    private static $initiated;
    
    protected static $tpl, $language;

    protected $mobile;
    
    public function __construct() 
    {
        $this->getInterfaces();

        if($this->load->Library_UserAgent()->isMobile() && $this->rConfigure->config->skin->mobile->enabled == true)
        {
            $this->mobile = true;
            $this->load->Rev_Configure()->config->skin->name = $this->load->Rev_Configure()->config->skin->mobile->name;
        }

        $this->driver = $this->load->vDriver();

        $this->driver->data = $this->load->Rev_Configure()->config->skin;

        
        $this->Initialize();
    }
    
   /**
    * Load our language view, and assign default template parameters
   	*/
    private function Initialize()
    {       
        if(self::$initiated != true)
        {

            self::$initiated = true;

            $this->load->View_Language();

            $this->driver->assign('skin->name', $this->rConfigure->config->skin->name);

            foreach($this->rConfigure->config->site as $key => $value)
            {
                $this->driver->assign('site->'. $key, $value);
            }
            
            foreach($this->rConfigure->config->social as $key => $value)
            {
                $this->driver->assign('social->'. $key, $value);
            }
        
            foreach(self::$language as $key => $value)
            {
                $this->driver->assign('lang->' . $key, $value); 
            }
            
            //Set the copyright
            $this->driver->assign('site->copyright', COPYRIGHT);
        
            $this->setData();
        }
    }
    
   /**
    * If there is a POST request, make them all parameters for easy access on the template
   	*/
    public function setData()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            foreach($_POST as $key => $value)
            {
                if($value != null)
                {
                    $this->driver->assign('post->' . $key, $value, true);
                }
                else
                {
                    return false;
                }
            }
            
            return true;
        }
    }
    
   /**
    * Assign a parameter for our error, sorry for hardcoding *embarrased*
   	*/
    public function setError($key, $value)
    {
        $this->driver->assign('error->' . $key, $value);
    }
    
   /**
    * Get the interfaces for our Template drivers
   	*/
    private function getInterfaces()
    {
        foreach(glob(VIEW_DRIVER_INTERFACE . '*.php') as $interface)
        {
            require_once $interface;
        }
    }
    
   /**
    * Redirect the user to somewhere else
   	*/
    public function redirect($where)
    {
        exit(header("Location: {$this->rConfigure->config->site->url}{$where}"));
    }
    
    public function __get($key)
    {
	   $instance =& $this->getInstance();
	   return $instance->$key;
    }
    
}
?>