<?php

/**
 * Servers as an interface to Database Drivers
 *
 * @author Kryptos
 */

interface Model_Driver_SQL_ISQL
{
    
    public function connect();
    
    public function disconnect();
    
    public function query($SQL, $params = null);
    
    public function get();
    
    public function num_rows();
    
}

?>
