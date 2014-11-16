<?php
/** 
 * Default administration settings for WTG Tasks Manager plugin. These settings are installed to the 
 * wp_options table and are used from there by default. 
 * 
 * @package WTG Tasks Manager
 * @author Ryan Bayne   
 * @since 0.0.1
 * @version 1.0.7
 */

// load in Wordpress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

// install main admin settings option record
$c2p_settings = array();                                                                                             
// encoding
$c2p_settings['standardsettings']['encoding']['type'] = 'utf8';
// admin user interface settings start
$c2p_settings['standardsettings']['ui_advancedinfo'] = false;// hide advanced user interface information by default
// other
$c2p_settings['standardsettings']['ecq'] = array();
$c2p_settings['standardsettings']['chmod'] = '0750';
$c2p_settings['standardsettings']['systematicpostupdating'] = 'enabled';
// testing and development
$c2p_settings['standardsettings']['developementinsight'] = 'disabled';
// global switches
$c2p_settings['standardsettings']['textspinrespinning'] = 'enabled';// disabled stops all text spin re-spinning and sticks to the last spin

##########################################################################################
#                                                                                        #
#                           SETTINGS WITH NO UI OPTION                                   #
#              array key should be the method/function the setting is used in            #
##########################################################################################
$c2p_settings['create_localmedia_fromlocalimages']['destinationdirectory'] = 'wp-content/uploads/importedmedia/';
 
##########################################################################################
#                                                                                        #
#                            DATA IMPORT AND MANAGEMENT SETTINGS                         #
#                                                                                        #
##########################################################################################
$c2p_settings['datasettings']['insertlimit'] = 100;

##########################################################################################
#                                                                                        #
#                                    WIDGET SETTINGS                                     #
#                                                                                        #
##########################################################################################
$c2p_settings['widgetsettings']['dashboardwidgetsswitch'] = 'disabled';

##########################################################################################
#                                                                                        #
#                            CUSTOM POST TYPE SETTINGS                                   #
#                                                                                        #
##########################################################################################
$c2p_settings['posttypes']['wtgflags']['status'] = 'disabled';
$c2p_settings['posttypes']['wtgtasks']['status'] = 'enabled';
$c2p_settings['posttypes']['posts']['status'] = 'disabled';

##########################################################################################
#                                                                                        #
#                                    NOTICE SETTINGS                                     #
#                                                                                        #
##########################################################################################
$c2p_settings['noticesettings']['wpcorestyle'] = 'enabled';

##########################################################################################
#                                                                                        #
#                           YOUTUBE RELATED SETTINGS                                     #
#                                                                                        #
##########################################################################################
$c2p_settings['youtubesettings']['defaultcolor'] = '&color1=0x2b405b&color2=0x6b8ab6';
$c2p_settings['youtubesettings']['defaultborder'] = 'enable';
$c2p_settings['youtubesettings']['defaultautoplay'] = 'enable';
$c2p_settings['youtubesettings']['defaultfullscreen'] = 'enable';
$c2p_settings['youtubesettings']['defaultscriptaccess'] = 'always';

##########################################################################################
#                                                                                        #
#                                  LOG SETTINGS                                          #
#                                                                                        #
##########################################################################################
$c2p_settings['logsettings']['uselog'] = 1;
$c2p_settings['logsettings']['loglimit'] = 1000;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['outcome'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['timestamp'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['line'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['function'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['page'] = true; 
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['panelname'] = true;   
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['userid'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['type'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['category'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['action'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['priority'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['comment'] = true;
?>