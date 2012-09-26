<?php

/**
 * MsSQL Driver
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Model_Driver_SQL_MsSQL extends Model implements Model_Driver_SQL_ISQL 
{
    
    protected $data, $fetchType, $row;

    protected $connType = array(
                                    'connect'   =>  mssql_connect, 
                                    'pconnect'  =>  mssql_pconnect  
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
                $this->fetchType = 'MSSQL_ASSOC';
            break;
                
            case 2:
                $this->fetchType = 'MSSQL_NUM';
            break;     
            
            default:
                $this->fetchType = 'MSSQL_BOTH';
            break;
        }
    }

    public function connect()
    {
        if(self::$connected != true)
        {
            self::$connection = $this->connType[$this->data->mssql->connType]($this->data->mssql->server, $this->data->mssql->user, $this->data->mssql->pass);
            
            if($this->connection)
            {
                $database = mysql_select_db($this->data->mssql->database, self::$connection);
                
                if($mydatabase)
                {
                    self::$connected = true;    
                }
                else
                {
                    trigger_error('Could not connect to MsSQL database, check your MsSQL details', E_USER_ERROR);
                }
            }
            else
            {
               trigger_error('Could not connect to MsSQL HOST, check your MsSQL details', E_USER_ERROR);      
            }
        }
    }
    
    public function disconnect()
    {
        if(self::$connected == true)
        {
            mssql_close(self::$connection);
            self::$connection = null;
            self::$connected = false;
        }
    }
    
    public function query($SQL, $params = null) 
    {   
        parent::$queries++;
        $this->currentQuery = mysql_query($SQL, self::$connection);

        return $this;
    }
    
    public function get() 
    { 
        while($this->row = mssql_fetch_array($this->currentQuery, $this->fetchType))
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
        return mssql_num_rows($this->currentQuery);
    }   
    
    public function free()
    {
        mssql_free_result($this->currentQuery);
    }
}

?>
