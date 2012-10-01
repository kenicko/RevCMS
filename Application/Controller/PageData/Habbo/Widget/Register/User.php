t<?php

/**
 * Logout user
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Register_User extends Controller implements iWidget
{

    private $error = '';
    
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
        if($this->validValues($_POST['remail'], $_POST['rusername']) != false & $this->valuesMatch($_POST['remail'], $_POST['rre-email']) & $this->validPassword($_POST['rpassword']))
        {
            if($this->cUser->mUser->isNameTaken($_POST['rusername']))
            {
                return $this->Render('Username is taken');
            }

            if($this->cUser->mUser->isEmailTaken($_POST['rusername']))
            {
                return $this->Render('Email is taken');
            }

            if($this->cUser->mUser->isRegistered($_SERVER['REMOTE_ADDR']))
            {
                return $this->Render('You are already registered.');
            }

            if($this->cUser->mUser->isBanned($_SERVER['REMOTE_ADDR']))
            {
                return $this->Render('You are IP banned');
            }

            $this->cUser->mUser->insert($_POST['rusername'], $this->load->Model()->emu->register['hash'], $_POST['remail'], $this->load->Rev_Configure()->config->user->motto, $this->load->Rev_Configure()->config->user->credits, $this->load->Rev_Configure()->config->user->pixels, $this->load->Rev_Configure()->config->user->rank, $this->load->Rev_Configure()->config->user->figure, $this->load->Rev_Configure()->config->user->gender); 

            $this->cUser->setSession($_POST['rusername']);

            $this->cUser->updateInfo($_POST['rusername'], 'last_online', time());
            $this->cUser->updateTicket();

            $this->vView->redirect('me');

        }

        $this->Render($this->error);
        return;
    }

    public function Render($html = null)
    {
        $this->vView->setError('register->2', '<div id="error-messages-container" class="cbb"><div class="rounded" style="background-color: #cb2121;"><div id="error-title" class="error">' . $html . '</div></div></div>');
    }



    #############################
    #                           #
    #        Validators         #
    #                           #
    #############################

    private function validValues($email, $name)
    {
        if($this->load->Library_Validate()->validEmail($email) && $this->load->Library_Validate()->validName($name))
        {
            return true;
        }

        $this->error .= 'Email or Username are invalid<br>';
    }

    private function valuesMatch($val1, $val2)
    {
        if($val1 === $val2)
        {
            return true;
        }

        $this->error .= 'Emails do not match<br>';
    }

    private function validPassword($pass)
    {
        if(strlen($pass) > 6)
        {
            return true;
        }

        $this->error .= 'Password is too short<br>';
    }
    
}

?>
