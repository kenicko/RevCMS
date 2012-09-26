<?php
/**
 * Identifies the platform, browser, robot, or mobile devise of the browsing agent
 *
 * @author  ExpressionEngine Dev Team
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');

class Library_UserAgent
{
    
	public $agent           = null;

	public $isBrowser	= false;
	public $isRobot         = false;
	public $isMobile	= false;

	public $languages	= array();
	public $charsets	= array();

	public $platforms	= array();
	public $browsers	= array();
	public $mobiles         = array();
	public $robots		= array();

	public $platform;
	public $browser;
	public $version;
	public $mobile;
	public $robot;

	/**
	 * Constructor
	 *
	 * Sets the User Agent and runs the compilation routine
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		if(isset($_SERVER['HTTP_USER_AGENT']))
		{
			$this->agent = trim($_SERVER['HTTP_USER_AGENT']);
		}

		if (!is_null($this->agent))
		{
			if ($this->loadAgentFile())
			{
				$this->compileData();
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Compile the User Agent Data
	 *
	 * @access	private
	 * @return	bool
	 */
	private function loadAgentFile()
	{
		include(LIB . 'UserAgents' . DS . 'UserAgents.php');

		$return = FALSE;

		if (isset($platforms))
		{
			$this->platforms = $platforms;
			unset($platforms);
			$return = true;
		}

		if (isset($browsers))
		{
			$this->browsers = $browsers;
			unset($browsers);
			$return = true;
		}

		if (isset($mobiles))
		{
			$this->mobiles = $mobiles;
			unset($mobiles);
			$return = true;
		}

		if (isset($robots))
		{
			$this->robots = $robots;
			unset($robots);
			$return = true;
		}

		return $return;
	}

	// --------------------------------------------------------------------

	/**
	 * Compile the User Agent Data
	 *
	 * @access	private
	 * @return	bool
	 */
	private function compileData()
	{
		$this->setPlatform();

		foreach (array('setBrowser', 'setRobot', 'setMobile') as $function)
		{
			if ($this->$function() === TRUE)
			{
				break;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set the Platform
	 *
	 * @access	private
	 * @return	mixed
	 */
	private function setPlatform()
	{
		if(is_array($this->platforms) && count($this->platforms) > 0)
		{
			foreach($this->platforms as $key => $val)
			{
				if(preg_match("|".preg_quote($key)."|i", $this->agent))
				{
					$this->platform = $val;
					return true;
				}
			}
		}
                
		$this->platform = 'Unknown Platform';
	}

	// --------------------------------------------------------------------

	/**
	 * Set the Browser
	 *
	 * @access	private
	 * @return	bool
	 */
	private function setBrowser()
	{
		if (is_array($this->browsers) && count($this->browsers) > 0)
		{
			foreach ($this->browsers as $key => $val)
			{
				if (preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", $this->agent, $match))
				{
					$this->isBrowser = true;
					$this->version = $match[1];
					$this->browser = $val;
					$this->setMobile();
					return true;
				}
			}
		}
                
		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * Set the Robot
	 *
	 * @access	private
	 * @return	bool
	 */
	private function setRobot()
	{
		if(is_array($this->robots) && count($this->robots) > 0)
		{
			foreach($this->robots as $key => $val)
			{
				if (preg_match("|".preg_quote($key)."|i", $this->agent))
				{
					$this->isRobot = true;
					$this->robot = $val;
					return true;
				}
			}
		}
                
		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * Set the Mobile Device
	 *
	 * @access	private
	 * @return	bool
	 */
	private function setMobile()
	{
		if(is_array($this->mobiles) && count($this->mobiles) > 0)
		{
			foreach($this->mobiles as $key => $val)
			{
				if(false !== (strpos(strtolower($this->agent), $key)))
				{
					$this->isMobile = true;
					$this->mobile = $val;
					return true;
				}
			}
		}
		return false;
	}

	// --------------------------------------------------------------------

	/**
	 * Set the accepted languages
	 *
	 * @access	private
	 * @return	void
	 */
	private function setLanguages()
	{
		if((count($this->languages) == 0) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '')
		{
			$languages = preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE'])));

			$this->languages = explode(',', $languages);
		}

		if(count($this->languages) == 0)
		{
			$this->languages = array('Undefined');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set the accepted character sets
	 *
	 * @access	private
	 * @return	void
	 */
	private function setCharsets()
	{
		if((count($this->charsets) == 0) && isset($_SERVER['HTTP_ACCEPT_CHARSET']) && $_SERVER['HTTP_ACCEPT_CHARSET'] != '')
		{
                    $charsets = preg_replace('/(;q=.+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET'])));

                    $this->charsets = explode(',', $charsets);
		}

		if(count($this->charsets) == 0)
		{
                    $this->charsets = array('Undefined');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Is Browser
	 *
	 * @access	public
	 * @return	bool
	 */
	public function isBrowser($key = null)
	{
		if (!$this->isBrowser)
		{
			return false;
		}

		// No need to be specific, it's a browser
		if ($key === null)
		{
			return true;
		}

		// Check for a specific browser
		return array_key_exists($key, $this->browsers) && $this->browser === $this->browsers[$key];
	}

	// --------------------------------------------------------------------

	/**
	 * Is Robot
	 *
	 * @access	public
	 * @return	bool
	 */
	public function isRobot($key = null)
	{
		if (!$this->isRobot)
		{
			return false;
		}

		// No need to be specific, it's a robot
		if ($key === null)
		{
			return true;
		}

		// Check for a specific robot
		return array_key_exists($key, $this->robots) && $this->robot === $this->robots[$key];
	}

	// --------------------------------------------------------------------

	/**
	 * Is Mobile
	 *
	 * @access	public
	 * @return	bool
	 */
	public function isMobile($key = null)
	{
		if (!$this->isMobile)
		{
			return false;
		}

		// No need to be specific, it's a mobile
		if ($key === null)
		{
			return true;
		}

		// Check for a specific robot
		return array_key_exists($key, $this->mobiles) && $this->mobile === $this->mobiles[$key];
	}

	// --------------------------------------------------------------------

	/**
	 * Is this a referral from another site?
	 *
	 * @access	public
	 * @return	bool
	 */
	public function isReferral()
	{
            if(!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '')
            {
		return false;
            }
            
            return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Agent String
	 *
	 * @access	public
	 * @return	string
	 */
	public function agentString()
	{
            return $this->agent;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Platform
	 *
	 * @access	public
	 * @return	string
	 */
	public function platform()
	{
            return $this->platform;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Browser Name
	 *
	 * @access	public
	 * @return	string
	 */
	public function browser()
	{
            return $this->browser;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Browser Version
	 *
	 * @access	public
	 * @return	string
	 */
	public function version()
	{
            return $this->version;
	}

	// --------------------------------------------------------------------

	/**
	 * Get The Robot Name
	 *
	 * @access	public
	 * @return	string
	 */
	public function robot()
	{
            return $this->robot;
	}
	// --------------------------------------------------------------------

	/**
	 * Get the Mobile Device
	 *
	 * @access	public
	 * @return	string
	 */
	public function mobile()
	{
            return $this->mobile;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the referrer
	 *
	 * @access	public
	 * @return	bool
	 */
	public function referrer()
	{
            return (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '') ? '' : trim($_SERVER['HTTP_REFERER']);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the accepted languages
	 *
	 * @access	public
	 * @return	array
	 */
	public function languages()
	{
		if(count($this->languages) == 0)
		{
                    $this->setLanguages();
		}

		return $this->languages;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the accepted Character Sets
	 *
	 * @access	public
	 * @return	array
	 */
	public function charsets()
	{
		if(count($this->charsets) == 0)
		{
                    $this->setCharsets();
		}

		return $this->charsets;
	}

	// --------------------------------------------------------------------

	/**
	 * Test for a particular language
	 *
	 * @access	public
	 * @return	bool
	 */
	public function acceptLang($lang = 'en')
	{
		return (in_array(strtolower($lang), $this->languages(), true));
	}

	// --------------------------------------------------------------------

	/**
	 * Test for a particular character set
	 *
	 * @access	public
	 * @return	bool
	 */
	public function acceptCharset($charset = 'utf-8')
	{
		return (in_array(strtolower($charset), $this->charsets(), true));
	}

}
?>
