<?php

/**
 * Description of Logout
 *
 * @author Kryptos
 */
class Controller_PageData_Habbo_Dashboard_Logout extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        session_destroy();
        
        $this->load->View()->redirect('index');
    }
    
}

?>
