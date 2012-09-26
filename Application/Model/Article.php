<?php

/**
 * Handle news and campaigns 
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
	if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); } 

class Model_Article extends Model
{
	
	public function __construct()
	{
		parent::__construct();
		 
		$this->emu = $this->load->Rev_Configure()->config->emu; 

	}

   /**
	* Get headlines
	*/
	public function getNews($limit = 5)
	{
		$this->driver->query("SELECT {$this->emu->news['title']}, {$this->emu->news['id']}, {$this->emu->news['shortstory']}, {$this->emu->news['image']} FROM {$this->emu->news['tbl']} ORDER BY {$this->emu->news['id']} DESC LIMIT 5");

		if($this->driver->num_rows() > 0)
		{
			return $this->driver->get();
		}

		return null;
	}
	
   /**
	* Delete a news article
	*/
	public function deleteArticle($id)
	{
		$this->driver->query("DELETE FROM {$this->emu->news['tbl']} WHERE {$this->emu->news['id']} = ? LIMIT 1", array($id));
	}

   /**
	* Get an Article
	*/
	public function getArticle($id)
	{
		$this->driver->query("SELECT {$this->emu->news['title']}, {$this->emu->news['shortstory']}, {$this->emu->news['longstory']}, {$this->emu->news['published']}, {$this->emu->news['id']} FROM {$this->emu->news['tbl']} WHERE {$this->emu->news['id']} = ? LIMIT 1", array($id));

		if($this->driver->num_rows() > 0)
		{
			return $this->driver->get();
		}

		return null;
	}

   /**
	* Get list of articles
	*/
	public function getList($id)
	{
		$this->driver->query("SELECT {$this->emu->news['title']}, {$this->emu->news['id']} FROM {$this->emu->news['tbl']} WHERE {$this->emu->news['id']} != ? LIMIT 25", array($id));

		if($this->driver->num_rows() > 0)
		{
			return $this->driver->get();
		}

		return null;
	}
}
?>