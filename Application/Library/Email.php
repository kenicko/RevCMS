<?php

/**
 * Library class for Mail server - Needs improvement, just did something quick because of boredom
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Library_Email
{
    
    private $to;
    private $from;
    private $title;
    private $body;
    
    private $email;
    
    public function __construct($array)
    {

        $this->to = $array[0];
        $this->from = $array[1];
        $this->title = $array[2];
        $this->body = $array[3];
        
        $this->send();
    }
    
    public function send()
    {
        if(mail($this->to, $this->title, $this->body, "From: {$this->from} "))
        {
            return true;
        }
        
        trigger_error("Unable to send Email to: <b> {$this->to} </b>", E_USER_ERROR);
    }
    
    
}

?>
