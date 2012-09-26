<?php

/**
 * Description of MySQL
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Model_Driver_SQL_MySQL extends Model implements Model_Driver_SQL_ISQL
{

        protected $data, $fetchtype, $row;

        protected $connType = array(
                                    'connect'   =>  mysql_connect, 
                                    'pconnect'  =>  mysql_pconnect
                        ); 

    	private static $connection, $connected, $result;
        
        
	public function __construct()
	{   
            $this->setFetchType(1);

            $this->connect();
	}

        private function setFetchType($type)
        {
            switch($type)
            {
                case 1:
                    $this->fetchType = 'MYSQL_ASSOC';
                break;
                
                case 2:
                    $this->fetchType = 'MYSQL_NUM';
                break;     
                
                default:
                    $this->fetchType = 'MYSQL_BOTH';
                break;
            }
        }

        public function connect()
        {
            if(self::$connected != true)
            {
                self::$connection = mysql_pconnect($this->data->mysql->host, $this->data->mysql->user, $this->data->mysql->pass);
            
                if($this->connection)
                {
                    $database = mysql_select_db($this->data->mysql->database, self::$connection);
                
                    if($database)
                    {
                        self::$connected = true;    
                    }
                    else
                    {
                        trigger_error('Could not connect to MySQL database, check your MySQL details', E_USER_ERROR);
                    }
                }
                else
                {
                   trigger_error('Could not connect to MySQL HOST, check your MySQL details', E_USER_ERROR);   
                }
            }
        }
    
        public function disconnect()
        {
            if(self::$connected == true)
            {
                mysql_close(self::$connection);
                self::$connection = null;
                self::$connected = false;
            }
        }
    
        public function query($SQL, $params = null) 
        {   
            parent::$queries++;

            while(strpos($SQL, '?') !== false)
            {
                $SQL = preg_replace('/\?/', mysql_real_escape_string(stripslashes(htmlspecialchars((is_string($params) ? "'" . array_shift($params) . "'" : array_shift($params))))), $SQL, 1);
            }

            $this->currentQuery = mysql_query($SQL, self::$connection) or trigger_error("MySQLi query <i> {$SQL} </i> failed", E_CORE_ERROR);

            return $this;
        }
    
        public function get() 
        { 
            while($this->row = mysql_fetch_array($this->currentQuery, $this->fetchType))
            {  
                $x = array();  
          
                foreach($this->row as $key => $val) 
                {  
                    $x[$key] = $val;  
                }  
            
                $data[] = $x;
            }
            
            return $data;
        }

        public function num_rows() 
        {
            return mysql_num_rows($this->currentQuery);
        }
        
        public function free()
        {
            mysql_free_result($this->currentQuery);
        }
}
?>