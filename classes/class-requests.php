<?php
/** 
* Class for handling $_POST and $_GET requests
* 
* The class is called in the process_admin_POST_GET() method found in the WTGTASKSMANAGER class. 
* The process_admin_POST_GET() method is hooked at admin_init. It means requests are handled in the admin
* head, globals can be updated and pages will show the most recent data. Nonce security is performed
* within process_admin_POST_GET() then the require method for processing the request is used.
* 
* Methods in this class MUST be named within the form or link itself, basically a unique identifier for the form.
* i.e. the Section Switches settings have a form name of "sectionswitches" and so the method in this class used to
* save submission of the "sectionswitches" form is named "sectionswitches".
* 
* process_admin_POST_GET() uses eval() to call class + method 
* 
* @package WTG Tasks Manager
* @author Ryan Bayne   
* @since 0.0.1
*/

// load in Wordpress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
* Class processes form submissions, the class is only loaded once nonce and other security checked
* 
* @author Ryan R. Bayne
* @package WTG Tasks Manager
* @since 0.0.1
* @version 1.0.2
*/
class WTGTASKSMANAGER_Requests {  
    public function __construct() {
        global $c2p_settings;
    
        // create class objects
        $this->WTGTASKSMANAGER = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER', 'class-wtgtasksmanager.php', 'classes' ); # plugin specific functions
        $this->UI = $this->WTGTASKSMANAGER->load_class( 'WTGTASKSMANAGER_UI', 'class-ui.php', 'classes' ); # interface, mainly notices
        $this->DB = $this->WTGTASKSMANAGER->load_class( 'WTGTASKSMANAGER_DB', 'class-wpdb.php', 'classes' ); # database interaction
        $this->PHP = $this->WTGTASKSMANAGER->load_class( 'WTGTASKSMANAGER_PHP', 'class-phplibrary.php', 'classes' ); # php library by Ryan R. Bayne
        $this->Files = $this->WTGTASKSMANAGER->load_class( 'WTGTASKSMANAGER_Files', 'class-files.php', 'classes' );
        $this->Forms = $this->WTGTASKSMANAGER->load_class( 'WTGTASKSMANAGER_Formbuilder', 'class-forms.php', 'classes' );
        $this->WPCore = $this->WTGTASKSMANAGER->load_class( 'WTGTASKSMANAGER_WPCore', 'class-wpcore.php', 'classes' );
        $this->TabMenu = $this->WTGTASKSMANAGER->load_class( "WTGTASKSMANAGER_TabMenu", "class-pluginmenu.php", 'classes','pluginmenu' );    
    }
    
