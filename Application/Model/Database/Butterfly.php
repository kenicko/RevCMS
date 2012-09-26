<?php

/**
 * PHP File for Uber database
 * @author Meth0d
 */

/**
 * Deny direct file access
 */
    if(!defined("IN_INDEX")) { die('Sorry, you cannot access this file :('); } 


    
$DB['data']['login']['hash'] 		= sha1($_POST['lpassword']); 
$DB['data']['register']['hash'] 	= sha1($_POST['rpassword']); 
$DB['data']['newpass']['hash'] 		= sha1($_POST['npassword']); 

$DB['data']['users']['tbl'] 		= 'users';
$DB['data']['users']['id'] 			= 'id';
$DB['data']['users']['username'] 	= 'username'; 
$DB['data']['users']['real_name'] 	= 'real_name'; 
$DB['data']['users']['email'] 		= 'mail';
$DB['data']['users']['password'] 	= 'password';
$DB['data']['users']['motto'] 		= 'motto';
$DB['data']['users']['rank'] 		= 'rank';
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

$DB['data']['query']['get_online'] 		= 'SELECT userid FROM user_online';
$DB['data']['query']['update_sso']     	= 'UPDATE user_tickets SET sessionticket = ? WHERE userid = ?';
$DB['data']['query']['insert_sso']      = 'INSERT INTO user_tickets(userid, sessionticket, ipaddress) VALUES(?, ?, ?)';
$DB['data']['query']['get_sso']        	= 'SELECT sessionticket FROM user_tickets WHERE userid = ? LIMIT 1';
$DB['data']['query']['isOnline']        = 'SELECT * FROM user_online WHERE userid = ? LIMIT 1';
$DB['data']['query']['insert_filter'] 	= 'INSERT INTO room_swearword_filter(word) VALUES(?)';


$DB['data']['sso'] 		= 'sessionticket'; //Field that the SSO is stored in, table doesn't matter

$DB['data']['news']['tbl'] 			= 'webnews';
$DB['data']['news']['id'] 			= 'id';
$DB['data']['news']['title'] 		= 'title';
$DB['data']['news']['shortstory'] 	= 'spoiler';
$DB['data']['news']['longstory'] 	= 'body';
$DB['data']['news']['published'] 	= 'created';
$DB['data']['news']['image'] 		= 'image';
$DB['data']['news']['category'] 	= 'category';

$DB['data']['news']['getQuery']			= "SELECT id, title, spoiler, body, created, image, category FROM webnews ORDER BY id DESC LIMIT ";

$DB['data']['ranks']['tbl']				= 'ranks';
$DB['data']['ranks']['id']				= 'id';
$DB['data']['ranks']['name']			= 'name';

$DB['data']['bans']['tbl']			= 'bans';
$DB['data']['bans']['bantype']		= 'bantype';
$DB['data']['bans']['value']			= 'value';
$DB['data']['bans']['reason']			= 'reason';
$DB['data']['bans']['expire']			= 'expire';
$DB['data']['bans']['added_by']			= 'added_by';
$DB['data']['bans']['added_date']		= 'added_date';


return (object)$DB['data'];

?>