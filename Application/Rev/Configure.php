<?php

/**
 * Store all the configuration values and manage them
 *
 * @author Kryptos
 */ 

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :('); 
    
class Rev_Configure 
{ 

    public $config;
    
    public function __construct()
    {
        $this->config = $this->get('Config');
    }

   /**
    * Update our config file with a new value
   	*/
    public function update($parent, $key, $value)
    {
        $this->config = $this->get('Config');
        $this->config->{$parent}->{$key} = $value;
        $this->set('Config', $this->config);
    }
 
   /**
    * Retrieve our config file
   	*/   
    public function get($config)
    {
    	if(file_exists(CONFIG . $config . '.php'))
    	{
        	$config = include(CONFIG . $config . '.php');
        	return unserialize($config);
        }
        
        header('Location: install/index.php');
        exit;
    }
    
   /**
    * Save our config file
   	*/
    public function set($config, $obj)
    {
        return file_put_contents(CONFIG . $config . '.php', "<?php if(!defined('IN_INDEX')) die; " . PHP_EOL . " return '" . serialize($obj) . "'; ?>");

    }
    
}

?>
