<?php

/**
 * MongoDB driver class
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Model_Driver_NoSQL_Mongo extends Model
{
    
    private $Mongo, $db;
    private static $connected = false;

    protected $data;
    
    
    public function connect()
    {
    	if(!self::$connected)
    	{
    		$this->Mongo = new Mongo();

    		$this->db = $this->Mongo->{$this->data->mongo->database};

    		self::$connect = true;
	}    
    }
    
    public function disconnect()
    {
    	$this->Mongo = null;
    }

    public function newQuery($collection)
    {
    	$this->currentCollection = $collection;
    	parent::$queries++;

    	return $this;
    }
    
    public function insert($params = array())
    {
    	return $this->db->{$this->currentCollection}->insert($params);
    }

    public function update($criteria, $params = array())
    {
    	return $this->db->{$this->currentCollection}->update($criteria, $params);
    }

    public function save($params = array())
    {
    	return $this->db->{$this->currentCollection}->save($params);
    }
    
    public function get($params = null)
    {
    	return $this->db->{$this->currentCollection}->find($params);
    }
    
    public function num_rows($params = null)
    {
    	return $this->db->{$this->currentCollection}->count($params = null);
    }

    public function drop()
    {
    	return $this->db->{$this->currentCollection}->drop();
    }
    
}

?>