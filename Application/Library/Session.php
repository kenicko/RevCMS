<?php

/**
 * Custom Session handler
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
	if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');

class Library_Session
{

	protected static $initiated = false;
	
	protected static $maxlifetime;
	
	private static $Handler = null;
	
	public static $Rev;
	
	public function __construct() 
	{
		if(defined('AJAX')) return;
		
		self::$Rev = getInstance();
		
		if(self::$initiated != true)
		{
			self::InitializeSessionHandling();
			
			session_start();

			self::$initiated = true;
		}
	}
	
	public static function InitializeSessionHandling()
	{
		if(self::$Rev->load->Rev_Configure()->config->cache->session->type != 'Native')
		{
		
		   ini_set('session.save_handler', 'user');
		   self::$maxlifetime = self::$Rev->load->Rev_Configure()->config->cache->session->gc_maxlifetime;

			$Handler = 'Library_Cache_' . self::$Rev->load->Rev_Configure()->config->cache->session->type;

		   self::$Handler = self::$Rev->load->{$Handler}();
	
		   return session_set_save_handler(
			 array(__CLASS__, "open"),
			 array(__CLASS__, "close"),
			 array(__CLASS__, "read"),
			 array(__CLASS__, "write"),
			 array(__CLASS__, "destroy"),
			 array(__CLASS__, "gc")
			);

		}
	}

	public function terminateSessionWriting()
	{
		session_write_close();
	}
	
	public static function open()
	{
		return true;
	}

	public static function close()
	{ 
		return true; 
	}
	
	public static function read($id)
	{
		return self::$Handler->get($id);
	}
	
	public static function write($id, $data)
	{
		return self::$Handler->set($id, $data, self::$maxlifetime);
	}

	public static function destroy($id)
	{
		return self::$Handler->delete($id);
	}

	public static function gc()
	{ 
		return true; 
	}
	
}

?>
