<?php

function getInfo($username, $field) 
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();
	$Model->driver->query("SELECT {$Model->emu->users[$field]} FROM {$Model->emu->users['tbl']} WHERE {$Model->emu->users['username']} = ?", array($username));

	$result = $Model->driver->get();
	return $result[0][$field];
}

function getOnline()
{
	$Rev = getInstance();

	$Rev->load->Model()->driver->query("SELECT users_online FROM server_status"); 

	$result = $Rev->load->Model()->driver->get();
	return $result[0]['users_online'];
}

function ajaxRegister($user, $pass, $repass, $email)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();
	
	if(strlen($user) > 3 && strlen($pass) > 6)
	{
		if(!$Rev->load->Model_User()->isNameTaken($user))
		{
			if($pass === $repass && strlen($pass) > 6)
			{
				if($Rev->load->Controller_Validate()->validEmail($email))
				{
					$Rev->load->Model_User()->insert($user, md5(sha1($pass)), $email, $Rev->load->Rev_Configure()->config->user->motto, $Rev->load->Rev_Configure()->config->user->credits, $Rev->load->Rev_Configure()->config->user->pixels, $Rev->load->Rev_Configure()->config->user->rank, $Rev->load->Rev_Configure()->config->user->figure, $Rev->load->Rev_Configure()->config->user->gender);	
					
					return 1;
				}
				else
				{
					return 'Invalid email';
				}
			}
			else
			{
				return 'Passwords do not match';
			}
		}
		else
		{
			return 'Username already exists';
		} 
	}
	else
	{
		return 'Username or password are too short.';
	}
}

?>