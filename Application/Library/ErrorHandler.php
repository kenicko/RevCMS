<?php

/**
 * Description of ErrorHandling
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
    
class Library_ErrorHandler 
{
    private $error;
    private static $Rev;
    
    public function __construct()
    {
        self::$Rev = getInstance();
        self::Initialize();
    }
    
    private static function Initialize()
    {
        self::$Rev->load->Library_Log();
        
        set_error_handler(array(__CLASS__, 'errorHandler'));
        
        set_exception_handler(array(__CLASS__, 'exceptionHandler'));
    }
    
    private static function serverGlobal($global)
    {
	return $GLOBALS['_SERVER'][$global];
    }
    
    public static function errorHandler($code, $msg, $file, $line, $context)
    {
	switch($code) 
        {
		case E_ERROR:
                case E_WARNING:
                case E_PARSE:
                case E_NOTICE:
		case E_CORE_ERROR:
                case E_CORE_WARNING:
                case E_COMPILE_ERROR:
                case E_COMPILE_WARNING:
		case E_USER_ERROR:
                case E_USER_WARNING:
		case E_USER_NOTICE:
                case E_STRICT:
                case E_RECOVERABLE_ERROR:
                case E_DREPRECATED:
                case E_USER_DEPRECATED:
                case E_ALL:
		default:
                    self::errorParser($code, $msg, $file, $line, $context);
		break;
	}

	return true;
        die;
    }
    
    private static function errorParser($code, $msg, $file, $line, $context)
    {
        self::$Rev->load->View()->driver->assign('error->code', $code. true)
                                        ->assign('error->message', $msg, true)
                                        ->assign('error->fine', $file, true)
                                        ->assign('error->line', $line, true)
                                        ->assign('error->context', $context, true)
                                        ->assign('date', date("D M Y", self::serverGlobal('REQUEST_TIME')), true)
                                            ->assign('time', date("H:i:s", self::serverGlobal('REQUEST_TIME')), true)
                                            ->assign('userAgent', self::serverGlobal('HTTP_USER_AGENT'), true)
                                            ->assign('software', self::serverGlobal('SERVER_SOFTWARE'), true)
                                            ->assign('ipaddr', self::serverGlobal('SERVER_ADDR'), true)
                                            ->assign('port', self::serverGlobal('SERVER_PORT'), true)
                                            ->assign('path',self::serverGlobal('SCRIPT_FILENAME'), true)
                                            ->assign('uri', self::serverGlobal('HTTP_HOST').self::serverGlobal('REQUEST_URI'), true)
                                            ->assign('phpVer', "PHP " . PHP_VERSION . " (" . PHP_OS . ")");
                                                  
                                            //Ok, something passes through here, 71 times. WHAT. THE. FUCK.
                                            //Render the shit
               return true;
               
               die;
    }
    
    public static function exceptionHandler($exception)
    {

	$traceline = "#%s %s(%s): %s(%s)";

	$trace = $exception->getTrace();
                
        foreach ($trace as $key => $stackPoint) 
        {
            // I'm converting arguments to their type (prevents passwords from ever getting logged as anything other than 'string')
            $trace[$key]['args'] = array_map('gettype', $trace[$key]['args']); 
        }

		// build your tracelines
		$result = array();
			
                foreach ($trace as $key => $stackPoint) 
                {
                    $result[] = sprintf(
				$traceline,
				$key,
				$stackPoint['file'],
				$stackPoint['line'],
				$stackPoint['function'],
				implode(', ', $stackPoint['args'])
			);

                    $result[] = '#' . ++$key . ' {main}';
		}
                        
                self::$Rev->load->View()->driver->assign('date', date("D M Y", self::serverGlobal('REQUEST_TIME')))
                                                ->assign('time', date("H:i:s", self::serverGlobal('REQUEST_TIME')))
                                                ->assign('userAgent', self::serverGlobal('HTTP_USER_AGENT'))
                                                ->assign('software', self::serverGlobal('SERVER_SOFTWARE'))
                                                ->assign('ipaddr', self::serverGlobal('SERVER_ADDR'))
                                                ->assign('port', self::serverGlobal('SERVER_PORT'))
                                                ->assign('path',self::serverGlobal('SCRIPT_FILENAME'))
                                                ->assign('uri', self::serverGlobal('HTTP_HOST').self::serverGlobal('REQUEST_URI'))
                                                ->assign('phpVer', "PHP " . PHP_VERSION . " (" . PHP_OS . ")")
                                                    ->assign('error->class', get_class($exception))
                                                    ->assign('error->file', $exception->getFile())
                                                    ->assign('error->line', $exception->getLine())
                                                    ->assign('error->result', implode('\n', $result))
                                                    ->assign('error->message', $exception->getMessage)
                                                    ->assign('error->code', $exception->getCode());
                
                self::$Rev->load->View()->driver->display(self::$Rev->load->View()->driver->getFile('Error/exceptionHandler'));
                //self::$Rev->load->View()->driver->outputTPL();

		return true;
		//die;
	}
        
}

?>
