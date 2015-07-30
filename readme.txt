=== Just Variables ===
Contributors: aprokopenko
Plugin Name: Just Variables for Wordpress
Plugin URI: http://justcoded.com/just-labs/just-wordpress-theme-variables-plugin/
Author: Alexander Prokopenko
Author URI: http://justcoded.com/
Tags: theme, variables, template, text data
Requires at least: 3.0.0
Tested up to: 3.4.1
Donate link: http://justcoded.com/just-labs/just-wordpress-theme-variables-plugin/#donate
License: GNU General Public License v2
Stable tag: trunk

This plugin add custom page with theme text variables (configurable) to use inside the templates.

== Description ==

This plugin allow you to create simple text variables (single/multi-line) to use them in your theme templates after that.
Once you added at least one variabel - the new page Theme Variables will appear under Appearance menu.
You can move all your text data (like copyright text, phone numbers, address etc) to variables.
So if final client want to change this text - he can do this easily from admin without editing the template.

This project is also available on github.com:
https://github.com/aprokopenko/justvariables.
You can post issues, bugs and your suggestion in Issues tracker there.

== Installation ==

1. Download, unzip and upload to your WordPress plugins directory
2. Activate the plugin within you WordPress Administration Backend
3. Go to Settings > Just Variables
4. Add few variables you want to use in your theme templates. After that new Theme Variables page will be created under Appearance.
5. Go to Theme Variables pages and add values for variables.
6. Insert template codes.

== Upgrade Notice ==

* Remove old plugin folder.
* Follow install steps 1-2. All settings will be saved.

== Screenshots ==

1. Plugin settings page where you can add new variables
2. Theme Variables page under Appearance menu

== Changelog ==
* Version 1.1 :
	* Bug fix: emergency fix for WP 3.4.1 (https://github.com/aprokopenko/justvariables/issues/3)
* Version 1.0 :
	* Tested and added language support, added Russian language
* Version 0.1 :
	* First version beta

== Frequently Asked Questions ==
Q: Will my theme continue to work if i disactivate or remove this plugin?
A: If you inserted template function from this plugin to your templates then you probably get error about missing functions. You will need to clean up your template files from function calls.