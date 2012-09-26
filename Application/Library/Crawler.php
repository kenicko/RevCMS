<?php

/**
 * Crawl pages
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Library_Crawler
{
    protected $content;

    public function __construct($url) 
    {
        parent::__construct();
        
        $this->content = $this->getContent($url);
    }

    public function getContent($url) 
    {
        return file_get_contents($url);
    }

    public function get($type, $regex = null) 
    {
        if(method_exists($this, $type))
        {
            return $this->{$type}();
        }
        
        $this->custom($regex);
    }
    
    public function custom($regex)
    {
        if(isset($this->content))
        {
            preg_match_all($regex, $this->content, $custom);
            
            if(isset($custom[1]))
            {
                return $custom[1];
            }
            
            return "Nothing 'custom' found, with regex: {$regex}";
        }
    }

    public function images() 
    {
        if(isset($this->content))
        {  
            preg_match_all('/<img([^>]+)\/>/i', $this->content, $images);
            
            if(isset($images[1]))
            {
                return $image[1];
            }
            
            return 'No images found';
        }
    }

    public function links() 
    {
        if(isset($this->content))
        {
            preg_match_all('/<a([^>]+)\>(.*?)\<\/a\>/i', $this->content, $links);
            
            if(isset($links[1]))
            {
                return $links[1];
            }
            
            return 'No links found';
        }
    }
}

?>