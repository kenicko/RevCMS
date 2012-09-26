<?php

function getArticle($article)
{
	$Rev = getInstance();
    $Model = $Rev->load->Model();
    
    $Model->driver->query("SELECT * FROM {$Model->emu->news['tbl']} WHERE {$Model->emu->news['id']} = ? LIMIT 1", array('s', $article));

    if($Model->driver->num_rows() == 1)
    {
        $result = $Model->driver->get();
    }
    else
    {
        $result[0] = 'Undefined.'; 
    }
        
    return $result[0];
}

function getAllArticles($max)
{
    $Rev = getInstance();
    $Model = $Rev->load->Model();

    $Model->driver->query("SELECT * FROM {$Model->emu->news['tbl']}");
        
    if($Model->driver->num_rows() >= 1)
    {
        $Model->driver->query("SELECT {$Model->emu->news['id']}, {$Model->emu->news['title']} FROM {$Model->emu->news['tbl']} ORDER BY {$Model->emu->news['id']} DESC LIMIT 0,{$max}");

        foreach($Model->driver->get() as $k)
        {
            $result .= '<br><a id="' . $k[$Model->emu->news['id']] . '" class="color-default" href="#' . $k[$Model->emu->news['id']] . '" onclick="handleArticle(this); return false;"><strong>' . ((substr($k[$Model->emu->news['title']], 0, 30) == $k[$Model->emu->news['title']]) ? $k[$Model->emu->news['title']] : substr($k[$Model->emu->news['title']], 0, 30) . ' ... ') . ' &raquo;</strong></a><br><br><hr>';
        }
            
            $result = substr($result, 0, (strlen($result) - strlen('<br /><br />')));
        }
        else
        {
            $result = '<br><i>No news articles.</i>';
        }
     
        return $result . '<br><br><hr>';
    }

?>