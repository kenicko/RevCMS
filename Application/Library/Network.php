<?php

/**
 * Initialize a network connection
 *
 * @author Kryptos
 */

class Library_Network
{

    private $host, $port, $hostIP, $stream, $status = array();

    public function __construct($host, $port)
    {
        $this->connect($host, $port, $timeout);
    }
    
    public function connect($host, $port, $timeout)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
        
        $this->hostIP = gethostbyname($this->host);
        
                
            $this->stream = fsockopen($this->host, $this->port, $errno, $errstr);
                
            if($this->stream == true)
            {
                return true;
            }
            else
            {
                trigger_error("[NETWORK] Error: {$errstr} ({$errno})", E_USER_ERROR);
            }
                        
    }
    
    public function disconnect()
    {
        if(is_object($this->stream))
        {
            fclose($this->stream);
        }
    }
    
    public function getStreamStatus()
    {
        $Rev = getInstance();        
        
        $this->status = socket_get_status($this->stream);
                        
        if($this->status['timed_out'] == true)
        {
            $Rev->load->Library_Log()->Log("[NETWORK] Connection timed out {$this->timeout} seconds");
        }
        elseif($this->status['blocked'] == true)
        {
            $Rev->load->Library_Log()->Log("[NETWORK] Connection blocked by host ({$this->host})");
        }
        elseif($this->status['eof'] == true)
        {
            $Rev->load->Library_Log()->Log('[NETWORK] Connection returned EOF');                   
        }
    }
                
    public function __destruct()
    {
        $this->disconnect();
    }



}

?>
