<?php         
/*
Plugin Name: WTG Tasks Manager Beta
Version: 0.0.1
Plugin URI: http://www.webtechglobal.co.uk/
Description: WordPress Tasks Manager by WebTechGlobal
Author: WebTechGlobal
Author URI: http://www.webtechglobal.co.uk/
Last Updated: November 2014
Text Domain: wtgtasksmanager
Domain Path: /languages

Wordpress Plugin WTG Tasks Manager Pro License (does not apply to customised copies or premium plugins created using the wtgtasksmanager)

GPL v3 

This program is free software downloaded from Wordpress.org: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. This means
it can be provided for the sole purpose of being developed further
and we do not promise it is ready for any one persons specific needs.
See the GNU General Public License for more details.

See <http://www.gnu.org/licenses/>.

This license does not apply to the paid edition which comes with premium
services not just software. License and agreement is seperate.
*/           
  
// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'Direct script access is not allowed!' );

// exit early if WTG Tasks Manager doesn't have to be loaded
if ( ( 'wp-login.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) ) // Login screen
    || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST )
    || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
    return;
}
              
// package variables
$c2p_currentversion = '0.0.1';# to be removed, version is now in the WTGTASKSMANAGER() class 
$c2p_debug_mode = false;# to be phased out, going to use environment variables (both WP and php.ini instead)

// go into dev mode if on test installation (if directory contains the string you will see errors and other fun stuff for geeks)               
if( strstr( ABSPATH, 'OFFprojecttasksmanager' ) ){
    $c2p_debug_mode = true;     
}               

// avoid error output here and there for the sake of performance...              
if ( ( 'wp-login.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) )
        || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST )
        || ( defined( 'DOING_CRON' ) && DOING_CRON )
        || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
    $c2p_debug_mode = false;
}                               

// define constants, feel free to add some of your own...                              
if(!defined( "WTG_WTGTASKSMANAGER_NAME") ){define( "WTG_WTGTASKSMANAGER_NAME", 'WTG Tasks Manager Beta' );} 
if(!defined( "WTG_WTGTASKSMANAGER__FILE__") ){define( "WTG_WTGTASKSMANAGER__FILE__", __FILE__);}
if(!defined( "WTG_WTGTASKSMANAGER_BASENAME") ){define( "WTG_WTGTASKSMANAGER_BASENAME",plugin_basename( WTG_WTGTASKSMANAGER__FILE__ ) );}
if(!defined( "WTG_WTGTASKSMANAGER_ABSPATH") ){define( "WTG_WTGTASKSMANAGER_ABSPATH", plugin_dir_path( __FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/  
if(!defined( "WTG_WTGTASKSMANAGER_PHPVERSIONMINIMUM") ){define( "WTG_WTGTASKSMANAGER_PHPVERSIONMINIMUM", '5.3.0' );}// The minimum php version that will allow the plugin to work                                
if(!defined( "WTG_WTGTASKSMANAGER_IMAGES_URL") ){define( "WTG_WTGTASKSMANAGER_IMAGES_URL",plugins_url( 'images/' , __FILE__ ) );}
if(!defined( "WTG_WTGTASKSMANAGER_FREE") ){define( "WTG_WTGTASKSMANAGER_FREE", 'paid' );} 
        
// require main class...
require_once( WTG_WTGTASKSMANAGER_ABSPATH . 'classes/class-wtgtasksmanager.php' );

// call the Daddy (parent alright the parent lol) methods here or remove some lines as a quick configuration approach...
$WTGTASKSMANAGER = new WTGTASKSMANAGER();
$WTGTASKSMANAGER->custom_post_types();

// localization because we all love speaking a little chinese or russian or Klingon!
// Hmm! has anyone ever translated a WP plugin in Klingon?
function wtgtasksmanager_textdomain() {
    load_plugin_textdomain( 'wtgtasksmanager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action( 'plugins_loaded', 'wtgtasksmanager_textdomain' );                                                                                                      
?>