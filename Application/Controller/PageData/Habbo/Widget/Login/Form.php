<?php

/**
 * Login widget
 *
 * @author Kryptos
 */

class Login_Form extends Controller implements iWidget
{
    public function __construct()
    {
        parent::__construct();
        
        $this->Initialize();
    }

    public function Initialize()
    {
        $this->load->Controller_User();

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $this->Submit();
        }
    }
    
    public function Submit()
    {   
        if(!empty($_POST['lusername']) && !empty($_POST['lpassword']))
        {
        	if($this->cUser->mUser->validInfo($_POST['lusername']))
            {
            	$isBanned = $this->cUser->mUser->isBanned($_SERVER['REMOTE_ADDR'], $_POST['lusername']);
                	
            	if($isBanned == false)
            	{
                	$this->cUser->setSession($_POST['lusername']);
                    $this->cUser->updateInfo($this->cUser->getUsername(), 'last_online', time());

                	$this->vView->redirect('me');
                }
                    
                return $this->Render('You have been banned for: ' . $isBanned['reason']);
            }

            return $this->Render('Email/Username and password do not match');
        }
            
        return $this->Render('Please fill in all fields');
    
    }

    public function Render($html = null)
    {
        return $this->vView->setError('login', '<div id="loginerrorfieldwrapper"><div id="loginerrorfield"><div>' . $html . '</div></div></div>');
    }

}
?>