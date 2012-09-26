<?php

/**
 * Add avatar
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Identity_addAvatar extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
    
        $this->load->Controller_User()->access(true, false, 'index');

        $this->CreateCharacter();
    }

    private function CreateCharacter()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createChar']))
        {
            if($_SESSION['add']['added'] == true)
            {
                if($this->load->Library_Validate()->validName($_POST['avatarName']))
                {
                    if(!$this->cUser->mUser->isNameTaken($_POST['avatarName']))
                    {
                    	if($this->cUser->mUser->isBanned($_SERVER['REMOTE_ADDR'], $this->cUser->getUsername()) == false)
                    	{
                        	   $this->load->Controller_Avatar()->addAvatar($_POST['avatarName'], $_SESSION['add']['figure'], $_SESSION['add']['gender']);
                               $this->vView->redirect('identity/avatars');
                        }
                        
                        $this->vView->redirect('logout');
                    } 
                }
            }

            return;
        }
    }
    
    public function CheckNameOnly($username)
    {
        $this->vView->driver->assign('user', $username);

        if($this->cUser->mUser->isNameTaken($username)) 
        {
            $this->vView->setError('<div class="error-messages-holder"><h3>Please fix the following problems and resubmit the form.</h3><ul><li><p class="error-message">The name {$user} is already in use</p></li></ul></div>');
            return $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Identity/nameTaken"));
        }

        if(!$this->load->Library_Validate()->validName($username))
        {
            $this->vView->setError('<div class="error-messages-holder"><h3>Please fix the following problems and resubmit the form.</h3><ul><li><p class="error-message">That username is not valid</p></li></ul></div>');
            return $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Identity/nameTaken"));
        }



        return $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Identity/nameAvalaible"));
    }

    public function CheckFigureOnly($figure, $gender = 'm')
    {
        $this->vView->driver->assign('figure', $figure);

        $_SESSION['add']['added'] = true;
        $_SESSION['add']['figure'] = $figure;
        $_SESSION['add']['gender'] = $gender;

        return $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Identity/getFigure"));

    }

    public function refreshFigures() 
    {
        $this->vView->driver->assign('figure->current', $_SESSION['add']['figure']);

        return $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Identity/randomFigures"));
    }
}

?>
