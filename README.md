create-drupal-project
=====================

Create-drupal-project script
This is a fork from the create-project.php script from Vinicius Krolow gist (https://gist.github.com/krolow/3757622). 
This script was created to enable a easy way to create Drupal projects from the command line, using Drush and some defaut variables

Download the script and run it as root user

Example: 
	sudo php create-drupal-project.php drupaltest1 /home/lrcarvalho/Projects/Code/drupaltest1

	Arguments 
	 * $argv[1]: "drupaltest1" 
	 	Project Name. Also will be used in the browser as the project URL
	 * $argv[2]: "/home/lrcarvalho/Projects/Code/drupaltest1". 
	 	Folder path. Folder where thr project will be created and last version of Drupal will be downloaded

Seems a Stable version. Fell free to test it.
Also, fell free to modify or change this script.
