<?php

/**
 * PHP File for Phoenix database
 * @author Meth0d and Sojobo / Aaron
 */

/**
 * Deny direct file access
 */
    if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); } 
    
$DB['data']['login']['hash'] = md5($_POST['lpassword']);
$DB['data']['register']['hash'] = md5($_POST['rpassword']);
$DB['data']['newpass']['hash'] 	= md5($_POST['npassword']); 

    
$DB['data']['users']['tbl'] 		= 'users';
$DB['data']['users']['id'] 			= 'id';
$DB['data']['users']['username'] 	= 'username'; 
$DB['data']['users']['real_name'] 	= 'real_name';
$DB['data']['users']['email'] 		= 'mail';
$DB['data']['users']['password'] 	= 'password';
$DB['data']['users']['motto'] 		= 'motto';
$DB['data']['users']['rank'] 		= 'rank';
$DB['data']['users']['sso'] 		= 'auth_ticket';
$DB['data']['users']['credits'] 	= 'credits';
$DB['data']['users']['figure'] 		= 'look';
$DB['data']['users']['pixels'] 		= 'activity_points';
$DB['data']['users']['gender'] 		= 'gender';
$DB['data']['users']['ip_reg'] 		= 'ip_reg'; 
$DB['data']['users']['ip_last'] 	= 'ip_last';
$DB['data']['users']['online'] 		= 'online';
$DB['data']['users']['last_online'] = 'last_online';
$DB['data']['users']['respects']		= 'respect';
$DB['data']['users']['account_created'] = 'account_created';

$DB['data']['query']['get_online'] 		= "SELECT id FROM users WHERE online = '1'";
$DB['data']['query']['update_sso'] 		= 'UPDATE users SET auth_ticket = ? WHERE id = ?';
$DB['data']['query']['get_sso']			= 'SELECT auth_ticket FROM users WHERE id = ? LIMIT 1';
$DB['data']['query']['insert_sso']      = 'UPDATE users SET id  = ?, auth_ticket = ? and ip_last = ?';
$DB['data']['query']['isOnline']        = "SELECT * FROM users WHERE online = '1' AND id = ? LIMIT 1";
$DB['data']['query']['insert_filter'] 	= "INSERT INTO wordfilter(word, replacement) VALUES(?, '****')";

$DB['data']['news']['tbl'] 			= 'cms_news';
$DB['data']['news']['id'] 			= 'id';
$DB['data']['news']['title'] 		= 'title';
$DB['data']['news']['shortstory'] 	= 'shortstory';
$DB['data']['news']['longstory'] 	= 'longstory';
$DB['data']['news']['published'] 	= 'published';
$DB['data']['news']['image'] 		= 'image';
$DB['data']['news']['campaign'] 	= 'campaign';
$DB['data']['news']['campaign'] 	= 'campaignimg';
$DB['data']['news']['author'] 		= 'author';

$DB['data']['news']['getQuery']		= "SELECT id, title, shortstory, longstory, published, image FROM cms_news ORDER BY id DESC LIMIT ";

$DB['data']['ranks']['tbl']			= 'ranks';
$DB['data']['ranks']['id']			= 'id';
$DB['data']['ranks']['name']		= 'name';;

$DB['data']['bans']['tbl']			= 'bans';
$DB['data']['bans']['id']			= 'id';
$DB['data']['bans']['bantype']		= 'bantype';
$DB['data']['bans']['value']			= 'value';
$DB['data']['bans']['reason']			= 'reason';
$DB['data']['bans']['expire']			= 'expire';
$DB['data']['bans']['added_by']			= 'added_by';
$DB['data']['bans']['added_date']		= 'added_date';


return (object)$DB['data'];

?>