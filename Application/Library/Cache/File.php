<?php
/**
 * Cache files
 * 
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Library_Cache_File 
{

    public $hashing = true;

    public function __construct() 
    {
        $this->dir = CACHE;
    }

    public function get($key) 
    {       
        if (file_exists($this->dir . md5($key)))
        {
            $data = file_get_contents($this->dir . md5($key)) ;
            $expire = substr($data, 0, 10);

            if(time() < $expire)
            {
                return unserialize(substr($data, 10));
            }
            else
            {
                unlink($this->dir . md5($key));
                return false;
            }
        }

        return false;
    }

    public function set($name, $value, $expire = 31536000) 
    {
        $expire = time()+$expire;
        return file_put_contents($this->dir . md5($name), $expire.serialize($value), LOCK_EX);
    }


    public function delete($name) 
    {
        if(file_exists($this->dir . md5($name))) 
        {
            unlink($this->dir . md5($name));
            return true;
        }
        return false;
    }

    /**
     * Deletes all data cache files
     * @return bool
     */
    public function deleteAll() 
    {
        if($handle = opendir($this->dir))
        {
            while(($file = readdir($handle)) !== false) 
            {
                $file = $this->dir . $file;
                
                if(is_file($file))
                {
                    unlink($file);
                }
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}
