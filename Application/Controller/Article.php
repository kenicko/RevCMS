<?php

/**
 * Handle user information
 *
 * @author Kryptos
 */

/**
 * Deny direct file access 
 */
    if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); } 
  
class Controller_Article extends Controller 
{
    
    public function __construct()
    {  
        parent::__construct();
        
        $this->load->Model_Article();
      
    }
    
   /**
    * Get a single news article
    */
    public function getArticle($id)
    {
        if($id != null)
        {
            $getArticle = $this->mArticle->getArticle($id);

            if($getArticle != null)
            {
                foreach($getArticle[0] as $key => $value)
                {
                    foreach($this->mModel->emu->news as $k => $v)
                    {
                        if($key == $v)
                        {
                            if($k == 'published')
                            {
                                $value = date('m/d/y', $value);
                            }

                            $this->vView->driver->assign('news->' . $k, $value, true);
                        }
                    }
                }

                return;
            }
        }

        $this->vView->redirect('me');
    }
    
   /**
    * Delete an article
    */
    public function deleteArticle($id)
    {
        if($id != null)
        {
        	$this->mArticle->deleteArticle($id);
        }

        $this->vView->redirect('me');
    }

   /**
    * Get a news article list
    */
    public function getNewsList($id)
    {
        if($id != null)
        {
            $getList = $this->mArticle->getList($id);

            if($getList != null)
            {
                foreach($getList as $nkey => $nvalue)
                {
                    $this->vView->driver->assign('title', $nvalue[$this->mModel->emu->news['title']], true);
                    $this->vView->driver->assign('id', $nvalue[$this->mModel->emu->news['id']], true);

                }

                $this->vView->driver->assign('widget->news->list', $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/News/List")));
            }
        }
    }

}
?>