<?php
/**
 * Beta Test 2 [page]   
 *
 * @package WTG Tasks Manager
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 0.0.1
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Beta Test 2 [class] 
 * 
 * @package WTG Tasks Manager
 * @subpackage Views
 * @author Ryan Bayne
 * @since 0.0.1
 */
class WTGTASKSMANAGER_Betatest2_View extends WTGTASKSMANAGER_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 0.0.1
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'betatest2';
    
    public $purpose = 'normal';// normal, dashboard, metaarray (return the meta array only)
    
    /**
    * Array of meta boxes, looped through to register them on views and as dashboard widgets
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function meta_box_array() {  
        // array of meta boxes + used to register dashboard widgets (id, title, callback, context, priority, callback arguments (array), dashboard widget (boolean) )   
        return $this->meta_boxes_array = array(
            // array( id, title, callback (usually parent, approach created by Ryan Bayne), context (position), priority, call back arguments array, add to dashboard (boolean), required capability
            array( 'betatest2-currenttesting', __( 'Test Introduction', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'currenttesting' ), true, 'activate_plugins' ),
            array( 'betatest2-t1', __( 'Test A', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 't1' ), true, 'activate_plugins' ),
            array( 'betatest2-t2', __( 'WP Pointer Test', 'wtgtasksmanager' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 't2' ), true, 'activate_plugins' ),
            array( 'betatest2-errors', __( 'Errors', 'wtgtasksmanager' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'errors' ), true, 'activate_plugins' )
        );    
    }
    
    /**
     * Set up the view with data and do things that are specific for this view
     *
     * @since 0.0.1
     *
     * @param string $action Action for this view
     * @param array $data Data for this view
     */
    public function setup( $action, array $data ) {
        global $c2p_settings;
        
        // create constant for view name
        if(!defined( "WTG_WTGTASKSMANAGER_VIEWNAME") ){define( "WTG_WTGTASKSMANAGER_VIEWNAME", $this->view_name );}
        
        // create class objects
        $this->WTGTASKSMANAGER = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER', 'class-wtgtasksmanager.php', 'classes' );
        $this->UI = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_UI', 'class-ui.php', 'classes' );  
        $this->DB = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_DB', 'class-wpdb.php', 'classes' );
        $this->PHP = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_PHP', 'class-phplibrary.php', 'classes' );

        parent::setup( $action, $data );
        
        // using array register many meta boxes
        foreach( self::meta_box_array() as $key => $metabox ) {
            // the $metabox array includes required capability to view the meta box
            if( isset( $metabox[7] ) && current_user_can( $metabox[7] ) ) {
                $this->add_meta_box( $metabox[0], $metabox[1], $metabox[2], $metabox[3], $metabox[4], $metabox[5] );   
            }               
        }
        
        $pointer = new WTGTASKSMANAGER_Pointers('mypointer3', 'wtgtasksmanagerpointer1', 'My Pointers Title', 'This pointer will not stay hidden. Indicating the Ajax process is not updating user meta with closed pointers.');
        $pointer->add_action();               
    }
    
    /**
    * Outputs the meta boxes
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function metaboxes() {
        parent::register_metaboxes( self::meta_box_array() );     
    }

    /**
    * This function is called when on WP core dashboard and it adds widgets to the dashboard using
    * the meta box functions in this class. 
    * 
    * @uses dashboard_widgets() in parent class WTGTASKSMANAGER_View which loops through meta boxes and registeres widgets
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function dashboard() { 
        parent::dashboard_widgets( self::meta_box_array() );  
    }
                                                                                                                             
    /**
    * All add_meta_box() callback to this function to keep the add_meta_box() call simple.
    * 
    * This function also offers a place to apply more security or arguments.
    * 
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    function parent( $data, $box ) {
        eval( 'self::postbox_' . $this->view_name . '_' . $box['args']['formid'] . '( $data, $box );' );
    }    
 
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest2_currenttesting( $data, $box ) {         
        ?>

        <p>Main Developer: Ryan Bayne</p>
        
        <p>Supporting Developer: Olen Wunder</p>
                  
        <p>Currently testing post-boxes, three column layout option in Screen Options, dynamically generated help content
        which can be found in the Help tab and when clicking on Information icon in post-boxes. Those may not be seen
        on here for sometime. They were in the plugin, you will see them in current videos but they had to be removed
        pending completion of the new help content management tool on WebTechGlobal.</p>
        
        <p>More information and discussion about this test visit the <a href="http://forum.webtechglobal.co.uk/viewtopic.php?f=8&t=33">WebTechGlobal forum.</a></p>                                                                    
        
        <h4>The following work and tests are to be carried out...</h4>
        
        <ol>
            <li>Make the boxes on this screen, appear as widgets on the dashboard, without duplicating the code that makes the forms. As far as I know this has never been done in a plugin this advanced i.e. multiple pages with tab navigation on each, multiple views.</li>
            <li>Add a third column, with 3rd option in Screen Options to hide and display it.</li>
            <li>Possibly add the full width box as seen on dashboard.</li>
            <li>Re-add the information and video icons using the new help content management system.</li>
            <li>Ensure help content for the current page is displayed in the WP Help tab.</li>
        </ol>
        <?php                           
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest2_t1( $data, $box ) {  
  
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], 'Forms introduction text.', false );        
        $this->Forms->form_start( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">                  
            <?php 
            
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest2_t2( $data, $box ) {                                 
        ?>  

        <p>I have written a class called WTGTASKSMANAGER_Pointers. At first it seem to work. I was sure I tested the Dismiss and the
        pointer stayed hidden but it no longer works. I had to finish the class by passing parameters and since then pointers
        will not stay hidden. So the testing here is any changes intended to fix it. You should see a pointer below.</p>
        
        <p>Try this class https://github.com/rawcreative/wp-help-pointers/blob/master/class.wp-help-pointers.php however it is
        2 years old. It appears to do things the core already does i.e. checking user meta for closed pointers.</p>
        
        <p id="mypointer3"></p>
        
        <?php                    
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest2_t3( $data, $box ) {                                
  
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], 'Forms introduction text.', false );        
        $this->Forms->form_start( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">                  
            <?php 
            
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();                  
    } 
       
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest1_t4( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
        <?php                    
    }

    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest1_t5( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
        <?php                    
    }

    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest1_t6( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
        <?php                    
    }
 
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest1_t7( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
        <?php                    
    }

    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest1_t8( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
        <?php                    
    }

    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest1_t9( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
        <?php                    
    }

    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest1_t10( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
        <?php                    
    }       
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest2_errors( $data, $box ) {
        ?>
        
        <p>Errors and notices will be experienced in this area. They will show on your servers error log.
        Normally this will happen when you have visited beta testing pages. It does not means the plugin
        is faulty but you may report what you experience. Just keep in mind that some tests are setup for
        my blog and will fail on others unless you edit the PHP i.e. change post or category ID values to 
        match those in your own blog.</p>
        
        <?php 
    }        
}?>