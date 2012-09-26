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

if(!is_null($_GET['name']) && !is_null($_GET['bantype']) && !is_null($_GET['expire']) && !is_null($_GET['reason']))
{
	if($Rev->load->Controller_ACL()->hasControl('ban'))
	{
		print banUser($_GET['name'], $_GET['bantype'], $_GET['reason'], $_GET['expire']);
		return;
	}

	print 'You are not allowed here.';
	return;
}

?>