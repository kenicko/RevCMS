<?php

/**
 * IDriver servers as an interface to Template Drivers
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');

interface View_Driver_IDriver
{
    
    public function render($url);
    
    public function getFile($file);
    
    public function assign($key, $value);
    
    public function display($str);
    
    public function outputTPL();
    
}

?>
