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
        

class Rev extends View implements View_Driver_IDriver
{
    
    private static $files = array();
    
    private static $params = array();

    private $outputtingCache = false;
    
    protected static $lang;
    
    public $cacheTime = 500;
    
    public $write = true;
    
    public function __construct()
    {
       //Nothing to see here, move along.
    }
    
    /**
     * Creates a template tool 
     *
     * @param type $key - Name of the tools
     * @param type $value - Value of the tool
     */
    public function assign($key, $value, $override = false)
    {
        if($override == false)
        {
             self::$params[$key] .= $value;
        }
        else
        {
            self::$params[$key] = $value;
        }
        
        return $this;
    }
    
    public function assignWidget($key, $widget)
    {
        self::$param[$key] .= $this->filterParams($this->getFile('Widgets/' . $widget));
    }
      
	
    /**
     * Filter the template and identify the tools and/or widgets
     */
    public function filterParams($file) 
    {  
        $params = self::$params;

        while(preg_match('/{\$(.+?)}/i', $file) === 1)
        {
            $file = preg_replace_callback('/{\$(.+?)}/i', function (array $matches) use ($params) { return $params[$matches[1]]; }, $file);
        }     

        return $file;
    }
    
    
    /**
     * Render files
     * @global type $skin - Holds up the skin's information
     */
    public function render($url)
    {
        if($this->mobile != true)
        {
            if(file_exists(THEMES . $this->rConfigure->config->skin->name . DS . $url . '.html') && $this->write == true)
            {    
                parent::$tpl .= $this->getFile($url);

                $this->load->Controller_PageData()->getPageData($url);
                $this->load->Controller_PageData_Widgets()->getWidgets($url, parent::$tpl);

                return;
            }

            $this->render('index');
            return;
        }

        $this->renderMobile($url);
    }
    

    public function renderMobile($url)
    {
        if(file_exists(THEMES . $this->data->mobile->name . DS . $url . '.html'))
        {   
            parent::$tpl .= $this->getFile($url);

            $this->load->Controller_PageData()->getPageData($url);

            $this->load->Controller_PageData_Widgets()->getWidgets($url, parent::$tpl);
        }
        else
        {
            $this->render('index');
        }
    }
    /**
     *
     * @global type $SKIN - Theme name
     * @param type $file - Name of the file called
     * @return type - Content of the file called
     */
    public function getFile($file)
    {   
        if($this->mobile != true)
        {
            if(!is_object(self::$files[$file]))
            {    
                ob_start();
                include(THEMES . $this->data->name . DS . $file . '.html');
                $return .= ob_get_contents();
                ob_end_clean();
            
                self::$files[$file] = $return;
            }

            return self::$files[$file];
        }

        $this->getMobileFile($file);
    }

    public function getMobileFile($file)
    {   
        if(!is_object(self::$files['mobile'][$file]))
        {        
            ob_start();
            include(THEMES . $this->data->mobile->name . DS . $file . '.html');
            $return .= ob_get_contents();
            ob_end_clean();
            
            self::$files['mobile'][$file] = $return;
        }
        else
        {
            $return = self::$files['mobile'][$file];
        }
        
        return $return;
    }

    private function isCached()
    {
        $get = $this->load->Library_Cache_File()->get($this->load->url);

        if($get == false)
        {
            return false;
        }

        $this->outputtingCache = true;
        parent::$tpl = $get;

    }

    private function setCache($tpl)
    {
        if($this->outputtingCache == false)
        {
            $this->load->Library_Cache_File()->set($this->load->url, $tpl);
        }
    }
 
    /**
     * Used to echo strings, in the template's way.
     * @param type $str - Any string
     */
    public function display($str)
    {
	   parent::$tpl .= $this->filterParams($str);
    }
	
    /**
     * Output the template
     */
    public function outputTPL()
    {
    	$tpl = $this->filterParams(parent::$tpl);
        
        print $tpl;
        /**
         * Cache the template - DISABLED SINCE IT'S REALLY POINTLESS
         */
        
        // Not worth it.
        
        /**
         * Garbage collection 
         */
	       $tpl = null;
    }
    
    public function __get($key)
    {
	   $instance =& $this->getInstance();
	   return $instance->$key;
    }
    
}
?>