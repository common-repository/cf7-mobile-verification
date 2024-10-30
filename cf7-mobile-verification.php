<?php
/**
 * @package CF7 Mobile Verification
 */

/*
Plugin Name:  Contact Form 7 Mobile Verification
Plugin URI:   https://wp.imdigital.co/
Description:  Simplify Mobile Verification in Contact Form 7.
Version:      1.0.0
Author:       imdigital
Author URI:   https://profiles.wordpress.org/imdigital
License:      GPLv3
License URI:  http://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  cf7-mobile-verification
Domain Path:  /languages
*/

/* Include the Custom functions file */
require 'functions.php';
require 'inc/admin-settings.php';



function cf7_mobile_verification_action_links( $links ) {

   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=cf7-mobile-verification') ) .'">Settings</a>';

   $links[] = '<a href="http://wp.imdigital.co" target="_blank">More plugins by imDigital</a>';

   return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'cf7_mobile_verification_action_links' );