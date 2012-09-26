<?php

/**
 * Description of MySQLi
 *
 * @author Kryptos
 * @author RastaLulz
 */
 
   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Model_Driver_SQL_MySQLi extends Model implements Model_Driver_SQL_ISQL
{
        
        private static $db, $result, $connected;
        
        public static $queries = 0;
        
        protected $data, $row;
        
        
        public function __construct()
	   {  
            $this->data = $this->load->Rev_Configure()->config->DB->mysql;
           
            $this->connect();
            
            $this->load->Rev_Configure()->config->emu = include_once DATA . $this->rConfigure->config->DB->emulator . '.php';
        }
            
        public function connect()
        {
            if(self::$connected != true)
            {
                $db = new mysqli($this->data->host, $this->data->user, $this->data->pass, $this->data->database);

                if($db->connect_errno)    
                {
                    trigger_error('Could not connect to MySQLi, check your details. Error thrown', E_USER_ERROR);
                }
                
                self::$db = $db;
                self::$connected = true;
            }
        } 
    
        public function disconnect()
        {
            if(self::$connected == true)
            {
                self::$db->close();
                self::$connected = false;
            }
        }
    
        public function query($SQL, $params = null) 
        {   
            $this->newQuery();
            
            if(self::$result = self::$db->prepare($SQL))
            {
                if($params != null) 
                {
                    array_unshift($params, $this->getVarTypes($params));
                    call_user_func_array(array(self::$result, 'bind_param'), $this->refreshParams($params));
                }
                
                self::$result->execute();
            }
            else
            {          	
                return trigger_error("MySQLi query <i> '" . $SQL . "'</i> failed", E_USER_ERROR);
            }
           
            
            return $this;
        }
        
        public function newQuery()
        {
            if(is_object(self::$result))
            {
                self::$result->close();
            }
            
            parent::$queries++;
            
            return true;
        }
    
        public function get() 
        {
            $parameters = $this->getFieldNames();
            call_user_func_array(array(self::$result, 'bind_result'), $this->refreshParams($this->getFieldNames()));  
        
            while(self::$result->fetch()) 
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
        
        public function id() 
        {
            return self::$result->insert_id;
        }

        public function num_rows() 
        {
            self::$result->store_result();
            
            return self::$result->num_rows;
        }
	   
        private function getVarTypes($array)
        {
            foreach($array as $value)
            {
                if(isset($return))
                {
                    $return .= substr(gettype($value), 0, 1);
                }
                else
                {
                    $return = substr(gettype($value), 0, 1);
                }
            }

            return $return;
        }
	
	    private function getFieldNames() 
	    {
            $meta = self::$result->result_metadata(); 
       
            while($field = $meta->fetch_field()) 
            {
            
                $parameters[] = &$this->row[$field->name];
          
            }
            
            return $parameters;
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