<?php

/**
 * Library class for APC, a free and open opcode cache
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Library_Cache_APC
{

    public function __construct()
    {   
        if(!APC_EXISTS)
        {
            trigger_error('Could not find extension: <b> APC </b>', E_USER_ERROR);
        }
    }
    
    public function get($key)
    {
        if($this->exists($key))
        {
            $data = apc_fetch($key);
            return (is_array($data)) ? $data[0] : false;
        }
    }
    
    public function set($key, $var, $timestamp = null)
    {
        apc_add($key, $var, $this->Rev->load->Rev_Configure()->config->cache->apc->time);
    }
    
    public function delete($key)
    {
        if($this->exists($key))
        {
            apc_delete($key);
        }
    }
    
    public function deleteAll()
    {
	return apc_clear_cache('user');
    }
    
    public function exists($key)
    {
        return apc_exists($key);
    }
    
    public function cache_info($type = null)
    {
        return apc_cache_info($type);
    }
    
}

?>
