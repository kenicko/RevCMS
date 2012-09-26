<?php

function getFeeds($number = 10, $sess = 'Guest')
{
    return "<div id='1' class='feed'><strong> $sess </strong> <span class='gray'>said the following</span> <i>{Message}</i></div><hr />";
}

function getPopupFeeds($id, $sess = 'Guest')
{
    $result = '<strong>' . $sess . '</strong> <span class="gray">said the following message on the Hotel:</span><br /><br />"<i>{Message}</i>"';
        
    return $result;
}

?>
