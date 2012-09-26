<?php

/**
 * Library class for Memcache, a highly effective caching daemon
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
    
class Library_Cache_Memcache
{
    
    protected $Memcache;
    
    protected $connected;
    
    public function __construct()
    {
        $this->Rev = getInstance();
        
        $this->Memcache = new Memcache();
        
        $this->connect($this->Rev->Rev_Configure()->config->cache->memcache);
    }
    
    public function connect($obj)
    {
        if($this->initiated != true)
        {
            if(is_object($obj))
            {
                foreach($obj as $server)
                {
                    $server = explode(';', $server);
                    foreach($server as $value)
                    {
                        $value = explode(':', $value);
                        $this->Memcache->addServer($value[0], $value[1]);
                    }
                }
            }
            
            $this->initiated = true;
        }
    }
    
    public function disconnect()
    {
        if($this->initiated == true)
        {
            $this->Memcache->close();
            
            $this->initiated = false;
        }
    }
    
    public function set($key, $var, $compress = false, $timestamp = null)
    {   
        $this->Memcache->add($key, $var, $compress, $timestamp);
    }
    
    public function delete($key)
    {
        $this->Memcache->delete($key);
    }
    
    public function replace($key, $var, $compress = false, $timestamp = null)
    {
        $this->Memcache->replace($key, $var, $compress, $timestamp);
    }
    
    public function get($key)
    {
        $data = $this->Memcached->get($key);
		
        return (is_array($data)) ? $data[0] : false;
    }
    
    public function delete()
    {
	return $this->Memcached->flush();
    }
    
    public function cacheInfo()
    {
	return $this->Memcached->getStats();
    }
    
    public function __destruct()
    {
        $this->disconnect();
    }
    
}

?>