    /**
    * Processes security for $_POST and $_GET requests,
    * then calls another function to complete the specific request made.
    * 
    * This function is called by process_admin_POST_GET() which is hooked by admin_init.
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function process_admin_request() {  
        $method = 'post';// post or get
        
        // ensure processing requested
        // if a hacker changes this, no processing happens so no validation required
        if(!isset( $_POST['wtgtasksmanager_admin_action'] ) && !isset( $_GET['wtgtasksmanageraction'] ) ) {
            return;
        }          
               
        // handle $_POST action - form names are validated
        if( isset( $_POST['wtgtasksmanager_admin_action'] ) && $_POST['wtgtasksmanager_admin_action'] == true){        
            if( isset( $_POST['wtgtasksmanager_admin_referer'] ) ){        
                
                // a few forms have the wtgtasksmanager_admin_referer where the default hidden values are not in use
                check_admin_referer( $_POST['wtgtasksmanager_admin_referer'] ); 
                $function_name = $_POST['wtgtasksmanageraction'];     
                   
            } else {                                       
                
                // 99% of forms will use this method
                check_admin_referer( $_POST['wtgtasksmanager_form_name'] );
                $function_name = $_POST['wtgtasksmanager_form_name'];
            
            }        
        }
                          
        // $_GET request
        if( isset( $_GET['wtgtasksmanageraction'] ) ){      
            check_admin_referer( $_GET['wtgtasksmanageraction'] );        
            $function_name = $_GET['wtgtasksmanageraction'];
            $method = 'get';
        }     
                   
        // arriving here means check_admin_referer() security is positive       
        global $c2p_debug_mode, $cont;

        $this->PHP->var_dump( $_POST, '<h1>$_POST</h1>' );           
        $this->PHP->var_dump( $_GET, '<h1>$_GET</h1>' );    
        
        // $_POST security
        if( $method == 'post' ) {                      
            // check_admin_referer() wp_die()'s if security fails so if we arrive here Wordpress security has been passed
            // now we validate individual values against their pre-registered validation method
            // some generic notices are displayed - this system makes development faster
            $post_result = true;
            $post_result = $this->Forms->apply_form_security();// ensures $_POST['wtgtasksmanager_form_formid'] is set, so we can use it after this line
            
            // apply my own level of security per individual input
            if( $post_result ){ $post_result = $this->Forms->apply_input_security(); }// detect hacking of individual inputs i.e. disabled inputs being enabled 
            
            // validate users values
            if( $post_result ){ $post_result = $this->Forms->apply_input_validation( $_POST['wtgtasksmanager_form_formid'] ); }// values (string,numeric,mixed) validation

            // cleanup to reduce registered data
            $this->Forms->deregister_form( $_POST['wtgtasksmanager_form_formid'] );
                    
            // if $overall_result includes a single failure then there is no need to call the final function
            if( $post_result === false ) {        
                return false;
            }
        }
        
        // handle a situation where the submitted form requests a function that does not exist
        if( !method_exists( $this, $function_name ) ){
            wp_die( sprintf( __( "The method for processing your request was not found. This can usually be resolved quickly. Please report method %s does not exist. <a href='https://www.youtube.com/watch?v=vAImGQJdO_k' target='_blank'>Watch a video</a> explaining this problem.", 'wtgtasksmanager' ), 
            $function_name) ); 
            return false;// should not be required with wp_die() but it helps to add clarity when browsing code and is a precaution.   
        }
        
        // all security passed - call the processing function
        if( isset( $function_name) && is_string( $function_name ) ) {
            eval( 'self::' . $function_name .'();' );
        }
    }  

    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */    
    public function request_success( $form_title, $more_info = '' ){  
        $this->UI->create_notice( "Your submission for $form_title was successful. " . $more_info, 'success', 'Small', "$form_title Updated");          
    } 

    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */    
    public function request_failed( $form_title, $reason = '' ){
        $this->UI->n_depreciated( $form_title . ' Unchanged', "Your settings for $form_title were not changed. " . $reason, 'error', 'Small' );    
    }

    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */    
    public function logsettings() {
        global $c2p_settings;
        $c2p_settings['globalsettings']['uselog'] = $_POST['wtgtasksmanager_radiogroup_logstatus'];
        $c2p_settings['globalsettings']['loglimit'] = $_POST['wtgtasksmanager_loglimit'];
                                                   
        ##################################################
        #           LOG SEARCH CRITERIA                  #
        ##################################################
        
        // first unset all criteria
        if( isset( $c2p_settings['logsettings']['logscreen'] ) ){
            unset( $c2p_settings['logsettings']['logscreen'] );
        }
                                                           
        // if a column is set in the array, it indicates that it is to be displayed, we unset those not to be set, we dont set them to false
        if( isset( $_POST['wtgtasksmanager_logfields'] ) ){
            foreach( $_POST['wtgtasksmanager_logfields'] as $column){
                $c2p_settings['logsettings']['logscreen']['displayedcolumns'][$column] = true;                   
            }
        }
                                                                                 
        // outcome criteria
        if( isset( $_POST['wtgtasksmanager_log_outcome'] ) ){    
            foreach( $_POST['wtgtasksmanager_log_outcome'] as $outcomecriteria){
                $c2p_settings['logsettings']['logscreen']['outcomecriteria'][$outcomecriteria] = true;                   
            }            
        } 
        
        // type criteria
        if( isset( $_POST['wtgtasksmanager_log_type'] ) ){
            foreach( $_POST['wtgtasksmanager_log_type'] as $typecriteria){
                $c2p_settings['logsettings']['logscreen']['typecriteria'][$typecriteria] = true;                   
            }            
        }         

        // category criteria
        if( isset( $_POST['wtgtasksmanager_log_category'] ) ){
            foreach( $_POST['wtgtasksmanager_log_category'] as $categorycriteria){
                $c2p_settings['logsettings']['logscreen']['categorycriteria'][$categorycriteria] = true;                   
            }            
        }         

        // priority criteria
        if( isset( $_POST['wtgtasksmanager_log_priority'] ) ){
            foreach( $_POST['wtgtasksmanager_log_priority'] as $prioritycriteria){
                $c2p_settings['logsettings']['logscreen']['prioritycriteria'][$prioritycriteria] = true;                   
            }            
        }         

        ############################################################
        #         SAVE CUSTOM SEARCH CRITERIA SINGLE VALUES        #
        ############################################################
        // page
        if( isset( $_POST['wtgtasksmanager_pluginpages_logsearch'] ) && $_POST['wtgtasksmanager_pluginpages_logsearch'] != 'notselected' ){
            $c2p_settings['logsettings']['logscreen']['page'] = $_POST['wtgtasksmanager_pluginpages_logsearch'];
        }   
        // action
        if( isset( $_POST['csv2pos_logactions_logsearch'] ) && $_POST['csv2pos_logactions_logsearch'] != 'notselected' ){
            $c2p_settings['logsettings']['logscreen']['action'] = $_POST['csv2pos_logactions_logsearch'];
        }   
        // screen
        if( isset( $_POST['wtgtasksmanager_pluginscreens_logsearch'] ) && $_POST['wtgtasksmanager_pluginscreens_logsearch'] != 'notselected' ){
            $c2p_settings['logsettings']['logscreen']['screen'] = $_POST['wtgtasksmanager_pluginscreens_logsearch'];
        }  
        // line
        if( isset( $_POST['wtgtasksmanager_logcriteria_phpline'] ) ){
            $c2p_settings['logsettings']['logscreen']['line'] = $_POST['wtgtasksmanager_logcriteria_phpline'];
        }  
        // file
        if( isset( $_POST['wtgtasksmanager_logcriteria_phpfile'] ) ){
            $c2p_settings['logsettings']['logscreen']['file'] = $_POST['wtgtasksmanager_logcriteria_phpfile'];
        }          
        // function
        if( isset( $_POST['wtgtasksmanager_logcriteria_phpfunction'] ) ){
            $c2p_settings['logsettings']['logscreen']['function'] = $_POST['wtgtasksmanager_logcriteria_phpfunction'];
        }
        // panel name
        if( isset( $_POST['wtgtasksmanager_logcriteria_panelname'] ) ){
            $c2p_settings['logsettings']['logscreen']['panelname'] = $_POST['wtgtasksmanager_logcriteria_panelname'];
        }
        // IP address
        if( isset( $_POST['wtgtasksmanager_logcriteria_ipaddress'] ) ){
            $c2p_settings['logsettings']['logscreen']['ipaddress'] = $_POST['wtgtasksmanager_logcriteria_ipaddress'];
        }
        // user id
        if( isset( $_POST['wtgtasksmanager_logcriteria_userid'] ) ){
            $c2p_settings['logsettings']['logscreen']['userid'] = $_POST['wtgtasksmanager_logcriteria_userid'];
        }
        
        $this->WTGTASKSMANAGER->update_settings( $c2p_settings );
        $this->UI->n_postresult_depreciated( 'success', __( 'Log Settings Saved', 'wtgtasksmanager' ), __( 'It may take sometime for new log entries to be created depending on your websites activity.', 'wtgtasksmanager' ) );  
    }  
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */       
    public function beginpluginupdate() {
        $this->Updates = $this->WTGTASKSMANAGER->load_class( 'WTGTASKSMANAGER_Formbuilder', 'class-forms.php', 'classes' );
        
        // check if an update method exists, else the plugin needs to do very little
        eval( '$method_exists = method_exists ( $this->Updates , "patch_' . $_POST['wtgtasksmanager_plugin_update_now'] .'" );' );

        if( $method_exists){
            // perform update by calling the request version update procedure
            eval( '$update_result_array = $this->Updates->patch_' . $_POST['wtgtasksmanager_plugin_update_now'] .'( "update");' );       
        }else{
            // default result to true
            $update_result_array['failed'] = false;
        } 
      
        if( $update_result_array['failed'] == true){           
            $this->UI->create_notice( __( 'The update procedure failed, the reason should be displayed below. Please try again unless the notice below indicates not to. If a second attempt fails, please seek support.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Update Failed', 'wtgtasksmanager' ) );    
            $this->UI->create_notice( $update_result_array['failedreason'], 'info', 'Small', 'Update Failed Reason' );
        }else{  
            // storing the current file version will prevent user coming back to the update screen
            global $c2p_currentversion;        
            update_option( 'wtgtasksmanager_installedversion', $c2p_currentversion);

            $this->UI->create_notice( __( 'Good news, the update procedure was complete. If you do not see any errors or any notices indicating a problem was detected it means the procedure worked. Please ensure any new changes suit your needs.', 'wtgtasksmanager' ), 'success', 'Small', __( 'Update Complete', 'wtgtasksmanager' ) );
            
            // do a redirect so that the plugins menu is reloaded
            wp_redirect( get_bloginfo( 'url' ) . '/wp-admin/admin.php?page=wtgtasksmanager' );
            exit;                
        }
    }
    
