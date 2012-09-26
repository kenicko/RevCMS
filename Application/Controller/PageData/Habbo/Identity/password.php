<?php

/**
 * Handle avatars
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Identity_Password extends Controller
{ 
    
    public function __construct()
    {
        parent::__construct();
       
        $this->load->Controller_User()->access(true, false, 'index');

        $this->ChangePassword();

    }

    private function ChangePassword()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changePass']))
        {
            if(!empty($_POST['newRetypedPassword']) && !empty($_POST['npassword']) && !empty($_POST['lpassword']))
            {
                if($_POST['newRetypedPassword'] == $_POST['npassword'])
                {
                    if($this->cUser->mUser->validInfo($this->cUser->getEmail()))
                    {
                        $this->cUser->updateInfo($this->cUser->getEmail(), 'password', $this->mModel->emu->newpass['hash']);

                        $this->vView->redirect('me');
                    }

                    $this->vView->setError('password', '<div class="error-messages-holder"><h3>Please fix the following problems…</h3><ul><li><p class="error-message">Current password does not match</p></li></ul></div>');
                    return;
                }

                $this->vView->setError('password', '<div class="error-messages-holder"><h3>Please fix the following problems…</h3><ul><li><p class="error-message">The new password and its retype do not match</p></li></ul></div>');
                return;
            }

            $this->vView->setError('password', '<div class="error-messages-holder"><h3>Please fix the following problems…</h3><ul><li><p class="error-message">Please fill in all fields</p></li></ul></div>');
            return;
        }
    }
    
}

?>
