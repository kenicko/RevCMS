<?php

/**
 * Log actions and errors sent by the server to a file
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */ 
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Library_Log 
{
    
    private $openedFile;
    
    private $ErrorLog = '/TDS/Logs/ErrorLog.php';
    private $GeneralLog = '/TDS/Logs/Log.php';
    
    private $Level = array(
                            1 => 'EMERGENCY',
                            2 => 'CRITICAL',
                            3 => 'WARNING',
                            4 => 'NOTICE',
                            5 => 'GENERAL',
                    );
    
    public function __construct()
    {
        //Do nothing
    }
    
    public function writeError($str = null, $level = 5)
    {
        if(is_writable($this->ErrorLog))
        {
            if(!isset($this->errorFile))
            {
                $this->errorFile = fopen($this->ErrorLog, 'w');
            }
            
            fwrite($this->logFile, '[' . date('H:i:s') . '] ' . '[' . $this->Level[$level] . '] ' . $str . PHP_EOL) or trigger_error('Could not write to ' . $this->GeneralLog, E_USER_ERROR);
        
            $this->LevelAct($level, $str);
        }

    }
    
    public function Log($str = null, $level = 5)
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . $this->GeneralLog))
        {
            if(is_writable($_SERVER['DOCUMENT_ROOT'] . $this->GeneralLog))
            {
                if(!isset($this->logFile))
                {
                    $this->logFile = fopen($_SERVER['DOCUMENT_ROOT'] . $this->GeneralLog, 'a');   
                }   
            
                fwrite($this->logFile, '[' . date('d.m.y - H:i:s') . '] ' . '[' . $this->Level[$level] . '] ' . $str . PHP_EOL) or trigger_error('Could not write to ' . $this->GeneralLog, E_USER_ERROR);
            
                $this->LevelAct($level, $str);
                return;
            }

            trigger_error("{$this->GeneralLog} is not a writeable file.", E_USER_ERROR);
            return;
        }

        trigger_error("{$_SERVER['DOCUMENT_ROOT']}{$this->GeneralLog} does not exist.", E_USER_ERROR);

    }
    
    public function LevelAct($level, $str)
    {
        switch($level)
        {
            case 1:
                trigger_error($str);
            break;
                
            case 2:
                trigger_error($str, E_STRICT);
            break;
        
            case 3:
                trigger_error($str, E_USER_WARNING);
            break;
        
            default:
                //Move on
            break;
        }
    }
    
}

?>