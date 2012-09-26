<?php
define('IN_INDEX', 1);
define('AJAX', 1);

/**
 * Initialize Environment.
 */ 
	session_start();
    require_once('../../../../../Application/Rev/Bootstrap.php');


$Rev = getInstance();
$Model = $Rev->load->Model();

if($Rev->load->Controller_User()->loggedIn())
{
	if($_POST['checkNameOnly'] == true && !empty($_POST['avatarName']))
	{
		print $Rev->load->Controller_PageData_Habbo_Identity_addAvatar()->CheckNameOnly($_POST['avatarName']);
		return;
	}
	
	if($_POST['checkFigureOnly'] == true && !empty($_POST['bean_gender']) && !empty($_POST['bean_figure']))
	{
		print $Rev->load->Controller_PageData_Habbo_Identity_addAvatar()->checkFigureOnly($_POST['bean_figure'], $_POST['bean_gender']);
		return;
	}

	if($_POST['refreshAvailableFigures'] == true)
	{
		print $Rev->load->Controller_PageData_Habbo_Identity_addAvatar()->refreshFigures();
		return;
	}

	print $Rev->load->View()->driver->filterParams($Rev->load->View()->driver->getFile("Widgets/Identity/nameTaken"));
}


?>