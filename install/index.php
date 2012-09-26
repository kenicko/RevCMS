<?php

define('IN_INDEX', 1);

	error_reporting(E_ALL & ~ ( E_STRICT | E_NOTICE ));
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);


require_once 'installer_func.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
{
	Install($_POST);
}

if(file_exists('../Config/Config.php'))
{
	//die('Please delete the /install/ folder');
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="utf-8" />
	<title>RevCMS - Installation - Introduction</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="js/RevOwl.js"></script>

	<style type="text/css">

		#content {
			margin-top: 50px;
		}

		form {
			width: 700px;
			margin: 0 auto;
		}

		input, select {
			width: 100%;
		}

		#field .middlecol {

		}

		input, select {
			width: 100%;
		}

		#field {
			display: 			table;
			width: 				100%;
			margin-bottom: 		10px;
		}

		#field .rightcol.done {
			text-align: right;
			float: right;
			display: block;
			margin-top: 30px;
		}
	</style>
</head>
<body>

<div id="content" class="clearfix">
	<div id="wrapper">
		<div class="center page">
			<h1>RevCMS Installation</h1>
			<p>You are about to install RevCMS. Fill in the fields below and you are ready.
				We hope you enjoy your time and getting a good experience with RevCMS.</p>

			<form action="#" id="install" method="POST">
				<header>
					<h2>Site Settings</h2>
				</header>

				<!--  Site name -->
				<div id="field">
					<div class="leftcol">
						<label for="site->name">Site name</label>
					</div>
					<div class="middlecol">
						<input name="site->name" id="field-site_name" type="text" placeholder="Habbo">
					</div>
					<div class="rightcol">
						<span class="description">Name of your site</span>
					</div>
				</div>

				<!--  Site title -->
				<div id="field">
					<div class="leftcol">
						<label for="site->title">Site title</label>
					</div>
					<div class="middlecol">
						<input name="site->title" id="field-site_name" type="text" placeholder="Habbo Hotel:">
					</div>
					<div class="rightcol">
						<span class="description">Title of your site</span>
					</div>
				</div>

				<!-- Skin -->
				<div id="field">
					<div class="leftcol">
						<label for="skin->name">Skin</label>
					</div>
					<div class="middlecol">
						<select name="skin->name" id="field-site_skin">
							<?php
							$results = scandir('../Public/Themes/');

					        foreach($results as $result) 
					        {
					            if ($result === '.' or $result === '..' or $result === '.DS_Store') continue;
					
					            if (is_dir('../Public/Themes/' . $result)) {
					                echo "<option value={$result}>{$result}</option>";
					            }
            				}
						?>
						</select>
					</div>
					<div class="rightcol">
						<span class="description">Skin for your site</span>
					</div>
				</div>

				<!-- Site language -->
				<div id="field">
					<div class="leftcol">
						<label for="language->name">Language</label>
					</div>
					<div class="middlecol">
						<select name="language->name" id="field-site_lang">
							<option value="English">English</option>
							<option value="Spanish">Espanol</option>
							<option value="Danish">Dansk</option>
							<option value="Dutch">Deutsch</option>
							<option value="Portuguese">Portuguese</option>
						</select>
					</div>
					<div class="rightcol">
						<span class="description">The language of your site</span>
					</div>
				</div>

				<header>
					<h2>MySQL Information</h2>
				</header>

				<div id="field">
					<div class="leftcol">
						<label for="DB->emulator">Emulator</label>
					</div>
					<div class="middlecol">
						<select name="DB->emulator" id="field-site_lang">
						<?php
							$results = scandir('../Application/Model/Database/');

					        foreach($results as $result) 
					        {
					            if ($result === '.' or $result === '..' or $result === '.DS_Store') continue;
					
					            if(!is_dir('../Application/Model/Database/' . $result)) {
					                echo '<option value=' . substr($result, 0, -4) . '>' . substr($result, 0, -4). '</option>';
					            }
            				}
						?>
						</select>
					</div>
					<div class="rightcol">
						<span class="description">The emulator you are using</span>
					</div>
				</div>

				<!-- MySQL Hostname -->
				<div id="field">
					<div class="leftcol">
						<label for="DB->mysql->host">Hostname</label>
					</div>
					<div class="middlecol">
						<input name="DB->mysql->host" id="field-mysql_hostname" type="text" placeholder="127.0.0.1">
					</div>
					<div class="rightcol">
						<span class="description">The hostname of your MySQL (default: 127.0.0.1)</span>
					</div>
				</div>

				<!-- MySQL Username -->
				<div id="field">
					<div class="leftcol">
						<label for="DB->mysql->user">Username</label>
					</div>
					<div class="middlecol">
						<input name="DB->mysql->user" id="field-mysql_username" type="text" placeholder="root">
					</div>
					<div class="rightcol">
						<span class="description">The username of your MySQL user</span>
					</div>
				</div>

				<!-- MySQL Password -->
				<div id="field">
					<div class="leftcol">
						<label for="DB->mysql->pass">Password</label>
					</div>
					<div class="middlecol">
						<input name="DB->mysql->pass" id="field-mysql_password" type="password">
					</div>
					<div class="rightcol">
						<span class="description">The password of your MySQL user</span>
					</div>
				</div>

				<!-- MySQL Database -->
				<div id="field">
					<div class="leftcol">
						<label for="DB->mysql->database">Database</label>
					</div>
					<div class="middlecol">
						<input name="DB->mysql->database" id="field-mysql_database" type="text" placeholder="rev_cms">
					</div>
					<div class="rightcol">
						<span class="description">The database to use</span>
					</div>
				</div>

				<header>
					<h2>Server Configuration</h2>
				</header>

				<!-- Server IP -->
				<div id="field">
					<div class="leftcol">
						<label for="site->server_ip">IP Address</label>
					</div>
					<div class="middlecol">
						<input name="site->server_ip" id="field-server_ip" type="text" placeholder="127.0.0.1">
					</div>
					<div class="rightcol">
						<span class="description">The IP address of your server</span>
					</div>
				</div>

				<!-- External Variables -->
				<div id="field">
					<div class="leftcol">
						<label for="site->external_vars">External Variables</label>
					</div>
					<div class="middlecol">
						<input name="site->external_vars" id="field-external_vars" type="text">
					</div>
					<div class="rightcol">
						<span class="description">URL to your external variables (with http(s)://)</span>
					</div>
				</div>

				<!-- External Texts -->
				<div id="field">
					<div class="leftcol">
						<label for="site->external_texts">External Texts</label>
					</div>
					<div class="middlecol">
						<input name="site->external_texts" id="field-external_texts" type="text">
					</div>
					<div class="rightcol">
						<span class="description">URL to your external texts (with http(s)://)</span>
					</div>
				</div>

				<!-- Product Data -->
				<div id="field">
					<div class="leftcol">
						<label for="site->product_data">Product Data</label>
					</div>
					<div class="middlecol">
						<input name="site->product_data" id="field-product_data" type="text">
					</div>
					<div class="rightcol">
						<span class="description">URL to your product data (with http(s)://)</span>
					</div>
				</div>

				<!-- Furni Data -->
				<div id="field">
					<div class="leftcol">
						<label for="site->furni_data">Furni Data</label>
					</div>
					<div class="middlecol">
						<input name="site->furni_data" id="field-product_data" type="text">
					</div>
					<div class="rightcol">
						<span class="description">URL to your furni data (with http(s)://)</span>
					</div>
				</div>

				<header>
						<h2>Default User Information</h2>
					</header>

					<div id="field">
						<div class="leftcol">
							<label for="motto">Motto</label>
						</div>
						<div class="middlecol">
							<input name="user->motto" type="text" value="TopHabbo.COM" id="motto" placeholder="Motto">
						</div>
						<div class="rightcol">
							<span class="description">Default motto</span>
						</div>
					</div>

					<div id="field">
						<div class="leftcol">
							<label for="credits">Credits</label>
						</div>
						<div class="middlecol">
							<input name="user->credits" type="text" value="" id="credits" placeholder="Credits">
						</div>
						<div class="rightcol">
							<span class="description">Default credits</span>
						</div>
					</div>

					<div id="field">
						<div class="leftcol">
							<label for="pixels">Pixels</label>
						</div>
						<div class="middlecol">
							<input name="user->pixels" type="text" value="" id="pixels" placeholder="Pixels">
						</div>
						<div class="rightcol">
							<span class="description">Default pixels</span>
						</div>
					</div>

					<div id="field">
						<div class="leftcol">
							<label for="rank">Rank</label>
						</div>
						<div class="middlecol">
							<input name="user->rank" type="text" value="" id="rank" placeholder="Rank">
						</div>
						<div class="rightcol">
							<span class="description">Default rank</span>
						</div>
					</div>

					<div id="field">
						<div class="leftcol">
							<label for="figure">Figure</label>
						</div>
						<div class="middlecol">
							<input name="user->figure" type="text" value="" id="figure" placeholder="Figure">
						</div>
						<div class="rightcol">
							<span class="description">Default figure</span>
						</div>
					</div>

					<div id="field">
						<div class="leftcol">
							<label for="gender">Gender</label>
						</div>
						<div class="middlecol">
							<input name="user->gender" type="text" value="" id="gender" placeholder="Gender">
						</div>
						<div class="rightcol">
							<span class="description">Default gender</span>
						</div>
					</div>

					<header>
						<h2>Social</h2>
					</header>

					<!-- Facebook -->
					<div id="field">
						<div class="leftcol">
							<label for="social->facebook">Facebook</label>
						</div>
						<div class="middlecol">
							<input name="social->facebook" id="field-facebook" value="TopHabboCOM" type="text" placeholder="127.0.0.1">
						</div>
						<div class="rightcol">
							<span class="description">Your site's Facebook</span>
						</div>
					</div>

					<!-- Twitter -->
					<div id="field">
						<div class="leftcol">
							<label for="social->twitter">Twitter</label>
						</div>
						<div class="middlecol">
							<input name="social->twitter" id="field-twitter" value="TopHabboCOM" type="text" placeholder="127.0.0.1">
						</div>
						<div class="rightcol">
							<span class="description">Your site's Twitter</span>
						</div>
					</div>

					<header>
						<h2>User Registration - Only fill in when using a new database</h2>
					</header>

					<!-- Admin username -->
					<div id="field">
						<div class="leftcol">
							<label for="username">Username</label>
						</div>
						<div class="middlecol">
							<input name="username" id="username" type="text">
						</div>
						<div class="rightcol">
							<span class="description">Your username</span>
						</div>
					</div>

					<!-- Admin email -->
					<div id="field">
						<div class="leftcol">
							<label for="email">Email</label>
						</div>
						<div class="middlecol">
							<input name="email" id="email" type="text">
						</div>
						<div class="rightcol">
							<span class="description">Your email</span>
						</div>
					</div>

					<!-- Admin password -->
					<div id="field">
						<div class="leftcol">
							<label for="password">Password</label>
						</div>
						<div class="middlecol">
							<input name="lpassword" id="password" type="password">
						</div>
						<div class="rightcol">
							<span class="description">Your password</span>
						</div>
					</div>

					<div id="field">
						<div class="rightcol done">
							<input class="green" type="submit" name="submit" id="submit" value="I'm done! Let's go">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="footer">
	<div id="wrapper">
		<div class="seperator"></div>
		<span class="version">RevCMS 3.0</span>
		<span class="copyright">Copyright &copy; 2011 Team Rev - All Rights Reserved.</span>
		<span class="credits">Crafted by Kryptos &amp; Heaplink</span>
	</div>
</div>

<script type="text/javascript">
$(function() {

        $("#submit").click(function() {

            $("#install input[type=text]").each(function() {
                if(this.name !== 'username' && this.name !== 'email')
                {
                	if(!this.value || this.value == '')
                	{
                		$.notification( 
						{
							title: "Oops!",
							content: "It looks like you forgot some fields!",
							border: false,
							timeout: 7000,
							icon: '0'
						});
						var error = true;
						return false;
                	}

                	if (this.value.indexOf('\'') >= 0 && this.value.indexOf('"') >= 0) {
					   $.notification( 
						{
							title: "Oops!",
							content: "You cannot use QUOTES ( ' or '' ) in the input fields",
							border: false,
							timeout: 7000,
							icon: '0'
						});
					   	var error = true;
						return false;
					}

                }
            });
            if(error == true) return false;
        });

    });
</script>

</body>
</html>