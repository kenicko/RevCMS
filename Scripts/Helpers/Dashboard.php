<?php

function editConfig($parent, $key, $value)
{
	$Rev = getInstance();

	if(strpos($parent, '->'))
	{
		$part = explode('->', $parent);
		$parent = $part[0] . '->' . $part[1];
	}

	$Rev->load->Rev_Configure()->update($parent, $key, $value);

	$Rev->load->Library_Log()->Log("The config file key: {$key} was updated to {$value} by " . $Rev->load->Controller_User()->getUsername());
	return 'Successfully updated the configuration file.';
}

function getConfig()
{
	$Rev = getInstance();
	$rConfigure = $Rev->load->Rev_Configure();

	foreach($rConfigure->config as $key => $value)
    {
        foreach($value as $k => $v)
        {
            if(is_string($v) || is_numeric($v)) 
            {
                $return[$key . '->' . $k] = $v;
            }
        }
            
    }

    return json_encode($return);
}

function postNews($title, $shortstory, $longstory, $image)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();

    $Model->driver->query("INSERT INTO {$Model->emu->news['tbl']}({$Model->emu->news['title']}, {$Model->emu->news['shortstory']}, {$Model->emu->news['longstory']}, {$Model->emu->news['image']}, {$Model->emu->news['published']}) VALUES(?, ?, ?, ?, ?)", array($title, $shortstory, $longstory, $image, time()));
    
    return 'News succesfully created';
}


function getIPLookup($name)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();
    $Model->driver->query("SELECT * FROM {$Model->emu->users['tbl']} WHERE {$Model->emu->users['username']} = ?", array($name));

			if($Model->driver->num_rows() == 0) 
			{ 
				return 'User does not exist';
			}
			
			$getInfo = $Model->driver->get();

			if($getInfo[0]['rank'] >= $Rev->load->Controller_User()->getRank())
			{
				$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " tried to get the IP of {$name}");
				return 'You cannot search up IP logs on a user of a higher or equal rank than you.';
			} 
					
			$return = "<table cellspacing='0'>
							<tbody>
								<tr>
									<th><strong>Username</strong></th>
									<th><strong>E-Mail</strong></th>
									<th><strong>IP</strong></th>
								</tr><br>";

			$Model->driver->query("SELECT * FROM {$Model->emu->users['tbl']} WHERE {$Model->emu->users['ip_last']} = ?", array($getInfo[0][$Model->emu->users['ip_last']]));

			$return .= '<hr/>There are ' . $Model->driver->num_rows() . ' account(s) on this IP.<hr/>';

			foreach($Model->driver->get() as $v)
			{
				$return .= "
						<tr>
							<td>" . $v[$Model->emu->users['username']] . "</td>
							<td>" . $v[$Model->emu->users['email']] . "</td>
							<td>" . $v[$Model->emu->users['ip_last']] . "</td>
						</tr>"; 
			}
					
			$return .= "</tbody></table>";
			$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " got the IP of {$name}");
			return $return;
				
}
	
function banUser($name, $bantype, $reason, $expire)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();
	
	$Model->driver->query("SELECT * FROM {$Model->emu->users['tbl']} WHERE {$Model->emu->users['username']} = ?", array($name));
	
	if($Model->driver->num_rows() == 0)
	{ 
		return 'User does not exist';
	}

	$getInfo = $Model->driver->get();
			
	if($getInfo[0][$Model->emu->users['rank']] >= $Rev->load->Controller_User()->getRank())
	{
		$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " tried to ban {$name}");
		return 'You cannot ban a user with a higher or equal rank than you';
	}

	$Model->driver->query("SELECT * FROM {$Model->emu->bans['tbl']} WHERE {$Model->emu->bans['value']} = ? OR {$Model->emu->bans['value']} = ?", array($getInfo[0][$Model->emu->users['username']], $getInfo[0][$Model->emu->users['ip_last']]));

	 if($Model->driver->num_rows() == 0) 
	 { 	

		$banLength = time() + $expire;

		if($bantype == 'user')
		{
			$value = $name;
		}
		elseif($bantype == 'ip')
		{
			$value = $getInfo[0]['ip_last'];
		}
		
		$Model->driver->query("INSERT INTO {$Model->emu->bans['tbl']}({$Model->emu->bans['id']}, {$Model->emu->bans['bantype']},{$Model->emu->bans['value']},{$Model->emu->bans['reason']},{$Model->emu->bans['expire']},{$Model->emu->bans['added_by']},{$Model->emu->bans['added_date']}) VALUES('', ?, ?, ?, ?, ?, ?)", array($bantype, $value, $reason, $banLength, $Rev->load->Controller_User()->getUsername(), date("F d", time())));

		$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " just banned $name");
		
		return 'User was successfully banned!'; 	
	}
}