    /**
    * Save drip feed limits  
    */
    public function schedulerestrictions() {
        $c2p_schedule_array = $this->WTGTASKSMANAGER->get_option_schedule_array();
        
        // if any required values are not in $_POST set them to zero
        if(!isset( $_POST['day'] ) ){
            $c2p_schedule_array['limits']['day'] = 0;        
        }else{
            $c2p_schedule_array['limits']['day'] = $_POST['day'];            
        }
        
        if(!isset( $_POST['hour'] ) ){
            $c2p_schedule_array['limits']['hour'] = 0;
        }else{
            $c2p_schedule_array['limits']['hour'] = $_POST['hour'];            
        }
        
        if(!isset( $_POST['session'] ) ){
            $c2p_schedule_array['limits']['session'] = 0;
        }else{
            $c2p_schedule_array['limits']['session'] = $_POST['session'];            
        }
                                 
        // ensure $c2p_schedule_array is an array, it may be boolean false if schedule has never been set
        if( isset( $c2p_schedule_array ) && is_array( $c2p_schedule_array ) ){
            
            // if times array exists, unset the [times] array
            if( isset( $c2p_schedule_array['days'] ) ){
                unset( $c2p_schedule_array['days'] );    
            }
            
            // if hours array exists, unset the [hours] array
            if( isset( $c2p_schedule_array['hours'] ) ){
                unset( $c2p_schedule_array['hours'] );    
            }
            
        }else{
            // $schedule_array value is not array, this is first time it is being set
            $c2p_schedule_array = array();
        }
        
        // loop through all days and set each one to true or false
        if( isset( $_POST['wtgtasksmanager_scheduleday_list'] ) ){
            foreach( $_POST['wtgtasksmanager_scheduleday_list'] as $key => $submitted_day ){
                $c2p_schedule_array['days'][$submitted_day] = true;        
            }  
        } 
        
        // loop through all hours and add each one to the array, any not in array will not be permitted                              
        if( isset( $_POST['wtgtasksmanager_schedulehour_list'] ) ){
            foreach( $_POST['wtgtasksmanager_schedulehour_list'] as $key => $submitted_hour){
                $c2p_schedule_array['hours'][$submitted_hour] = true;        
            }           
        }    

        if( isset( $_POST['deleteuserswaiting'] ) )
        {
            $c2p_schedule_array['eventtypes']['deleteuserswaiting']['switch'] = 'enabled';                
        }
        
        if( isset( $_POST['eventsendemails'] ) )
        {
            $c2p_schedule_array['eventtypes']['sendemails']['switch'] = 'enabled';    
        }        
  
        $this->WTGTASKSMANAGER->update_option_schedule_array( $c2p_schedule_array );
        $this->UI->notice_depreciated( __( 'Schedule settings have been saved.', 'wtgtasksmanager' ), 'success', 'Large', __( 'Schedule Times Saved', 'wtgtasksmanager' ) );   
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */       
    public function logsearchoptions() {
        $this->UI->n_postresult_depreciated( 'success', __( 'Log Search Settings Saved', 'wtgtasksmanager' ), __( 'Your selections have an instant effect. Please browse the Log screen for the results of your new search.', 'wtgtasksmanager' ) );                   
    }
 
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */        
    public function defaultcontenttemplate () {        
        $this->UI->create_notice( __( 'Your default content template has been saved. This is a basic template, other advanced options may be available by activating the WTG Tasks Manager Templates custom post type (pro edition only) for managing multiple template designs.' ), 'success', 'Small', __( 'Default Content Template Updated' ) );         
    }
        
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */       
    public function reinstalldatabasetables() {
        $installation = new WTGTASKSMANAGER_Install();
        $installation->reinstalldatabasetables();
        $this->UI->create_notice( 'All tables were re-installed. Please double check the database status list to
        ensure this is correct before using the plugin.', 'success', 'Small', 'Tables Re-Installed' );
    }
     
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */          
    public function globalswitches() {
        global $c2p_settings;
        $c2p_settings['noticesettings']['wpcorestyle'] = $_POST['uinoticestyle'];        
        $c2p_settings['standardsettings']['textspinrespinning'] = $_POST['textspinrespinning'];
        $c2p_settings['standardsettings']['systematicpostupdating'] = $_POST['systematicpostupdating'];
        $c2p_settings['flagsystem']['status'] = $_POST['flagsystemstatus'];
        $c2p_settings['widgetsettings']['dashboardwidgetsswitch'] = $_POST['dashboardwidgetsswitch'];
        $this->WTGTASKSMANAGER->update_settings( $c2p_settings ); 
        $this->UI->create_notice( __( 'Global switches have been updated. These switches can initiate the use of 
        advanced systems. Please monitor your blog and ensure the plugin operates as you expected it to. If
        anything does not appear to work in the way you require please let WebTechGlobal know.' ),
        'success', 'Small', __( 'Global Switches Updated' ) );       
    } 
       
    /**
    * save capability settings for plugins pages
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function pagecapabilitysettings() {
        
        // get the capabilities array from WP core
        $capabilities_array = $this->WPCore->capabilities();

        // get stored capability settings 
        $saved_capability_array = get_option( 'wtgtasksmanager_capabilities' );
        
        // get the tab menu 
        $pluginmenu = $this->TabMenu->menu_array();
                
        // to ensure no extra values are stored (more menus added to source) loop through page array
        foreach( $pluginmenu as $key => $page_array ) {
            
            // ensure $_POST value is also in the capabilities array to ensure user has not hacked form, adding their own capabilities
            if( isset( $_POST['pagecap' . $page_array['name'] ] ) && in_array( $_POST['pagecap' . $page_array['name'] ], $capabilities_array ) ) {
                $saved_capability_array['pagecaps'][ $page_array['name'] ] = $_POST['pagecap' . $page_array['name'] ];
            }
                
        }
          
        update_option( 'wtgtasksmanager_capabilities', $saved_capability_array );
         
        $this->UI->create_notice( __( 'Capabilities for this plugins pages have been stored. Due to this being security related I recommend testing before you logout. Ensure that each role only has access to the plugin pages you intend.' ), 'success', 'Small', __( 'Page Capabilities Updated' ) );        
    }
    
    /**
    * Saves the plugins global dashboard widget settings i.e. which to display, what to display, which roles to allow access
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function dashboardwidgetsettings() {
        global $c2p_settings;
        
        // loop through pages
        $WTGTASKSMANAGER_TabMenu = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_TabMenu', 'class-pluginmenu.php', 'classes' );
        $menu_array = $WTGTASKSMANAGER_TabMenu->menu_array();       
        foreach( $menu_array as $key => $section_array ) {

            if( isset( $_POST[ $section_array['name'] . 'dashboardwidgetsswitch' ] ) ) {
                $c2p_settings['widgetsettings'][ $section_array['name'] . 'dashboardwidgetsswitch'] = $_POST[ $section_array['name'] . 'dashboardwidgetsswitch' ];    
            }
            
            if( isset( $_POST[ $section_array['name'] . 'widgetscapability' ] ) ) {
                $c2p_settings['widgetsettings'][ $section_array['name'] . 'widgetscapability'] = $_POST[ $section_array['name'] . 'widgetscapability' ];    
            }

        }

        $this->WTGTASKSMANAGER->update_settings( $c2p_settings );    
        $this->UI->create_notice( __( 'Your dashboard widget settings have been saved. Please check your dashboard to ensure it is configured as required per role.', 'wtgtasksmanager' ), 'success', 'Small', __( 'Settings Saved', 'wtgtasksmanager' ) );         
    }
    
    /**
    * Insert new entry to the webtechglobal_projects table.
    * 
    * @author Ryan R. Bayne
    * @package Wordpress Plugin Framework Pro
    * @since 0.0.1
    * @version 1.0
    */
    public function startnewproject() {
        $project_id = $this->WTGTASKSMANAGER->insertproject( $_POST['newprojectname'] );  
        $this->UI->create_notice( __( "The project ID is $project_id and you can begin assigning tasks to it.", 'wtgtasksmanager' ), 'success', 'Small', __( 'Project Created', 'wtgtasksmanager' ) );                                              
    }
    
    /**
    * Handles request to cancel a single task.
    * 
    * @author Ryan R. Bayne
    * @package Wordpress Plugin Framework Pro
    * @since 0.0.1
    * @version 1.0
    */
    public function canceltask() {
        // if no task value in URL 
        if( !isset( $_GET['task'] ) ) {
            $this->UI->create_notice( __( "Could not cancel a task as no task ID was submitted.", 'wtgtasksmanager' ), 'error', 'Small', __( 'No Task ID', 'wtgtasksmanager' ) );                                               
            return false;    
        }
        
        // if task value not numeric
        if( !is_numeric( $_GET['task'] ) ) {
            $this->UI->create_notice( __( "Could not cancel a task because the submitted task ID is not numeric.", 'wtgtasksmanager' ), 'error', 'Small', __( 'Invalid Task ID', 'wtgtasksmanager' ) );                                                           
            return false;    
        }
        
        // ensure task post exists (do not assume ID is a task post it may be another post)
        $task = get_post( $_GET['task'] );
        if( !$task || $task->post_type == 'post_type' ) {
            $this->UI->create_notice( __( "The task ID you submitted does not appear to belong to any tasks.", 'wtgtasksmanager' ), 'warning', 'Small', __( 'Task Does Not Exist', 'wtgtasksmanager' ) );                                                           
            return false;    
        }        
        
        // update task post
        $my_post = array();
        $my_post['ID'] = $_GET['task'];
        $my_post['post_status'] = 'cancelledtask';
        wp_update_post( $my_post );
        
        $this->UI->create_notice( __( "The task with ID " . $_GET['task'] . " has been cancelled.", 'wtgtasksmanager' ), 'success', 'Small', __( 'Task Cancelled', 'wtgtasksmanager' ) );                                                                 
    }
    
    /**
    * Changes a tasks status to "startedtask"
    * 
    * @author Ryan R. Bayne
    * @package Wordpress Plugin Framework Pro
    * @since 0.0.1
    * @version 1.0
    */
    public function continuetask() {
        // if no task value in URL 
        if( !isset( $_GET['task'] ) ) {
            $this->UI->create_notice( __( "Cannot continue task because no task ID has been submitted.", 'wtgtasksmanager' ), 'error', 'Small', __( 'No Task ID', 'wtgtasksmanager' ) );                                               
            return false;    
        }
        
        // if task value not numeric
        if( !is_numeric( $_GET['task'] ) ) {
            $this->UI->create_notice( __( "Could not change any task because the submitted task ID is not a number.", 'wtgtasksmanager' ), 'error', 'Small', __( 'Invalid Task ID', 'wtgtasksmanager' ) );                                                           
            return false;    
        }
        
        // ensure task post exists (do not assume ID is a task post it may be another post)
        $task = get_post( $_GET['task'] );
        if( !$task || $task->post_type == 'post_type' ) {
            $this->UI->create_notice( __( "The task ID you submitted does not belong to a task.", 'wtgtasksmanager' ), 'warning', 'Small', __( 'Task Does Not Exist', 'wtgtasksmanager' ) );                                                           
            return false;    
        }        
        
        // update task post
        $my_post = array();
        $my_post['ID'] = $_GET['task'];
        $my_post['post_status'] = 'startedtask';
        wp_update_post( $my_post );
        
        $this->UI->create_notice( __( "The task with ID " . $_GET['task'] . " will be continued. You can find the task on the Started screen.", 'wtgtasksmanager' ), 'success', 'Small', __( 'Task Being Continued', 'wtgtasksmanager' ) );                                                                    
    }    
    
    /**
    * Changes a tasks status to "closedtask"
    * 
    * @author Ryan R. Bayne
    * @package Wordpress Plugin Framework Pro
    * @since 0.0.1
    * @version 1.0
    */
    public function closetask() {
        // if no task value in URL 
        if( !isset( $_GET['task'] ) ) {
            $this->UI->create_notice( __( "Cannot close task because no task ID was submitted.", 'wtgtasksmanager' ), 'error', 'Small', __( 'Task ID Required', 'wtgtasksmanager' ) );                                               
            return false;    
        }
        
        // if task value not numeric
        if( !is_numeric( $_GET['task'] ) ) {
            $this->UI->create_notice( __( "Could not change a task because the submitted task ID is not numeric.", 'wtgtasksmanager' ), 'error', 'Small', __( 'Invalid Task ID', 'wtgtasksmanager' ) );                                                           
            return false;    
        }
        
        // ensure task post exists (do not assume ID is a task post it may be another post)
        $task = get_post( $_GET['task'] );
        if( !$task || $task->post_type == 'post_type' ) {
            $this->UI->create_notice( __( "The ID you submitted does not belong to a task.", 'wtgtasksmanager' ), 'warning', 'Small', __( 'Task Does Not Exist', 'wtgtasksmanager' ) );                                                           
            return false;    
        }        
        
        // update task post
        $my_post = array();
        $my_post['ID'] = $_GET['task'];
        $my_post['post_status'] = 'startedtask';
        wp_update_post( $my_post );
        
        $this->UI->create_notice( __( "The task with ID " . $_GET['task'] . " has been closed. You can find the task on the Closed screen.", 'wtgtasksmanager' ), 'success', 'Small', __( 'Task Closed', 'wtgtasksmanager' ) );                                                                    
    }
    
    /**
    * Changes a tasks status to "finishedstatus"
    * 
    * @author Ryan R. Bayne
    * @package Wordpress Plugin Framework Pro
    * @since 0.0.1
    * @version 1.0
    */
    public function finishtask() {
        // if no task value in URL 
        if( !isset( $_GET['task'] ) ) {
            $this->UI->create_notice( __( "Cannot finish a task because no task ID was provided.", 'wtgtasksmanager' ), 'error', 'Small', __( 'Task ID Required', 'wtgtasksmanager' ) );                                               
            return false;    
        }
        
        // if task value not numeric
        if( !is_numeric( $_GET['task'] ) ) {
            $this->UI->create_notice( __( "Could not change a task because the submitted task ID is not numeric.", 'wtgtasksmanager' ), 'error', 'Small', __( 'Invalid Task ID', 'wtgtasksmanager' ) );                                                           
            return false;    
        }
        
        // ensure task post exists (do not assume ID is a task post it may be another post)
        $task = get_post( $_GET['task'] );
        if( !$task || $task->post_type == 'post_type' ) {
            $this->UI->create_notice( __( "The ID you submitted does not belong to a task.", 'wtgtasksmanager' ), 'warning', 'Small', __( 'Task Does Not Exist', 'wtgtasksmanager' ) );                                                           
            return false;    
        }        
        
        // update task post
        $my_post = array();
        $my_post['ID'] = $_GET['task'];
        $my_post['post_status'] = 'finishedtask';
        wp_update_post( $my_post );
        
        $this->UI->create_notice( __( "The task with ID " . $_GET['task'] . " has been finished. You can find the task on the Finished screen.", 'wtgtasksmanager' ), 'success', 'Small', __( 'Task Finished', 'wtgtasksmanager' ) );                                                                    
    }
    
    #################################################################
    #                                                               #
    #              BETA TESTING FUNCTIONS BEGIN HERE                #
    #                                                               #
    #################################################################
    /**
    * About
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function t1() {

        $this->UI->create_notice( 'If you submitted a form on the dashboard, it must have been the one that calls
        this notice which is just a test. Thank you for being a beta tester even if you did not signup for it!', 
        'success', 'Small', __( 'Dashboard Test Worked', 'wtgtasksmanager' ) );

    }
    
    /**
    * Processes a beta test form
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function t4() {
        
        // we want to pass an array which determines our category set. 
        // this is where the pre-set category would need to be set, I will run a test with pre-set and one without
        $new_categories = array( 'Delete Me 1', 'Delete Me 2', 'Delete Me 3', 'Delete Me 4' );
        
        // run this without mapping to create a simplified version of the method
        $WTGTASKSMANAGER_Categories = new WTGTASKSMANAGER_Categories();
        $result = $WTGTASKSMANAGER_Categories->create_categories_set( $new_categories, false );

        echo '<h4>Result (without Pre-Set parent or mapping)</h4>';
        echo '<pre>';
        var_dump( $result );
        echo '</pre>'; 
        
               
        // run again with pre-set category setting in use for the current project
        // Delete Me 1 should be created as child of pre-set category
        $new_categories = array( 'Delete Me 1', 'Delete Me 2', 'Delete Me 3', 'Delete Me 4' );
        $preset_parent = 313;
        $result = $WTGTASKSMANAGER_Categories->create_categories_set( $new_categories, $preset_parent );

        echo '<h4>Result (with Pre-Set parent but no mapping)</h4>';
        echo '<pre>';
        var_dump( $result );
        echo '</pre>'; 
                                  
   
    }
    
    /**
    * Processes a beta test form
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t1() {    
        $WTGTASKSMANAGER_Files = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_Files', 'class-files.php', 'classes' );
        
        // perform sanitization
        $url = sanitize_url( $_POST['newdatasourcetheurl'] );
        
        // ensure user is attempting to transfer a .csv file, this concludes validation
        $path_parts = pathinfo( $url );
        if( $path_parts['extension'] !== 'csv' ) {
            $this->UI->create_notice( __( 'WTG Tasks Manager focuses on .csv files only. Please see the WebTechGlobal plugin
            range for other solutions.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Only .csv Files Allowed', 'wtgtasksmanager' ) );
            return false;
        }
          
        $result = $WTGTASKSMANAGER_Files->file_from_url( $url, null, false );
        
        if( $result ) {
            
            $this->UI->create_notice( $result['message'], 'success', 'Small', __( 'File Imported', 'wtgtasksmanager' ) );
               
        } else {
            
            var_dump( $result );   
             
        }
    }    
    
    /**
    * About
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t2() {
        global $wpdb, $c2p_settings;
        $WTGTASKSMANAGER_Files = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_Files', 'class-files.php', 'classes' );

        if(empty( $_POST['newdatasourcetheurl'] ) ){
            $this->UI->create_notice( __( 'Please enter the URL to your .csv file.', 'wtgtasksmanager' ), 'error', 'Small', __( 'URL Field Required', 'wtgtasksmanager' ) );
            return;
        }
                            
        // perform sanitization
        $url = sanitize_url( $_POST['newdatasourcetheurl'] );
        
        // ensure user is attempting to transfer a .csv file
        $path_parts = pathinfo( $url );
        if( $path_parts['extension'] !== 'csv' ) {
            $this->UI->create_notice( __( 'WTG Tasks Manager focuses on .csv files only. Please see the WebTechGlobal plugin
            range for other solutions.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Only .csv Files Allowed', 'wtgtasksmanager' ) );
            return false;
        }
        
        // import file using URL to the giving path  
        $file_import_result = $WTGTASKSMANAGER_Files->file_from_url( $url, null, false );       
        if( !$file_import_result['outcome'] ) {             
            $this->UI->create_notice( $file_import_result['failurereason'], 'error', 'Small', __( 'File Transfer Failed', 'wtgtasksmanager' ) );
            return;    
        } 
        
        // build array of information for this file (this can be customized to work with multiple files)
        $files_array = array( 'total_files' => 1 );
                
        // add path for this file to $files_array which is then stored in data source table
        $files_array[1]['fullpath'] = $file_import_result['file']['path'];
            
        // create success notice regarding file processing 
        $this->UI->create_notice( $file_import_result['message'], 'success', 'Small', __( 'File Transferred', 'wtgtasksmanager' ) );   
                
        // establish separator
        $files_array[1]['sep'] = $this->Files->established_separator( $file_import_result['file']['path'] );
        
        // we are ready to read the file
        $file = new SplFileObject( $file_import_result['file']['path'] );
        while (!$file->eof() ) {
            $header_array = $file->fgetcsv( $files_array[1]['sep'], '"' );
            break;// we just need the first line to do a count()
        }       
        
        // count number of fields
        $files_array[1]['fields'] = count( $header_array );
        
        // create arrays of original headers and one of sql prepared headers
        foreach( $header_array as $key => $header ){  
            $files_array[1]['originalheaders'][$key] = $header;
            $files_array[1]['sqlheaders'][$key] = $this->PHP->clean_sqlcolumnname( $header );        
        }    
        
        // set basename
        $files_array[1]['basename'] = basename( $file_import_result['file']['path'] );            

        // use basename to create database table name
        $files_array[1]['tablename'] = $wpdb->prefix . $this->PHP->clean_sqlcolumnname( $files_array[1]['basename'] );
        
        // set data treatment, the form allows a single file so 'single' is applied
        $files_array[1]['datatreatment'] = 'single';
        
        // ensure ID column is valid
        $cleanedidcolumn = '';
        if(!empty( $_POST['uniqueidcolumn'] ) ){
            $cleanedidcolumn = $this->PHP->clean_sqlcolumnname( $_POST['uniqueidcolumn'] );
            if(!in_array( $cleanedidcolumn, $files_array[1]['sqlheaders'] ) ){
                $this->UI->create_notice( 'You entered '.$_POST['uniqueidcolumn'].' as your ID column but it
                does not match any column header in your .csv file.', 'error', 'Small', __( "Invalid ID Column") );
                return;
            }
        } 
        
        // set project name
        if( empty( $_POST['newprojectname'] ) ){
            $files_array['projectname'] = basename( $files_array[1]['fullpath'] );
        }else{
            $files_array['projectname'] = $_POST['newprojectname'];
        }
        
        // does planned database table name exist                       
        $table_exists_result = $this->DB->does_table_exist( $files_array[1]['tablename'] );
        if( $table_exists_result){
            // drop table if user entered the random number
            if( $_POST['deleteexistingtable'] ==  $_POST['deleteexistingtablecode'] ){   
                $this->DB->drop_table( $files_array[1]['tablename'] );           
            }else{                
                $this->UI->create_notice( 'A database table already exists named ' . $files_array[1]['tablename'] . '. Please delete
                the existing table if it is not in use or change the name of your .csv file a little.', 'error', 'Small', 'Table Exists Already' );
                return;  
            } 
        }
        
        // make entry in the c2psources table
        $files_array[1]['sourceid'] = $this->WTGTASKSMANAGER->insert_data_source( $file_import_result['file']['path'], 0, $files_array[1]['tablename'], 'localcsv', $files_array[1], $cleanedidcolumn );
        
        // create database table for importing data into, this is where we prepare it 
        $sqlheaders_array = array();
        foreach( $files_array[1]['sqlheaders'] as $key => $header ){
            $sqlheaders_array[$header] = 'nodetails';
        }

        $this->WTGTASKSMANAGER->create_project_table( $files_array[1]['tablename'], $sqlheaders_array ); 
        self::a_table_was_created( $files_array[1]['tablename'] );                                                              
                    
        $this->UI->create_notice( __( 'Your new source of data has been setup. You can now create a project using this source. The source ID is ' . $files_array[1]['sourceid'], 'wtgtasksmanager' ), 'success', 'Small', __( 'Data Source Ready' ) );  
    }
    
    /**
    * Beta test - tests single file uploader
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t4() {    
        $WTGTASKSMANAGER_Files = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_Files', 'class-files.php', 'classes' );    
        
        $file_import_result = $WTGTASKSMANAGER_Files->singlefile_uploader( $_FILES['newsourcefileupload'] );
        
        // let the user know it has all gone very wrong and they are DOOMED! 
        if( !$file_import_result['outcome'] ) {             
            $this->UI->create_notice( $file_import_result['message'], 'error', 'Small', __( 'File Upload Failed', 'wtgtasksmanager' ) );
            return;    
        }
        
        $this->UI->create_notice( $file_import_result['message'], 'success', 'Small', __( 'File Uploaded', 'wtgtasksmanager' ) );

    }  
      
    /**
    * Beta test - tests single file uploader
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t5() {    
        $WTGTASKSMANAGER_Files = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_Files', 'class-files.php', 'classes' );    
        
        $file_import_result = $WTGTASKSMANAGER_Files->singlefile_uploader( $_FILES['uploadsinglefile'], array( 'path' => stripslashes( $_POST['uploadsinglefilepath'] ), 'error' => false ) );
                               
        // let the user know it has all gone very wrong and they are DOOMED! 
        if( !$file_import_result['outcome'] ) {             
            $this->UI->create_notice( $file_import_result['message'], 'error', 'Small', __( 'File Upload Failed', 'wtgtasksmanager' ) );
            return;    
        }
        
        $this->UI->create_notice( $file_import_result['message'], 'success', 'Small', __( 'File Uploaded', 'wtgtasksmanager' ) );

    }

    /**
    * Beta test - tests single file uploader
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t6() {    
        $this->UI->create_notice( 'Your project has been created and the ID is ' . $projectid . '. The default project name is ' . $project_name . ' which you can change using project settings.', 'success', 'Small', __( 'Project Created' ) );                    
    }     
    
    /**
    * About
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t18() {
    
        $recheck_outcome_array =  $this->WTGTASKSMANAGER->recheck_source_directory( $_POST['datasourceidforrecheck'], true, true, false, false );
    
        var_dump( $recheck_outcome_array );
    }
    
    /**
    * Processes a beta test form
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t19() {    
        $WTGTASKSMANAGER_Files = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_Files', 'class-files.php', 'classes' );
        
        // perform sanitization
        $url = sanitize_url( $_POST['newdatasourcetheurl'] );
        $path = sanitize_text_field( $_POST['newdatasourcethepath'] );
                        
        // we cannot continue if santization results in a different path
        if( $url !== $_POST['newdatasourcetheurl'] ) {
            $this->UI->create_notice( __( 'Sanitization resulted in a change to your URL. This would only happen if you entered invalid characters. Please try again.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Invalid URL Entered', 'wtgtasksmanager' ) );
            return false;            
        }
        if( $path !== $_POST['newdatasourcethepath'] ) {
            $this->UI->create_notice( __( 'Sanitization of your path resulted in a change. This means your entered path has invalid characters. Please try agsin.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Invalid Path Entered', 'wtgtasksmanager' ) );
            return false;            
        }
        
        // ensure user is attempting to transfer a .csv file, this concludes validation
        $path_parts = pathinfo( $url );
        if( $path_parts['extension'] !== 'csv' ) {
            $this->UI->create_notice( __( 'WTG Tasks Manager focuses on .csv files only. Please see the WebTechGlobal plugin
            range for other solutions.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Only .csv Files Allowed', 'wtgtasksmanager' ) );
            return false;
        }
        
        $uploads = array( 'path' => $path, 
                          'url' => $url, 
                          'subdir' => '',// use to create a new directory
                          'error' => false 
        );
          
        $result = $WTGTASKSMANAGER_Files->file_from_url( $url, $uploads, false );
        
        if( $result ) {
            
            $this->UI->create_notice( $result['message'], 'success', 'Small', __( 'File Imported', 'wtgtasksmanager' ) );
               
        } else {
            
            $this->UI->create_notice( 'Test Success', 'success', 'Small', __( 'Test Success', 'wtgtasksmanager' ) );  
             
        }
    }  
    
    /**
    * Processes a beta test form
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t20() {    
        $WTGTASKSMANAGER_Files = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_Files', 'class-files.php', 'classes' );
        
        // perform sanitization
        $url = sanitize_url( $_POST['newdatasourcetheurl'] );

        // we cannot continue if santization results in a different path
        if( $url !== $_POST['newdatasourcetheurl'] ) {
            $this->UI->create_notice( __( 'Sanitization resulted in a change to your URL. This would only happen if you entered invalid characters. Please try again.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Invalid URL Entered', 'wtgtasksmanager' ) );
            return false;            
        }
        
        // ensure user is attempting to transfer a .csv file, this concludes validation
        $path_parts = pathinfo( $url );
        if( $path_parts['extension'] !== 'csv' ) {
            $this->UI->create_notice( __( 'WTG Tasks Manager focuses on .csv files only. Please see the WebTechGlobal plugin
            range for other solutions.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Only .csv Files Allowed', 'wtgtasksmanager' ) );
            return false;
        }
        
        // get data source - directory value only
        $source_array = $this->WTGTASKSMANAGER->get_source( $_POST['newprojectdatasource'] );
        if( !$source_array ) {
            $this->UI->create_notice( __( 'Problem obtaining source data. Please seek support from WebTechGlobl.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Source Query Faileda', 'wtgtasksmanager' ) );
            return false;
        }
                   
        $uploads = array( 'path' => $source_array->directory, 
                          'url' => $url, 
                          'subdir' => '',// use to create a new directory
                          'error' => false 
        );
          
        $result = $WTGTASKSMANAGER_Files->file_from_url( $url, $uploads, false );
        
        if( $result['outcome'] === true ) {
            
            $this->UI->create_notice( $result['message'], 'success', 'Small', __( 'File Imported', 'wtgtasksmanager' ) );
               
        } else {
            
            $this->UI->create_notice( 'Test Success', 'success', 'Small', __( 'Test Success', 'wtgtasksmanager' ) );   
             
        }
    }  
    
    /**
    * Beta test - tests single file uploader
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function betatest4t21() {    
        $WTGTASKSMANAGER_Files = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_Files', 'class-files.php', 'classes' );    
        
        // get data source - directory value only
        $source_array = $this->WTGTASKSMANAGER->get_source( $_POST['datasourcefornewfile'] );
        if( !$source_array ) {
            $this->UI->create_notice( __( 'Problem obtaining source data. Please seek support from WebTechGlobl.', 'wtgtasksmanager' ), 'error', 'Small', __( 'Source Query Faileda', 'wtgtasksmanager' ) );
            return false;
        }
                   
        $uploads = array( 'path' => $source_array->directory, 
                          'subdir' => '',// use to create a new directory
                          'error' => false 
        ); 
                
        $file_import_result = $WTGTASKSMANAGER_Files->singlefile_uploader( $_FILES['uploadsinglefile'], $uploads );
                               
        // let the user know it has all gone very wrong and they are DOOMED! 
        if( !$file_import_result['outcome'] ) {             
            $this->UI->create_notice( $file_import_result['message'], 'error', 'Small', __( 'File Upload Failed', 'wtgtasksmanager' ) );
            return;    
        }
 
        $this->UI->create_notice( $file_import_result['message'], 'success', 'Small', __( 'File Uploaded', 'wtgtasksmanager' ) );
    }
    
    /**
    * Add new CRON job to WP.
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function newcronrepeatevent() {
    
        // process date   
        $aa = $_POST['aa'];
        $mm = $_POST['mm'];// month
        $jj = $_POST['jj'];
        $hh = $_POST['hh'];// hour
        $mn = $_POST['mn'];// minute
        $ss = 1;
        $aa = ($aa <= 0 ) ? date('Y') : $aa;
        $mm = ($mm <= 0 ) ? date('n') : $mm;
        $jj = ($jj > 31 ) ? 31 : $jj;
        $jj = ($jj <= 0 ) ? date('j') : $jj;
        $hh = ($hh > 23 ) ? $hh -24 : $hh;
        $mn = ($mn > 59 ) ? $mn -60 : $mn;
        $ss = ($ss > 59 ) ? $ss -60 : $ss;
        $new_date = sprintf( "%04d-%02d-%02d %02d:%02d:%02d", $aa, $mm, $jj, $hh, $mn, $ss );

        $valid_date = wp_checkdate( $mm, $jj, $aa, $new_date );
        if ( !$valid_date ) {
            return new WP_Error( 'invalid_date', __( 'Looks like the provided date is invalid please try again then report this problem to WebTechGlobal.', 'wtgtasksmanager' ) );
        }

        $time = strtotime ( $new_date, time() );

        // schedule the event
        wp_schedule_event( $time, $_POST['newcronfrequency'], $_POST['newcronhook'] );
        
        $this->UI->create_notice( __( 'Your event has been schedule using the WP CRON system.', 'wtgtasksmanager'), 'success', 'Small', __( 'Schedule Updated', 'wtgtasksmanager' ) );    
    }
    
    /**
    * About
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function unscheduleeventbyhook() {
        wp_clear_scheduled_hook( $_POST['cronhook2'] );
        $this->UI->create_notice( __( 'All of the WP CRON schedule events for "' . $_POST['cronhook2'] . '" have been cancelled.', 'wtgtasksmanager'), 'success', 'Small', __( 'Schedule Updated', 'wtgtasksmanager' ) );           
    }
    
    /**
    * Creates a standard task
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function advanced() {
        // set required tasks
        $required = 0;
        if( isset( $_POST['required'] ) && $_POST['required'] ) {
            $required = $_POST['required'];    
        }
        
        $new_task_id = $this->WTGTASKSMANAGER->tasknew( $_POST['taskname'], $_POST['taskdescription'], get_current_user_id(), $_POST['projectid'], $_POST['priority'], $required );
        $this->UI->create_notice( sprintf( __( 'Your new tasks ID is %s and you assigned it to project with ID %s.', 'wtgtasksmanager'), $new_task_id, $_POST['projectid'] ), 'success', 'Small', __( 'Schedule Updated', 'wtgtasksmanager' ) );              
    }
    
    #################################################################
    #                                                               #
    #         BETA TESTING FUNCTIONS FOR FORM BUILDER CLASS         #
    #                                                               #
    #################################################################
    public function alpha() {
    
    }
    public function alphanumeric() {
    
    }
    public function numeric() {
    
    }
    public function unsettest() {
    
    }
    public function urlstringtest () {
        echo 'URL Processing Reached';
    }
    public function disabledhacked() {
            echo 'Disabled Hacked Processing Reached';
    }
    public function menuhacked() {
    
    }
    public function capability() {
    
    }
    public function logrequest() {
    
    }
    public function hiddenvaluehacked() {
    
    }
    public function required() {
    
    }
    public function maximumlength() {
    
    }    
    public function minimumlength() {
    
    }
    public function specificpattern() {
    
    }
    public function maximumcheckboxes() {
    
    }
    public function minimumcheckboxes() {
    
    }
    public function checkboxesspecifictotal() {
    
    }
    public function radiohacked() {
    
    }
    public function autocomplete() {
    
    }
         
}// WTGTASKSMANAGER_Requests       
?>
