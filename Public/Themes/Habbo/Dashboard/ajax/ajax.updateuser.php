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

if(!is_null($_GET['name']) &&  !is_null($_GET['info']) && !is_null($_GET['value']))
{
	if($Rev->load->Controller_ACL()->hasControl('user'))
	{
		print updateUser($_GET['name'], $_GET['info'], $_GET['value']);
		return;
	}
	
	print 'You are not allowed here.';
}

?>