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

if(!is_null($_GET['header']) && !is_null($_GET['data']))
{
	if($Rev->load->Controller_ACL()->hasControl('mus'))
	{
		$Rev->load->Library_Socket()->send($_GET['header'], $_GET['data'])->close();;
		return "Successfully sent the MUS message: {$_GET['header']} [{$_GET['data']}] to server";
	}

	print 'You are not allowed here.';
}

?>