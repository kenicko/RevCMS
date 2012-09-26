<?php

/**
 * Handle avatars
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Identity_Email extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
       
        $this->load->Controller_User()->access(true, false, 'index');

        $this->UpdateEmail();

    }

    private function UpdateEmail()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changeEmail']))
        {   
            if($this->load->Library_Validate()->validEmail($_POST['email']))
            {
                if(!$this->cUser->mUser->isEmailTaken($_POST['email']))
                {
                    if($this->cUser->mUser->validInfo($this->cUser->getEmail()))
                    {
                    	if(!$this->cUser->mUser->isEmailTaken($_POST['email']))
                        {
    	                    $this->cUser->updateInfo($this->cUser->getEmail(), 'email', $_POST['email']);
    	                    $this->vView->redirect('me');
    	                }
    	                
    	                $this->vView->setError('email', '<div class="error-messages-holder"><h3>There was a problem...</h3><ul><li><p class="error-message">The email you entered is taken</p></li></ul></div>');
                    return;

                    }

                    $this->vView->setError('email', '<div class="error-messages-holder"><h3>There was a problem...</h3><ul><li><p class="error-message">You entered an incorrect password</p></li></ul></div>');
                    return;
                }

                 $this->vView->setError('email', '<div class="error-messages-holder"><h3>There was a problem...</h3><ul><li><p class="error-message">The email is taken.</p></li></ul></div>');
                return;
            }

            $this->vView->setError('email', '<div class="error-messages-holder"><h3>There was a problem...</h3><ul><li><p class="error-message">You entered an invalid email.</p></li></ul></div>');
            return;
        }
    }
    
}

?>
