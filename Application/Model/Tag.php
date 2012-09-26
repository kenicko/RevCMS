<?php

/**
 * Handle user tags
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
	if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); }  

class Model_Tag extends Model
{
	
	public function __construct()
	{
		parent::__construct();
		 
		$this->emu = $this->load->Rev_Configure()->config->emu; 
	}

   /**
    * Insert a tag
   	*/
	public function addTag($id, $tag)
	{
		$this->driver->query("INSERT INTO user_tags(user_id, tag) VALUES(?, ?)", array($id, $tag));
	}

   /**
    * Get the tags of a user
   	*/
	public function getTags($id)
	{
		$this->driver->query("SELECT tag FROM user_tags WHERE user_id = ? ORDER BY RAND() LIMIT 5", array($id));

		if($this->driver->num_rows() > 0)
		{
			return $this->driver->get();
		}

		return null;
	}

   /**
    * Delete a user
   	*/
	public function deleteTag($id, $tag)
	{
		$this->driver->query("SELECT tag FROM user_tags WHERE user_id = ? AND tag = ? ORDER BY id DESC LIMIT 1", array($id, $tag));

		if($this->driver->num_rows() > 0)
		{
			$this->driver->query("DELETE FROM user_tags WHERE user_id = ? AND tag = ? ORDER BY id DESC LIMIT 1", array($id, $tag));
			return;
		}

		return null;
	}

}
?>