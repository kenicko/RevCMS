<?php

/**
 * Index of Dashboard
 *
 * @author Kryptos
 */
class Controller_PageData_Habbo_Dashboard_Login extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->Controller_User()->access(false, true, 'Dashboard/Main', true);

        $this->Login($_POST['lusername']);
    }       

    private function Login($user)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if($this->vView->setData())
            {
                if($this->cUser->mUser->isNameTaken($user))
                {
                    if($this->cUser->mUser->validInfo($user))
                    {
                        if($this->load->Controller_ACL()->hasControlCheck($this->cUser->mUser->getInfo($user, 'rank'), 'moderator'))
                        {
                            $this->cUser->setSession($_POST['lusername']);
                            $this->cUser->updateInfo($this->cUser->getUsername(), 'last_online', time());
                            
                            $this->vView->redirect('Dashboard/Main');
                        }
                    }

                    $this->vView->setError('login', "Details do not match");
                    return;
                }
                    
                $this->vView->setError('login', "Username does not exist");              
                return;
            }

            $this->vView->setError('login', "Please fill in all fields");
            return;
        }
    }
    
}

?>
