<?php
	
	/*
	 * Create-drupal-project script
	 * This is a fork from the create-project.php script from Vinicius Krolow gist (https://gist.github.com/krolow/3757622). 
	 * This script was created to enable a easy way to create Drupal projects from the command line, using Drush and some defaut variables
	 * 
	 * Arguments 
	 * $argv[1]	Project Name. Also will be used in the browser as the project URL
	 * $argv[2] Folder path. Folder where thr project will be created and last version of Drupal will be downloaded
	 *
	 * The new site will be created with these administrator credentials: 	
	 *	- Username: admin
	 *  - Password: admin 
	 *  - Administrator email: admin@example.com 
	 *
	 * Database settings: Site will be created with these database settings
	 *	- database name: same as the project name ($argv[1])
	 *	- database host: localhost. These script considers that you have mysql server properly configured in you local machine
	 *  - database user and password: These script considers that you need to configure the varibles $databaseUsername and $databasePassword (line 27 and 28)
	 *
	 * Drupal Version
	 *  - Drupal Version for executing download (@see http://drupal.org/download for the last version available)
	 * Fell free to modify or change this script.
	 * 
	 */

	GLOBAL $databaseUsername;
	GLOBAL $databasePassword;
	GLOBAL $drupalVersion;

	$databaseUsername = 'root';
	$databasePassword = 'root';
	$drupalVersion = 'drupal-7.22';

	//Install last version of drupal in folder passed by $argv[2] (folder instalation) param

	exec("drush dl {$drupalVersion}");
	exec("mv {$drupalVersion} {$argv[2]}");
	exec("cd {$argv[2]};drush si -y --db-url=mysql://{$databaseUsername}:{$databasePassword}@127.0.0.1/{$argv[1]} --account-pass=admin --locale=en_us --site-name=\"$argv[1]\"");
	
	$template = "<VirtualHost *:80>\n";
	$template .= "ServerName {$argv[1]}\n";
	$template .= "DocumentRoot {$argv[2]}\n";
	$template .= "<Directory {$argv[2]}>\n";
	$template .= "	Options Indexes FollowSymLinks MultiViews\n";
	$template .= "	AllowOverride All\n";
	$template .= "	Order allow,deny\n";
	$template .= "	allow from all\n";
	$template .= "</Directory>\n";
    $template .= "ErrorLog /var/log/apache2/{$argv[1]}_error.log\n";
	$template .= "   LogLevel warn\n";
	$template .= "    CustomLog /var/log/apache2/{$argv[1]}_access.log combined\n";
	$template .= "</VirtualHost>\n";
	
	//Echo template in you bash screen
	echo $template;
 
	$file = fopen("/etc/apache2/sites-available/{$argv[1]}", 'x');
	fwrite($file, $template);
	fclose($file);
 
	exec("ln -s /etc/apache2/sites-available/{$argv[1]} /etc/apache2/sites-enabled/{$argv[1]}");
	
	$file = fopen("/etc/hosts", 'a+');
	fwrite($file, "127.0.0.1 {$argv[1]}\n");
	fclose($file);
	
	exec('/etc/init.d/apache2 restart');

	//Change the forlder permission to enable Drupal install script to create necessary files
	exec("chmod -R 777 {$argv[2]}");

	echo 'Created with success the config for: ', $argv[1]; 
	echo "\nPlease access in your browser http://{$argv[1]}. Your local environment is ready to use.\n"; 
?>
