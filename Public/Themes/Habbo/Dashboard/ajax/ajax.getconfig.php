<?php

define('IN_INDEX', 1);
define('AJAX', 1);

/**
 * Initialize Environment.
 */ 
	session_start();
    require_once('../../../../../Application/Rev/Bootstrap.php');

$Rev = getInstance();

$Rev->load->helper('Dashboard');

if($Rev->load->Controller_ACL()->hasControl('configuration'))
{
	print getConfig();
}


?>