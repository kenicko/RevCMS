<?php

/**
 * Description of Me
 *
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Community_Tags extends Controller implements iWidget
{
    
    public function __construct()
    {
        parent::__construct();

        $this->Initialize();
    }

    public function Initialize()
    {
        $this->load->Controller_User();

        $this->Submit();

        $this->GetTags();
    }

    public function Submit()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
        {
            return $this->CreateTag();
        }

        if(isset($_GET['deleteTag']))
        {
            return $this->DeleteTag();
        }
    }

    public function Render()
    {
        $this->vView->driver->assign('widget->tags', $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/Community/Tags/Item")));
    }

    #############################
    #                           #
    #           Tags            #
    #                           #
    #############################

    public function GetTags()
    {
        $getTags = $this->load->Model_Tag()->getTags($this->cUser->getID());

        if($getTags != null)
        {
            foreach($getTags as $key => $value)
            {
                $this->vView->driver->assign('tag', '<li><a href="#" class="tag" style="font-size:10px">' . $value['tag'] . '</a><a href="{$site->url}community&deleteTag=' . $value['tag'] . '" title="delete tag"><img src="{$site->url}Public/Themes/{$skin->name}/webbuild/habboweb/web-gallery/v2/images/red-button.png"></img></a></li>');
            }

            $this->Render();
        }
    }

    public function CreateTag()
    {
        if(isset($_POST['newtag']))
        {
            return $this->load->Model_Tag()->addTag($this->cUser->getID(), $_POST['newtag']);
        }
    }

    public function DeleteTag()
    {
        $this->load->Model_Tag()->deleteTag($this->cUser->getID(), $_GET['deleteTag']);
        $this->vView->redirect('community');
    }
    
}

?>
