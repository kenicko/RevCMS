<?php

/**
 * Handle avatars
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
	if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); }  

class Model_Avatar extends Model
{
	
	public function __construct()
	{
		parent::__construct();
		 
		$this->emu = $this->load->Rev_Configure()->config->emu; 
	}

   /**
	* Get other of the user's avatars
	*/
	public function getAvatars($email, $currentUser, $limit = 10)
	{
		$this->driver->query("SELECT * FROM {$this->emu->users['tbl']} WHERE {$this->emu->users['email']} = ? AND {$this->emu->users['username']} != ? ORDER BY last_online DESC LIMIT 50", array($email, $currentUser));
		
		if($this->driver->num_rows() > 0)
		{
			return $this->driver->get();
		}

		return null;
	}
	
   /**
	* Get if a user owns an avatar
	*/
	public function ownsAvatar($email, $user)
	{
		$this->driver->query("SELECT {$this->emu->users['id']} FROM {$this->emu->users['tbl']} WHERE {$this->emu->users['email']} = ? AND {$this->emu->users['username']} = ? ORDER BY {$this->emu->users['last_online']} DESC LIMIT 15", array($email, $user));
		
		if($this->driver->num_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
}
?>