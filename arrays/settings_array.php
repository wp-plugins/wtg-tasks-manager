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
$tasksmanager_settings = array();                                                                                             
// encoding
$tasksmanager_settings['standardsettings']['encoding']['type'] = 'utf8';
// admin user interface settings start
$tasksmanager_settings['standardsettings']['ui_advancedinfo'] = false;// hide advanced user interface information by default
// other
$tasksmanager_settings['standardsettings']['ecq'] = array();
$tasksmanager_settings['standardsettings']['chmod'] = '0750';
$tasksmanager_settings['standardsettings']['systematicpostupdating'] = 'enabled';
// testing and development
$tasksmanager_settings['standardsettings']['developementinsight'] = 'disabled';
// global switches
$tasksmanager_settings['standardsettings']['textspinrespinning'] = 'enabled';// disabled stops all text spin re-spinning and sticks to the last spin

##########################################################################################
#                                                                                        #
#                           SETTINGS WITH NO UI OPTION                                   #
#              array key should be the method/function the setting is used in            #
##########################################################################################
$tasksmanager_settings['create_localmedia_fromlocalimages']['destinationdirectory'] = 'wp-content/uploads/importedmedia/';
 
##########################################################################################
#                                                                                        #
#                            DATA IMPORT AND MANAGEMENT SETTINGS                         #
#                                                                                        #
##########################################################################################
$tasksmanager_settings['datasettings']['insertlimit'] = 100;

##########################################################################################
#                                                                                        #
#                                    WIDGET SETTINGS                                     #
#                                                                                        #
##########################################################################################
$tasksmanager_settings['widgetsettings']['dashboardwidgetsswitch'] = 'disabled';

##########################################################################################
#                                                                                        #
#                            CUSTOM POST TYPE SETTINGS                                   #
#                                                                                        #
##########################################################################################
$tasksmanager_settings['posttypes']['wtgflags']['status'] = 'disabled';
$tasksmanager_settings['posttypes']['wtgtasks']['status'] = 'enabled';
$tasksmanager_settings['posttypes']['posts']['status'] = 'disabled';

##########################################################################################
#                                                                                        #
#                                    NOTICE SETTINGS                                     #
#                                                                                        #
##########################################################################################
$tasksmanager_settings['noticesettings']['wpcorestyle'] = 'enabled';

##########################################################################################
#                                                                                        #
#                           YOUTUBE RELATED SETTINGS                                     #
#                                                                                        #
##########################################################################################
$tasksmanager_settings['youtubesettings']['defaultcolor'] = '&color1=0x2b405b&color2=0x6b8ab6';
$tasksmanager_settings['youtubesettings']['defaultborder'] = 'enable';
$tasksmanager_settings['youtubesettings']['defaultautoplay'] = 'enable';
$tasksmanager_settings['youtubesettings']['defaultfullscreen'] = 'enable';
$tasksmanager_settings['youtubesettings']['defaultscriptaccess'] = 'always';

##########################################################################################
#                                                                                        #
#                                  LOG SETTINGS                                          #
#                                                                                        #
##########################################################################################
$tasksmanager_settings['logsettings']['uselog'] = 1;
$tasksmanager_settings['logsettings']['loglimit'] = 1000;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['outcome'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['timestamp'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['line'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['function'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['page'] = true; 
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['panelname'] = true;   
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['userid'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['type'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['category'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['action'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['priority'] = true;
$tasksmanager_settings['logsettings']['logscreen']['displayedcolumns']['comment'] = true;
?>