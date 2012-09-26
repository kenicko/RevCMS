<?php

/*
 * Common functions that can be used in the script
 * 
 * @author Kryptos
 * @author m0nsta.
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 

function &getInstance()
{
    return Controller::getInstance();    
}

function __autoload($class)
{
    $url = APP . str_replace('_', '/', $class) . '.php';
            
    if(file_exists($url) && !in_array($url, get_required_files()))
    {                
        require_once $url;
    }

}

function load_class($class, $folder = null)
{
    if(!is_object($classes_loaded[$class]))
    {
        $url = (!is_null($folder) ? APP . $folder . DIRECTORY_SEPARATOR . $class . '.php' : APP . $class . '.php');
        if(file_exists($url))
        {
            require_once $url;
            $classes_loaded[$class] = new $class;
        }
    }
    
    return $classes_loaded[$class];
    
}

function getTime()
{
        // Detect the time
        $time_now = microtime();

        // Separates seconds and milliseconds in array
        $array_time = explode(" ",$time_now);

        // We put together seconds and milliseconds
        $time_return = floatval($array_time[1]) + floatval($array_time[0]);
    
   
    return $time_return; 
}

function truncate($str, $allowed_length = 10) //echo truncate('test123', 4);
{
    return substr(trim($str), 0, $allowed_length);
}

function GeneratePassword($pw, $l = null, $u = null, $n = null, $s = null) // generatePW(7, true, true, true);
{

    $symbols               = "¬!\"£$%^&*()_+{}:@~<>?`-=[];'#,./";
    $numbers               = "1234567890";
    $upper                 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $lower                 = "abcdefghijklmnopqrstuvwxyz";

    if($s == true) $characters_to_include .= $symbols;
    if($n == true) $characters_to_include .= $numbers;
    if($u == true) $characters_to_include .= $upper;
    if($l == true) $characters_to_include .= $lower;

    /*none selected*/
    if (!$s && !$n && !$uc && !$lc) $characters_to_include = $numbers . $upper . $lower;
    /*none selected*/

    for($p = 1; $p <= $pw; $p++)
    {
        $password .= substr($characters_to_include, mt_rand($p, strlen($characters_to_include)), 1);
    }

    return htmlentities($password);
}

function getClass($method) 
{
    $first = strtolower(substr($method, 0, 1));
    $method = explode('_', $method);
    $method = $method[(count($method) - 1)];
    $method = $first . $method;  
  
    return $method;
}

function filter($var)
{
    return htmlspecialchars(mysql_real_escape_string($var));
}

function parse(array $arr, stdClass $parent = null) 
    {
       // if ($parent === null) $parent = $this->config;
    
        foreach($arr as $key => $val) 
        {
            if(is_array($val)) 
            {
                if($parent === null)
                {
                    $this->config->$key = $this->parse($val, new stdClass);
                }
                else
                {
                    $parent->$key = $this->parse($val, new stdClass);
                }
            } 
            else 
            {
                if($parent === null)
                {
                    $this->config->$key = $val;
                }
                else
                {
                    $parent->$key = $val;
                }
            }
        }

        return $parent;
    }

?>
