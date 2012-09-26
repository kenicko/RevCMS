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
        
class News_SlideBox extends Controller implements iWidget
{
    
    public function __construct()
    {
        parent::__construct();

        $this->Initialize(5);

    }

    public function Initialize($limit = null)
    {
        $getNews = $this->load->Controller_Article()->mArticle->getNews($limit);
        
        if($getNews != null)
        {
            foreach($getNews as $key => $value)
            {
                 foreach($value as $k => $v)
                 {
                    foreach($this->mModel->emu->news as $y => $e)
                    {
                        if($e == $k)
                        {
                            $this->vView->driver->assign('news->' . $y, $v, true);
                        }
                    }
                 }

                 $this->vView->driver->assign('widget->News', $this->vView->driver->filterParams($this->vView->driver->getFile("Widgets/News/SlideBox/Item")));
            }
        }
    }

    public function Submit()
    {

    }

    public function Render()
    {

    }
    
}

?>
