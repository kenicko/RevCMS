<?php

/**
 * XML DOM Class
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
    
class Library_XML 
{
    
    public $dom;
    public $xpath;
        
    public function __construct() 
    {
        $this->dom   = new DOMDocument('1.0', 'iso-8859-1');
        $this->xpath = new DOMXPath($this->dom);
    }
    
    public function data($file)
    {
        simplexml_load_file($file);
    }
    
}

?>