function vipUser($name)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();

	$Model->driver->query("SELECT * FROM {$Model->emu->users['tbl']} WHERE {$Model->emu->users['username']} = ?", array($name));
	if($Model->driver->num_rows() > 0)
	{ 
		$Model->driver->query("UPDATE {$Model->emu->users['tbl']} SET {$Model->emu->users['rank']} = '2' WHERE {$Model->emu->users['username']} = ? AND {$Model->emu->users['rank']} < 2", array($name));
		$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " just gave VIP to {$name}");
		return "VIP successfully given to {$name}"; 
	}

	return 'User does not exist'; 
}

function updateUser($name, $info, $value)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();
	
	$Model->driver->query("UPDATE {$Model->emu->users['tbl']} SET {$info} = ? WHERE {$Model->emu->users['username']} = ?", array($value, $name));

	$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " updated {$name}'s {$info} to {$value}");
	return ucfirst($info) . ' was successfully updated';
}

function getUser($name)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();

	$Model->driver->query("SELECT * FROM {$Model->emu->users['tbl']} WHERE {$Model->emu->users['username']} = ?", array($name));

	if($Model->driver->num_rows() == 0)
	{ 
		return 'User does not exist'; 

	}

	$getInfo = $Model->driver->get();

	if($getInfo[0]['rank'] >= $Rev->load->Controller_User()->getRank())
	{
		$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " tried to get the information of {$name}");
		return 'You cannot search for users with a higher or equal rank than you';
	}

	return json_encode($getInfo[0]);
}

function getBot($name)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();

	$Model->driver->query("SELECT * FROM bots WHERE name = ?", array($name));

	if($Model->driver->num_rows() == 0)
	{ 
		return 'Bot does not exist'; 

	}

	$getInfo = $Model->driver->get();

	return json_encode($getInfo[0]);
}

function deleteBot($name)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();

	$Model->driver->query("SELECT id FROM bots WHERE name = ?", array($name));

	if($Model->driver->num_rows() == 0)
	{ 
		return 'Bot does not exist'; 
	}

	$Model->driver->query("DELETE FROM bots WHERE name = ?", array($name));
	$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " just deleted the bot {$name}");
	return 'Successfully deleted Bot: ' . $name;
}

function updateBot($name, $info, $value)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();

	$Model->driver->query("UPDATE bots SET {$info} = ? WHERE name = ?", array($value, $name));

	$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " just updated the bot {$name}'s {$info} to {$value}");
	return ucfirst($info) . ' was successfully updated'; 
}

function giveBadge($name, $badge)
{
	$Rev = getInstance();
	$Model = $Rev->load->Model();

	$Model->driver->query("SELECT {$Model->emu->users['id']} FROM {$Model->emu->users['tbl']} WHERE {$Model->emu->users['username']} = ?", array($name));
	if($Model->driver->num_rows() > 0)
	{ 
		$userInfo = $Model->driver->get();

		$Model->driver->query("SELECT * FROM user_badges WHERE user_id = ? AND badge_id = ?", array($userInfo[0]['id'], $badge));
		
		if($Model->driver->num_rows() == 0)
		{
			$Model->driver->query("INSERT INTO user_badges(user_id, badge_id) VALUES(?, ?)", array($userInfo[0]['id'], $badge));

			$Rev->load->Library_Log()->Log("The user: " . $Rev->load->Controller_User()->getUsername() . " just gave the badge {$badge} to {$name}");
			return 'Badge: <b>' . $badge . '</strong> was successfully given to ' . $name;
		}
		
		return 'User already has this badge';

	}

	return 'User does not exist'; 
}
			
?>