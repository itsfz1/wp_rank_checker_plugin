<?php
/**
 * Plugin Name:       Rank Checker Light
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       It checks your specified keyword ranking in google and mails you the details once in a day.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Fahim Zada (RedApple)
 * Author URI:        https://www.facebook.com/faheem.zada.9
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       rank-checker-light-plugin
 */

//Prevent direct plugin access, Security
if(!defined('WPINC')) {
die;
}
//Display content of a plugin
function rcl_settings_page(){
if(!is_admin()){
echo '<h3>You do not have sufficient permissions to access this page.</h3>';
}
?>
<h1><?= esc_html(get_admin_page_title());?></h1>
<form action="options.php" method="post">
<?php
settings_fields('rcl-fields');
do_settings_sections('rcl-fields');
submit_button();
?>
</form>
<?php
rcl_includes_files();
}
function rcl_add_menu () {
add_menu_page( 'Rank Checker Light', 'RC Light[Load..]', 'manage_options', 'rc-light', 'rcl_settings_page', '
dashicons-chart-bar', 30 ); 
}

add_action( 'admin_menu', 'rcl_add_menu' );

function rcl_settings_fields () {

register_setting( 'rcl-fields', 'rcl-first');
register_setting( 'rcl-fields', 'rcl-second');
add_settings_section( 'rcl-sec1', '', 'rcl_settings_section_cb', 'rcl-fields' );
add_settings_field('rcl-field-1', 'Keyword: ', 'rcl_settings_field1_cb', 'rcl-fields', 'rcl-sec1');
add_settings_field('rcl-field-2', 'Email: ', 'rcl_settings_field2_cb', 'rcl-fields', 'rcl-sec1');
}

function rcl_settings_section_cb () {
echo '<h1>Enter your keyword and mail to receive updates!</h1>';
}

function rcl_settings_field1_cb (){

$setting = get_option('rcl-first');
?>
<input type="text" name="rcl-first" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
<?php

}
function rcl_settings_field2_cb () {
$setting = get_option('rcl-second');
?>
<input type="text" name="rcl-second" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
<?php

}
add_action( 'admin_init','rcl_settings_fields' );

function rcl_includes_files(){
require 'includes/scraper.php';
}

// create a scheduled event (if it does not exist already)
function cronstarter_activation() {
if( !wp_next_scheduled( 'mycronjob' ) ) {  
wp_schedule_event( time(), 'daily', 'mycronjob' );  
}
}
// and make sure it's called whenever WordPress loads
add_action('wp', 'cronstarter_activation');
// unschedule event upon plugin deactivation
function cronstarter_deactivate() {	
// find out when the last event was scheduled
$timestamp = wp_next_scheduled ('mycronjob');
// unschedule previous event if any
wp_unschedule_event ($timestamp, 'mycronjob');
} 
register_deactivation_hook (__FILE__, 'cronstarter_deactivate');
//function to be run
add_action ('mycronjob', 'rcl_settings_page'); 