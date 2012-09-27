<?php

function Install($post)
{
	$insert = new stdClass();

	foreach($post as $key => $value)
	{
		if($key != 'username' && $key != 'lpassword' && $key != 'email' && $key != 'submit')
		{	
			$explode = explode('->', $key);

			switch(count($explode))
			{
				case 2:
					if(!is_object($insert->$explode[0])) $insert->$explode[0] = new stdClass();

					$insert->$explode[0]->$explode[1] = addslashes($value);
				break;

				case 3:
					if(!is_object($insert->$explode[0])) $insert->$explode[0] = new stdClass();

					if(!is_object($insert->$explode[0]->$explode[1])) $insert->$explode[0]->$explode[1] = new stdClass();

					$insert->$explode[0]->$explode[1]->$explode[2] = addslashes($value);
				break;

				default:
					$insert->$key = $value;
				break;
			}
		}
	}

	$conn = mysql_connect($insert->DB->mysql->host, $insert->DB->mysql->user, $insert->DB->mysql->pass) or die(mysql_error());

	if(!$conn)
	{
		$error = 'Could not connect to the MySQL host';
		die($error);
	}

	$db = mysql_select_db($insert->DB->mysql->database);

	if(!$db)
	{
		$error = 'Could not connect to the MySQL database';
		die($error);
	}

	if(!isset($error))
	{
		//Set default data
		$insert->site->url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		$insert->site->production = true;
		$insert->skin->driver = 'Rev';
		$insert->DB->driver = 'SQL_MySQLi';

		//Get the default Access-Control-List
		$insert->acl = getACL();

		//Get the cache shit
		$insert->session = getSession();

		//Get skin shit
		$insert->skin->page = getPage();
		$insert->skin->mobile = getMobile();
		$insert->skin->pagedata = getPageData();

		if(!empty($_POST['username']) && !empty($_POST['lpassword']) && !empty($_POST['email'])) 
		{
			adminRegister($insert);
		}

		cSet($insert);

		die('Succesfully installed, now delete the /install/ folder and enjoy your hotel!');
	}

}

function getACL()
{
	$acl = new stdClass();
	$acl->administrator = '6,7';
	$acl->moderator = '4,5,6,7';
	$acl->vip = '3';
	$acl->ban = '4,5,6,7';
	$acl->iplookup = '4,5,6,7';
	$acl->addbot = '5,6,7';
	$acl->editbot = '5,6,7';
	$acl->badge = '6,7';
	$acl->user = '6,7';
	$acl->mus = '7';
	$acl->roomaker = '7';
	$acl->wordfilter = '6,7';
	$acl->addnews = '5,6,7';
	$acl->editnews = '5,6,7';
	$acl->addcampaign = '6,7';
	$acl->configuration = '7';

	return $acl;
}

function getSession()
{
	$session = new stdClass();
	$session->type = 'Native';
	$session->gc_maxlifetime = 86400;
	$session->memcache = '127.0.0.1:11211';

	return $session;
}

function getPage()
{
	$page = new stdClass();
	$page->default = 'index';

	return $page;
}

function getMobile()
{
	$mobile = new stdClass();
	$mobile->enabled = true;
	$mobile->name = 'Icecron';

	return $mobile;
}

function getPageData()
{
	$pagedata = new stdClass();

	$pagedata->default = 'Suelake';

	return $pagedata;
}

function adminRegister($insert)
{
	include('../Application/Model/Database/' . $insert->DB->emulator . '.php');

	mysql_query("INSERT INTO {$DB['data']['users']['tbl']} ({$DB['data']['users']['username']}, {$DB['data']['users']['password']}, {$DB['data']['users']['email']}, {$DB['data']['users']['motto']}, {$DB['data']['users']['credits']}, {$DB['data']['users']['pixels']}, {$DB['data']['users']['rank']}, {$DB['data']['users']['figure']}, {$DB['data']['users']['gender']}, {$DB['data']['users']['ip_last']}, {$DB['data']['users']['ip_reg']}, {$DB['data']['users']['account_created']}, {$DB['data']['users']['last_online']}) VALUES('{$_POST['username']}', '{$DB['data']['login']['hash']}', '{$_POST['email']}', '{$insert->user->motto}', '{$insert->user->credits}', '{$insert->user->pixels}', '7', '{$insert->user->figure}', '{$insert->user->gender}', '" . $_SERVER['REMOTE_ADDR'] . "', '" . $_SERVER['REMOTE_ADDR'] . "', '" . time() . "', '" . time() . "')");  
	
}

function cSet($obj)
{
	if(is_writable('../Config/'))
	{
		if(!file_exists("../Config/Config.php"))
		{
    		return file_put_contents("../Config/Config.php", "<?php if(!defined('IN_INDEX')) die; " . PHP_EOL . " return '" . serialize($obj) . "'; ?>");
    	}

    	die('The Config file has already been created.');
    }
    
    die('The /Config/ folder is not writeable, you must CHMOD it.');

}

?>
