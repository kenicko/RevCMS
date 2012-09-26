<?php
/**
 * Bootstrap file
 * 
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
    
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP']; }
        
    /**
     * WAT IS DIS SYSTEMZ!!!!11!1?!?!!!?1!?!?!?!1?!ONE!??!?1?ELEVEN!!?!1?
     */
    
        define('SYSTEM', 'Rev');
        define('VERSION', '3.0');
        define('AUTHOR', 'Kryptos');
        
        define('COPYRIGHT', 'Powered by ' . SYSTEM . ' ' . VERSION . ' by ' . AUTHOR);
    
    /**
     * Are the following required extensions loaded?
     */
        define('APC_EXISTS', extension_loaded('apc'));
        define('CURL_EXISTS', extension_loaded('curl'));
        define("MEMCACHE_EXISTS", extension_loaded('memcache'));
        define('MYSQLI_EXISTS', extension_loaded('mysqli'));
        define('PDO_EXISTS', extension_loaded('pdo'));
        
    /**
     * Define all useds folders!
     */
        
        define('DS', DIRECTORY_SEPARATOR);

        if(!defined('AJAX'))
            define('ROOT', $_SERVER['DOCUMENT_ROOT'] . ((dirname($_SERVER['PHP_SELF']) == '/') ? dirname($_SERVER['PHP_SELF']) : dirname($_SERVER['PHP_SELF']) . DS));
        else
            define('ROOT', $_SERVER['DOCUMENT_ROOT'] . ((dirname($_SERVER['PHP_SELF']) == '/') ? dirname($_SERVER['PHP_SELF']) : dirname($_SERVER['PHP_SELF']) . DS) . '../../../../../');

        //define('ROOT', str_replace(array('\\', 'Application\Rev\\'), array(DS, ''), dirname(__FILE__) . DS));

            define('APP', ROOT . 'Application' . DS);
            
                define('REV', APP . 'Rev' . DS);
                
                define('LIB', APP . 'Library' . DS);
                    
                    define('FB', LIB . 'Facebook' . DS);
                
                    define('SESSION', LIB . 'Session' . DS);

                        define('SESSION_INTERFACE', SESSION . 'Interface' . DS);
        
                define('MODEL', APP . 'Model' . DS);
                
                    define('DATA', MODEL . 'Database' . DS);

                    define('MODEL_DRIVER', MODEL . 'Driver' . DS);

                        define('MODEL_DRIVER_INTERFACE', MODEL_DRIVER . 'Interface' . DS);
                
                define('VIEW', APP . 'View' . DS);

                    define('VIEW_DRIVER', VIEW . 'Driver' . DS);

                        define('VIEW_DRIVER_INTERFACE', VIEW_DRIVER . 'Interface' . DS);
                
                define('CONTROLLER', APP . 'Controller' . DS);
                
                    define('PAGEDATA', CONTROLLER . 'PageData' . DS);
        
            define('CONFIG', ROOT . 'Config' . DS);
            
                define('DOC', CONFIG . 'Documentation' . DS);

            define('PUB', ROOT . 'Public' . DS);
            
                define('THEMES', PUB . 'Themes' . DS);
                
                define('LANGS', PUB . 'Languages' . DS);
                
                define('UPLOADS', PUB . 'Uploads' . DS);                
        
            define('SCRIPTS', ROOT . 'Scripts' . DS);
            
                define('CRON', SCRIPTS . 'Cron' . DS);
                
                define('HELPERS', SCRIPTS . 'Helpers' . DS);
                    
                define('HOOKS', SCRIPTS . 'Hooks' . DS);

            define('TDS', ROOT . 'TDS' . DS);
            
                define('CACHE', TDS . 'Cache' . DS);

                    define('SESS_CACHE', CACHE . 'Session' . DS);
                
                define('DATABASE', TDS . 'Database' . DS);
                
                define('LOGS', TDS . 'Logs' . DS);
       
    
    /**
     * Call common functions file
     */
    
        require LIB . 'Common.php';

    
        
    /**
     * Monitor page load time
     */

        $time_start = getTime();
        
    /**
    * Set global URL variable
    */

    $URL = substr(implode('/' , explode('/', $_SERVER['REQUEST_URI'])), 1);

    if($URL != null && strpos($URL, '&'))
    {
        $URL = strstr($URL, '&', true);
    }           

    if($URL == null)
    {
        $URL = 'index';
    }

    /**
     * Are we in a production environment?
     */  
        define('PRODUCTION', false);


    /**
     * What errors do we want to see?
     */
        
        if(PRODUCTION == true) 
        {
            error_reporting(E_USER_ERROR);
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
        }
        elseif(PRODUCTION == false)
        {
            error_reporting(E_ALL & ~ ( E_STRICT | E_NOTICE ));
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
        }


    /**
     * Let's set some Misc stuff
     */
        date_default_timezone_set('America/New_York');

        
    /**
     * Finally, Initialize Environment
     */
        $Application = new stdClass();
        $Application->Controller = new Controller();
        
?>