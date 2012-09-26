<?php
# Credits to leenster #
function get_between($input, $start, $end) 
{ 
  $substr = substr($input, strlen($start)+strpos($input, $start), (strlen($input) - strpos($input, $end))*(-1)); 
  return $substr; 
} 

$content = file_get_contents('http://habbo.com/me'); 
//$webbuild = get_between($content, "http://images.habbo.com/habboweb/", "/web-gallery"); 
die($content);
$Rev = getIntance();

$Rev->load->Rev_Configure()->config->site->web_build = $webbuild;

?>