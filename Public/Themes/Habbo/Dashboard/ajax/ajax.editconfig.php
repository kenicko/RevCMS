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

if(!is_null($_GET['parent']) && !is_null($_GET['key']) && !is_null($_GET['value']))
{
	if($Rev->load->Controller_ACL()->hasControl('configuration'))
	{
		print editConfig($_GET['parent'], $_GET['key'], $_GET['value']);
	}
}

?>