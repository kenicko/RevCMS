<?php

/**
 * Initialize a socket connection
 *
 * @author Kryptos
 */

class Library_Socket
{

    private $sock, $addr, $port;

    public function __construct() //$this->load->Library_Socket()->send('ha', 'Kryptos rocks')->close();
    {
        if($Rev->load->Rev_Configure()->site->mus->enabled == true)
        {
            $this->addr = $Rev->load->Rev_Configure()->config->mus->ip;
            $this->port = $Rev->load->Rev_Configure()->config->mus->port;

            return $this->connect($this->create(), $this->addr, $this->port);
        }

        return trigger_error("[NETWORK] Error: Tried to send socket but they're not enabled in the configuration files.", E_USER_ERROR);
    }

    public function create()
    {
        $this->sock = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
        return $this->sock;
    }
    
    public function connect($socket, $addr, $port)
    {
        if(socket_connect($socket, $addr, $port) == false)
        {
            trigger_error("[SOCKET] Error: " . socket_strerror(socket_last_error()), E_USER_ERROR);
        }
                
        return $this;
    }

    public function send($header, $data)
    {
        if(socket_send($this->sock, $header . chr(1) . $data, strlen($data), MSG_DONTROUTE) == false)
        {
            trigger_error("[SOCKET] Error: " . socket_strerror(socket_last_error()), E_USER_ERROR);
        } 

        return $this;
    }
                
    public function close()
    {
        # We will shutdown before closing to avoid a possible PHP bug! #
        socket_shutdown($this->socket, 2);

        socket_close($this->socket);
    }



}

?>
