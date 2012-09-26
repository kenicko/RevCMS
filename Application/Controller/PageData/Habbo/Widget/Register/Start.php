<?php

/**
 * Logout user
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Register_Start extends Controller implements iWidget
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
        if(!empty($_POST['rmonth']) && !empty($_POST['rday']) && !empty($_POST['ryear']))
        {
            $_SESSION['reg']['dob'] = $_POST['rmonth'] . '-' . $_POST['day'] . '-' . $_POST['year'];
            $_SESSION['reg']['gender'] = $_POST['rgender'];
            $_SESSION['reg']['1'] = true;

            $this->vView->redirect('quickregister/user');
        }

        return $this->Render('Please supply a valid birthdate');
    }

    public function Render($html = null)
    {
        return $this->vView->setError('register->1', '<div id="error-messages-container" class="cbb"><div class="rounded" style="background-color: #cb2121;"><div id="error-title" class="error">' . $html . ' <br /></div></div></div>');
    }
    
}

?>
