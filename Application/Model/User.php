<?php

/**
 * Handle user information
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
	if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); }  

class Model_User extends Model
{
	
	public function __construct()
	{
		parent::__construct();
		 
		$this->emu = $this->load->Rev_Configure()->config->emu; 
	}

	#############################
	#							#
	#       Insert data         #
	#							#
	#############################

   /**
    * Insert a ticket
   	*/
	public function insertTicket($id, $sso)
	{
		if($this->getTicket($id) == false)
		{
			$this->driver->query($this->emu->query['insert_sso'], array($id, $sso, $_SERVER['REMOTE_ADDR']));
			return;
		}
		
		$this->updateTicket($id, $sso);
	}
	
   /**
    * Insert an activation code 
   	*/
	public function insertActivationCode($email, $newpass, $code)
	{
		$this->driver->query("INSERT INTO rev_codes(email, newpass, code) VALUES(?, ?, ?)", array($email, $newpass, $code));
	}

	/**
    * Insert a word to filer
   	*/
	public function insertFilter($word)
	{
		$this->driver->query($this->emu->query['insert_filter'], array($word));
	}
	

   /**
    * Insert a user
   	*/
	public function insert($user, $pass, $email, $motto, $credits, $pixels, $rank, $figure, $gender)
	{
		$sessionKey = 'Rev-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33); 

		$this->driver->query("INSERT INTO {$this->emu->users['tbl']} ({$this->emu->users['username']}, {$this->emu->users['password']}, {$this->emu->users['email']}, {$this->emu->users['motto']}, {$this->emu->users['credits']}, {$this->emu->users['pixels']}, {$this->emu->users['rank']}, {$this->emu->users['figure']}, {$this->emu->users['gender']}, {$this->emu->users['ip_last']}, {$this->emu->users['ip_reg']}, {$this->emu->users['account_created']}, {$this->emu->users['last_online']}) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, '" . $_SERVER['REMOTE_ADDR'] . "', '" . $_SERVER['REMOTE_ADDR'] . "', '" . time() . "', '" . time() . "')", array($user, $pass, $email, $motto, $credits, $pixels, $rank, $figure, $gender));  

	}


	#############################
	#							#
	#        Update data        #
	#							#
	#############################

   /**
    * Update the info of a user
   	*/
	public function updateInfo($username, $key, $value)
	{
		$this->driver->query("UPDATE {$this->emu->users['tbl']} SET {$this->emu->users[$key]} = ? WHERE {$this->emu->users['username']} = ? OR {$this->emu->users['email']} = ?", array($value, $username, $username));
	}

   /**
    * Update the SSO ticket of a user
   	*/
	public function updateTicket($id, $value)
	{
		$this->driver->query($this->emu->query['update_sso'], array($value, $id));
	}


	#############################
	#							#
	#         Get data          #
	#							#
	#############################


   /**
    * Get the info of a user
   	*/
	public function getInfo($username, $key = null)
	{
		if($key != null)
		{
			$q = "SELECT {$this->emu->users[$key]} FROM {$this->emu->users['tbl']} WHERE {$this->emu->users['username']} = ? OR {$this->emu->users['email']} = ? ORDER BY {$this->emu->users['last_online']} DESC LIMIT 1";

			$this->driver->query($q, array($username, $username));

			$return = $this->driver->get();
			$return = $return[0][$this->emu->users[$key]];
			
			return $return;
		}
		else
		{
			$fields = 'id';
			foreach($this->emu->users as $key => $value)
			{
				if($key != 'id' && $key != 'tbl')
				{
				  	$fields .= ', ' . $value;
				}
			}

			$q = "SELECT {$fields} FROM {$this->emu->users['tbl']} WHERE {$this->emu->users['username']} = ? OR {$this->emu->users['email']} = ? ORDER BY {$this->emu->users['last_online']} DESC LIMIT 1";

			$this->driver->query($q, array($username, $username));
			
			return $this->driver->get();
		}
	}


   /**
    * Get the SSO ticket of a user
   	*/
	public function getTicket($id)
	{
		$this->driver->query($this->emu->query['get_sso'], array($id));

		if($this->driver->num_rows() > 0)
		{	
			$sso = $this->driver->get();
			return $sso[0][$this->emu->sso];
		}
		
		return false;
	}

   /**
    * Get count of user's online
   	*/
	public function getOnline()
	{
		$this->driver->query($this->emu->query['get_online']);
		
		return $this->driver->num_rows();
	}

   /**
    * Get the newest users
   	*/
	public function getNewestUsers($limit)
	{
		$this->driver->query("SELECT {$this->emu->users['id']}, {$this->emu->users['username']}, {$this->emu->users['figure']}, {$this->emu->users['motto']}, {$this->emu->users['last_online']} FROM {$this->emu->users['tbl']} ORDER BY id ASC LIMIT {$limit}");

		if($this->driver->num_rows() > 0)
		{
			return $this->driver->get();
		}

		return null;
	}


	#############################
	#							#
	#        Validators         #
	#							#
	#############################


   /**
    * Check if a user has valid info
   	*/
	public function validInfo($user) //There is no way to validate this shit when it returns a boolean
	{
		$this->driver->query("SELECT {$this->emu->users['id']} FROM {$this->emu->users['tbl']} WHERE {$this->emu->users['username']} = ? AND {$this->emu->users['password']} = ? OR {$this->emu->users['email']} = ? AND {$this->emu->users['password']} = ? LIMIT 1", array($user, $this->emu->login['hash'], $user, $this->emu->login['hash']));

		if($this->driver->num_rows() > 0)
		{
			return true;
		}

		return false;
	}

   /**
    * Check if an IP has already registered
   	*/
	public function isRegistered($ip)
	{
		$this->driver->query("SELECT {$this->emu->users['id']} FROM {$this->emu->users['tbl']} WHERE {$this->emu->users['ip_last']} = ?", array($ip));
		
		if($this->driver->num_rows() > 2)
		{
			return true;
		}
		
		return false;
	}

   /**
    * Check if an activate code exists
   	*/
	public function codeExists($code)
	{
		$this->driver->query("SELECT email, newpass FROM rev_codes WHERE code = ? LIMIT 1", array($code));
		
		if($this->driver->num_rows() > 0)
		{
			$return = $this->driver->get();
			return $return[0];
		}
		
		return false;
	}

   /**
    * Check if the username is taken
   	*/
	public function isNameTaken($user)
	{ 
		$this->driver->query("SELECT * FROM {$this->emu->users['tbl']} WHERE {$this->emu->users['username']} = ? LIMIT 1", array($user));
		
		if($this->driver->num_rows() > 0)
		{
			return true;
		}

		return false;
	}

   /**
    * Check if an email is taken
   	*/
	public function isEmailTaken($email)
	{ 
		$this->driver->query("SELECT * FROM {$this->emu->users['tbl']} WHERE {$this->emu->users['email']} = ? LIMIT 1", array($email));
		
		if($this->driver->num_rows() > 0)
		{
			return true;
		}

		return false;
	}

	/**
    * Check if a user is online
   	*/
	public function isOnline($id)
	{
		$this->driver->query($this->emu->query['isOnline'], array($id));

		if($this->driver->num_rows() > 0)
		{
			return 'online';
		}

		return 'offline';
	}

   /**
    * Check if a user is banned
   	*/
	public function isBanned($ip, $user)
	{
		$this->driver->query("SELECT * FROM {$this->emu->bans['tbl']} WHERE {$this->emu->bans['value']} = ? OR {$this->emu->bans['value']}= ? LIMIT 1", array($user, $ip));
		
		if($this->driver->num_rows() > 0)
		{
			$get = $this->driver->get();
			return $get[0];
		}
		
		return false;
	}

	#############################
	#							#
	#        Handle Ranks       #
	#							#
	#############################


   /**
    * Get all the ranks
   	*/
	public function getRanks()
	{
		$this->driver->query("SELECT {$this->emu->ranks['id']}, {$this->emu->ranks['name']} FROM {$this->emu->ranks['tbl']} WHERE {$this->emu->ranks['id']} > 3 ORDER BY id DESC");

		if($this->driver->num_rows() > 0)
		{
			return $this->driver->get();
		}

		return null;
	}

   /**
    * Get the info from the staff members
   	*/
	public function getStaff()
	{
		$this->driver->query("SELECT u.{$this->emu->users['id']}, u.{$this->emu->users['username']}, u.{$this->emu->users['rank']}, u.{$this->emu->users['figure']}, u.{$this->emu->users['motto']}, u.{$this->emu->users['last_online']}, r.{$this->emu->ranks['name']} AS rankname FROM {$this->emu->users['tbl']} u INNER JOIN {$this->emu->ranks['tbl']} r ON r.{$this->emu->ranks['id']} = u.{$this->emu->users['rank']} WHERE u.{$this->emu->users['rank']} >= ? ORDER BY u.{$this->emu->users['rank']} DESC", array(3));

		if($this->driver->num_rows() > 0)
		{
			return $this->driver->get();
		}

		return null;
	}


}
?>