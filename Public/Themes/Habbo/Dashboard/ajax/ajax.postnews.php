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

if(!empty($_POST['title']) && !empty($_POST['shortstory']) && !empty($_POST['longstory']) && !empty($_POST['image']))
{
	if($Rev->load->Controller_ACL()->hasControl('addnews'))
	{	
		print postNews($_POST['title'], $_POST['shortstory'], $_POST['longstory'], $_POST['image']);
		return;
	}

	print 'You are not allowed here.';
	return;
}

print 'Invalid request';
return;

?>