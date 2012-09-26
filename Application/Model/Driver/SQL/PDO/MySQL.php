<?php

/**
 * Database management class using PDO with MySQL
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Model_Driver_SQL_PDO_MySQL extends Model implements Model_Driver_SQL_ISQL
{
    
        private static $db, $result, $connected;
        
        public static $queries = 0;
        
        protected $data, $row;
        
        
        public function __construct()
        {
            $this->connect();
        }
        
        public function connect()
        {
            if(self::$connected != true)
            {
                try
                {
                    self:$db = new PDO("mysql:host={$this->data->host};dbname={$this->data->database}", $this->data->user, $this->data->pass);

                    self::$connected = true;
                }
                catch(PDOException $e)
                {
                    throw new Exception('Could not connect to MySQL server, check your details.');
                }
            }
        }
        
        public function disconnect()
        {
            if(self::$connected == true)
            {
                self::$db = null;
                self::$connected = false;
            }
        }
        
        public function query($SQL, $params = null)
        {
            $this->queries++;
            
            if(self::$result = self::$db->prepare($SQL))
            {
                self::$result->execute($params);
            }
            else
            {
                trigger_error("PDO query <i> '" . $SQL . "'</i> failed", E_USER_ERROR);
            }
           
            
            return $this;
        }
        
        public function get()
        {
            while($this->row = self::$result->fetch()) 
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
            return  self::$result->rowCount();;
        }
        
        public function id()
        {
            return self::$result->lastInsertId();
        }
        
        private function refreshParams($params) 
        {
            $temp = array();
        
            foreach($params as $key => $value) 
            {
                $temp[$key] = &$params[$key];
            }
        
            return $temp;
        }
    
        
}   


?>
