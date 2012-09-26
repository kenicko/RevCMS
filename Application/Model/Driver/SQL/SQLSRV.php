<?php

/**
 * SQLSRV Driver
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Model_Driver_SQL_SQLSRV extends Model implements Model_Driver_SQL_ISQL
{

        protected $data, $fetchtype, $row;

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
                    $this->fetchType = 'SQLSRV_ASSOC';
                break;
                
                case 2:
                    $this->fetchType = 'SQLSRV_NUM';
                break;     
                
                default:
                    $this->fetchType = 'SQLSRV_BOTH';
                break;
            }
        }

        public function connect()
        {
            if(self::$connected != true)
            {
                self::$connection = sqlsrv_connect($this->data->sqlsrv->server, $this->data->sqlsrv->connectionInfo);
            
                if($this->connection)
                {
                    self::$connected = true;    
                }
                else
                {
                    trigger_error('Could not connect to SQL Server, check your details', E_USER_ERROR);    
                }
            }
        }
    
        public function disconnect()
        {
            if(self::$connected == true)
            {
                sqlsrv_close(self::$connection);
                self::$connection = null;
                self::$connected = false;
            }
        }
    
        public function query($SQL, $params = null) 
        {   
            parent::$queries++;
            $this->currentQuery = sqlsrv_query(self::$connection, $SQL, $params);

            return $this;
        }
    
        public function get() 
        { 
            while($this->row = sqlsrv_fetch_array($this->currentQuery, $this->fetchType))
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
            return sqlsrv_num_rows($this->currentQuery);
        }
        
        public function free()
        {
            sqlsrv_free_stmt($this->currentQuery);
        }
}
?>