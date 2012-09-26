<?php

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
    
    function showCaptcha()
    {
        echo 'CAPTCHA';
    }
    
    function validateCaptcha()
    {
        if(isset($_POST['captcha']))
        {
            echo 'WEEEE';
        }
    }
    
    function moreandmore($arg)
    {
        echo $arg;
    }
    
    function moreandmoreandmore($arg)
    {
        echo $arg . $arg;
    }
    
?>
