<?php
/**
 * Beta Test 6 [page]   
 *
 * @package WTG Tasks Manager
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 0.0.1
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Beta Test 6 [class] 
 * 
 * @package WTG Tasks Manager
 * @subpackage Views
 * @author Ryan Bayne
 * @since 0.0.1
 */
class WTGTASKSMANAGER_Betatest6_View extends WTGTASKSMANAGER_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 0.0.1
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'betatest6';

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
            array( $this->view_name . '-currenttesting', __( 'Test Introduction', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'currenttesting' ), true, 'activate_plugins' ),
            
            // test forms
            array( $this->view_name . '-alpha', __( 'alpha', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'alpha' ), true, 'activate_plugins' ),
            array( $this->view_name . '-alphanumeric', __( 'alphanumeric', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'alphanumeric' ), true, 'activate_plugins' ),
            array( $this->view_name . '-numeric', __( 'numeric', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'numeric' ), true, 'activate_plugins' ),
            array( $this->view_name . '-urlstringtest', __( 'URL', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'urlstringtest' ), true, 'activate_plugins' ),
            array( $this->view_name . '-disabledhacked', __( 'Disabled Input Hacked', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'disabledhacked' ), true, 'activate_plugins' ),
            array( $this->view_name . '-menuhacked', __( 'Menu Hacked (new item added)', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'menuhacked' ), true, 'activate_plugins' ),
            array( $this->view_name . '-capability', __( 'Ensure User Is Permitted To Use form', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'capability' ), true, 'activate_plugins' ),
            array( $this->view_name . '-hiddenvaluehacked', __( 'Hidden Value Hack Test', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'hiddenvaluehacked' ), true, 'activate_plugins' ),
            array( $this->view_name . '-required', __( 'Required Input (may need hidden input)', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'required' ), true, 'activate_plugins' ),
            array( $this->view_name . '-maximumlength', __( 'Maximum String Length (string too long)', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'maximumlength' ), true, 'activate_plugins' ),
            array( $this->view_name . '-minimumlength', __( 'Minimum String Length (string too short)', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'minimumlength' ), true, 'activate_plugins' ),
            array( $this->view_name . '-specificpattern', __( 'Specific Pattern (regex)', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'specificpattern' ), true, 'activate_plugins' ),
            array( $this->view_name . '-checkboxesspecifictotal', __( 'Required Specific Number Of Checkboxes Checked', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'checkboxesspecifictotal' ), true, 'activate_plugins' ),
            array( $this->view_name . '-radiohacked', __( 'Radio Value Hack Test', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'radiohacked' ), true, 'activate_plugins' ),
            array( $this->view_name . '-shortfunctions', __( 'Short Functions', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'shortfunctions' ), true, 'activate_plugins' ),
            array( $this->view_name . '-currentvaluetests', __( 'Inputs With Current Values', 'wtgtasksmanager' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => 'currentvaluetests' ), true, 'activate_plugins' ),
  
            // common beta page information
            array( $this->view_name . '-guidelines', __( 'Development Guidelines', 'wtgtasksmanager' ), array( $this, 'parent' ), 'side', 'default', array( 'formid' => 'guidelines' ), true, 'activate_plugins' ),
            array( $this->view_name . '-warning', __( 'Alpha & Beta', 'wtgtasksmanager' ), array( $this, 'parent' ), 'side', 'default', array( 'formid' => 'warning' ), true, 'activate_plugins' ),
            array( $this->view_name . '-errors', __( 'Errors', 'wtgtasksmanager' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'errors' ), true, 'activate_plugins' ),
        );    
    }
        
    /**
    * Set up the view with data and do things that are specific for this view
    *
    * @author Ryan R. Bayne
    * @package WTG Tasks Manager
    * @since 0.0.11
    * @version 1.0
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
        $this->Forms = WTGTASKSMANAGER::load_class( 'WTGTASKSMANAGER_Formbuilder', 'class-forms.php', 'classes' );

        $forms = new WTGTASKSMANAGER_Formbuilder();

        parent::setup( $action, $data );
        
        // using array register many meta boxes
        foreach( self::meta_box_array() as $key => $metabox ) {
            // the $metabox array includes required capability to view the meta box
            if( isset( $metabox[7] ) && current_user_can( $metabox[7] ) ) {
                $this->add_meta_box( $metabox[0], $metabox[1], $metabox[2], $metabox[3], $metabox[4], $metabox[5] );   
            }               
        }        
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
    public function postbox_betatest6_currenttesting( $data, $box ) { ?>

        <p>Main Developer: Ryan Bayne</p>
        
        <p>Supporting Developer: Emmitt Roth</p>
               
        <p>The form builder class has two goals. The first is to speed up development. The second is to increase security for all forms especially
        during a faster development cycle. Only PHP and HTML is being used to build a very strict system. Later we can add JavaScript and HTML 5 for
        a more common layer or valdation.</p>
        
        <p>The tests below require most of the forms to be hacked. We view the source and edit it i.e. we can change the value of a hidden input. It is not
        hidden to those who know how to view it and as a developer it is my job to consider that the user may have done this.
        Right click on the page and select Inspect Element or View Source. Some browsers tools will only allow viewing but most now allow the source to
        be edited. Changes usually apply to the page straight away. If done right you can test each form as intended and see my security prevent the request
        to be processed. </p>
        
        <p>Development speed comes in the form of functions per input type. So rather than coding the HTML each time I made a form I just call on a range
        of functions. This approach is what allows extra security because the PHP functions being used can do more than output some HTML. I'm not going
        into detail about what they do because a) it's technical and b) I'll be providing subscriber only documentation for developers so that anyone can
        use the Wordpress Plugin WTG Tasks Manager with success.</p>
 
        <?php              
    }

    public function postbox_betatest6_alpha( $data, $box ) {   
        $introduction = __( 'Ensure entry is letters only. Enter numbers and submit to test. Try hacking too i.e. disable the field then submit.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
        
        $this->Forms->input( $box['args']['formid'], 'text', 'alphatest', 'alphatest', __( 'Alpha Test', 'wtgtasksmanager' ), __( 'Alpha Test', 'wtgtasksmanager' ), false, '', array(), array( 'alpha' => 0 ) );
                                  
        echo '</table>';
                         
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_alphanumeric( $data, $box ) {    
        $introduction = __( 'Ensure entry are letters or numbers, no special characters.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
       
        $this->Forms->input( $box['args']['formid'], 'text', 'alphanumerictest', 'alphanumerictest', __( 'Alphanumeric Test', 'wtgtasksmanager' ), __( 'Alpha-numeric Test', 'wtgtasksmanager' ), false, '', array(), array( 'alphanumeric' => 0 ) );

        echo '</table>';
                         
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_numeric( $data, $box ) {    
        $introduction = __( 'Ensure entry is numeric only.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
       
        $this->Forms->input( $box['args']['formid'], 'text', 'numerictest', 'numerictest', __( 'Numeric Test', 'wtgtasksmanager' ), __( 'Numeric Test', 'wtgtasksmanager' ), true, '', array(), array( 'numeric' => 0 ) );
        
        echo '</table>'; 
                         
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_urlstringtest( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Ensure entry is a URL.', 'wtgtasksmanager' ), false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
       
        $this->Forms->input( $box['args']['formid'], 'text', 'theurl', 'theurl', __( 'URL Test', 'wtgtasksmanager' ), __( 'URL Test', 'wtgtasksmanager' ), true, '', array(), array( 'url' => 0 ) );
        
        echo '</table>'; 
                         
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_disabledhacked( $data, $box ) {    
        $introduction = __( 'Add every input in disabled state, then hack them individually to make them enabled. Detect this and prevent request being processed. This security measure helps to detect hackers quickly. We can then suspend the users account.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
       
        $this->Forms->input( $box['args']['formid'], 'text', 'disabledtext', 'disabledtext', __( 'Disabled Text', 'wtgtasksmanager' ),__( 'Disabled Text', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'hidden', 'disabledhidden', 'disabledhidden', __( 'Disabled hidden', 'wtgtasksmanager' ), __( 'Disabled hidden', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'dateandtime', 'disableddateandtime', 'disableddateandtime', __( 'Disabled dateandtime', 'wtgtasksmanager' ), __( 'Disabled dateandtime', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'menu_cronhooks', 'disabledmenu_cronhooks', 'disabledmenu_cronhooks', __( 'Disabled menu_cronhooks', 'wtgtasksmanager' ), __( 'Disabled menu_cronhooks', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'menu_cronrepeat', 'disabledmenu_cronrepeat', 'disabledmenu_cronrepeat', __( 'Disabled menu_cronrepeat', 'wtgtasksmanager' ), __( 'Disabled menu_cronrepeat', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'menu_capabilities', 'disabledmenu_capabilities', 'disabledmenu_capabilities', __( 'Disabled menu_capabilities', 'wtgtasksmanager' ), __( 'Disabled menu_capabilities', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'file', 'disabledfile', 'disabledfile', __( 'Disabled file', 'wtgtasksmanager' ), __( 'Disabled file', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'radiogroup_postformats', 'disabledradiogroup_postformats', 'disabledradiogroup_postformats', __( 'Disabled radiogroup_postformats', 'wtgtasksmanager' ), __( 'Disabled radiogroup_postformats', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'radiogroup_posttypes', 'disabledradiogroup_posttypes', 'disabledradiogroup_posttypes', __( 'Disabled radiogroup_posttypes', 'wtgtasksmanager' ), __( 'Disabled radiogroup_posttypes', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'menu_categories', 'disabledmenu_categories', 'disabledmenu_categories', __( 'Disabled menu_categories', 'wtgtasksmanager' ), __( 'Disabled menu_categories', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'menu_users', 'disabledmenu_users', 'disabledmenu_users', __( 'Disabled menu_users', 'wtgtasksmanager' ), __( 'Disabled menu_users', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'checkbox_single', 'disabledcheckbox_single', 'disabledcheckbox_single', __( 'Disabled checkbox_single', 'wtgtasksmanager' ), __( 'Disabled checkbox_single', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'menu', 'disabledmenu', 'disabledmenu', __( 'Disabled menu', 'wtgtasksmanager' ), __( 'Disabled menu', 'wtgtasksmanager' ), false, '', array( 'disabled' => true, 'itemsarray' => array( 'itemone' => 'Item One', 'itemtwo' => 'Item Two' ) ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'textarea', 'disabledtextarea', 'disabledtextarea', __( 'Disabled textarea', 'wtgtasksmanager' ), __( 'Disabled textarea', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'radiogroup', 'disabledradiogroup', 'disabledradiogroup', __( 'Disabled radiogroup', 'wtgtasksmanager' ), __( 'Disabled radiogroup', 'wtgtasksmanager' ), false, '', array( 'disabled' => true, 'items' => array( 'itemone' => 'Item One', 'itemtwo' => 'Item Two' ) ), array( 'alpha' => 0 ) );
        $this->Forms->input( $box['args']['formid'], 'switch', 'disabledswitch', 'disabledswitch', __( 'Disabled switch', 'wtgtasksmanager' ), __( 'Disabled switch', 'wtgtasksmanager' ), false, '', array( 'disabled' => true ), array( 'alpha' => 0 ) );
                
        echo '</table>'; 
                         
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_menuhacked( $data, $box ) {    
        $introduction = __( 'Hack a menu by adding a new item to it, select that new item then submit. Ensure security detects this.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
        
        $items_array = array( 'scotland' => 'Scotland', 'france' => 'France', 'china' => 'China', 'holland' => 'Holland' );      
        $this->Forms->input( $box['args']['formid'], 'menu', 'hackedmenu', 'hackedmenu', __( 'Hacked Test', 'wtgtasksmanager' ), __( 'Hacked Test', 'wtgtasksmanager' ), true, '', array( 'itemsarray' => $items_array ), array( 'alpha' => 0 ) );
        
        echo '</table>';
                         
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_capability( $data, $box ) {    
        $introduction = __( 'Ensure user has capability for giving form, this should hide the form but this test needs to apply the security during processing as a backup.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo 'I have realized that is not required. It could be added but there is already optional security using capabilities
        which hides a form from being displayed in the first play. I considered the scenario where a users permissions are revoked
        while they are viewing a form already. The chances of that are slim. Also a single form submission from someone who used to have
        permission to submit that form is hardly a major issue.';
                         
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_hiddenvaluehacked( $data, $box ) {    
        $introduction = __( 'Hack a hidden input. Change the input name and detect it. Change the input value and detect that also. We need to prevent
        a user creating a hidden input possibly used elsewhere in a plugin and triggering something the current form was not intended to do.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
        
        echo '<table class="form-table">';
        
        $this->Forms->input( $box['args']['formid'], 'hidden', 'hiddenvaluetest', 'hiddenvaluetest', __( 'Hidden Value One', 'wtgtasksmanager' ), __( 'Hidden Value One', 'wtgtasksmanager' ), true, 'Ryan Bayne', array( 'required' => true ), array( 'alpha' => 0 ) );

        echo '</table>';
        
        echo '<p>The hidden value input has been added. Hack it. Remove it and change the value.</p>';
        
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_maximumlength( $data, $box ) {    
        $introduction = __( 'Maximum length of text field and add a textarea apply the same test to that.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
        
        echo '<table class="form-table">';
                                                                                                                                                    
        $this->Forms->input( $box['args']['formid'], 'text', 'alphatestmaxlength', 'alphatestmaxlength', __( 'Max Length', 'wtgtasksmanager' ), __( 'Max Length', 'wtgtasksmanager' ), true, '', array(), array( 'alpha' => 0, 'maxlength' => 5 ) );

        echo '</table>';           
        
        $this->UI->postbox_content_footer();
    }
    
    public function postbox_betatest6_required( $data, $box ) {    
        $introduction = __( 'Ensure a required field is used, not using HTML 5 but the $_POST processing.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
        
        $this->Forms->input( $box['args']['formid'], 'text', 'alphatestrequired', 'alphatestrequired', __( 'Required', 'wtgtasksmanager' ), __( 'Required', 'wtgtasksmanager' ), true, '', array(), array( 'alpha' => 0 ) );    
        
        echo '</table>';
               
        $this->UI->postbox_content_footer();
    }
    
    public function postbox_betatest6_minimumlength( $data, $box ) {    
        $introduction = __( 'Test minimum length validation on a text field and text area.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
        
        $this->Forms->input( $box['args']['formid'], 'text', 'alphatestminlength', 'alphatestminlength', __( 'Min Length', 'wtgtasksmanager' ), __( 'Min Length', 'wtgtasksmanager' ), true, '', array(), array( 'alpha' => 0, 'minlength' => 10 ) );

        echo '</table>';
                      
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_specificpattern( $data, $box ) {    
        $introduction = __( 'Apply regex test (abc-def-123).', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
       
        echo '<table class="form-table">';
        
        $this->Forms->input( $box['args']['formid'], 'text', 'textspecificpattern', 'textspecificpattern', __( 'Specific Pattern', 'wtgtasksmanager' ), __( 'Specific Pattern', 'wtgtasksmanager' ), true, '', array(), array( 'regex' => array( '/([a-zA-Z]{3}-[a-zA-Z]{3}-\d{3})/', 'abc-def-123') ) );
        
        echo '</table>'; 
                         
        $this->UI->postbox_content_footer();
    }

    public function postbox_betatest6_checkboxesspecifictotal( $data, $box ) {    
        $introduction = __( 'Enforce specific number of checks on submission. Try checking 1 or 3 to test a minimum of 2 and a maximum of 2.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
            
        echo '<table class="form-table">';
        
        $items = array( 'firstbox' => __( 'First Box', 'wtgtasksmanager' ), 'secondbox' => __( 'Second Box', 'wtgtasksmanager' ), 'thirdbox' => __( 'Third Box', 'wtgtasksmanager' ), 'fourthbox' => __( 'Fourth Box', 'wtgtasksmanager' ), 'fifthbox' => __( 'Fifth Box', 'wtgtasksmanager' ) );
        $currentvalue = array( 'secondbox', 'fourthbox' );
        $this->Forms->input( $box['args']['formid'], 'checkboxes', 'maximumcheckboxes', 'maximumcheckboxes', __( 'Two Checks Only', 'wtgtasksmanager' ), __( 'Two Checks Only', 'wtgtasksmanager' ), true, $currentvalue, array( 'minimumchecks' => 2, 'maximumchecks' => 2, 'itemsarray' => $items ) );    

        echo '</table>'; 
                         
        $this->UI->postbox_content_footer();
    }
    
    public function postbox_betatest6_radiohacked( $data, $box ) {    
        $introduction = __( 'Add another radio option, detect it on submission. Also edit the value of an existing radio and detect that on submission.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          

        echo '<table class="form-table">';
        
        $this->Forms->input( $box['args']['formid'], 'radiogroup', 'radiogroupaddanother', 'radiogroupaddanother', __( 'Add Radio Option', 'wtgtasksmanager' ), __( 'Add Radio Option', 'wtgtasksmanager' ), true, '', array( 'itemsarray' => array( 'firstradio' => __( 'First Radio', 'wtgtasksmanager' ), 'secondradio' => __( 'Second Radio', 'wtgtasksmanager' ), 'thirdradio' => __( 'Third Radio', 'wtgtasksmanager' ) ) ), array() );    

        echo '</table>'; 
        
        
        $this->UI->postbox_content_footer();
    }
    
    public function postbox_betatest6_autocomplete( $data, $box ) {    
        $introduction = __( 'Not sure what this test is going to do but explore what autocomplete="" attribute could allow by hack.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          

                   
        $this->UI->postbox_content_footer();
    }
      
    public function postbox_betatest6_shortfunctions( $data, $box ) {    
        $introduction = __( 'All inputs are built using input() but it is not suitable for new users of the wtgtasksmanager. This
        panel will display each type of input using a function based on common requirements i.e. id, name, value, title and the
        validation methods applicable', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );          
           
        
        echo '<table class="form-table">';

        // most basic range of input functions - common requirements
        $this->Forms->hidden_basic( $box['args']['formid'], 'hiddenbasic', 'hiddenbasic', 'a hidden value' );
        $this->Forms->dateandtime_basic( $box['args']['formid'], 'dateandtimebasic', 'dateandtimebasic', 'Data and Time' );
        $this->Forms->text_basic( $box['args']['formid'], 'textbasic', 'textbasic', 'Text Basic' ); 
        $this->Forms->menu_basic( $box['args']['formid'], 'menubasic', 'menubasic', 'Menu Basic', array( 'itemone' => 'Item One', 'itemtwo' => 'Item Two' ), true, '', array() );
        $this->Forms->file_basic( $box['args']['formid'], 'filebasic', 'filebasic', 'File Basic', true );
        $this->Forms->radiogroup_basic( $box['args']['formid'], 'radiogroupbasic', 'radiogroupbasic', 'Radiogroup Basic', array( 'itemone' => 'Item One', 'itemtwo' => 'Item Two' ), 'itemtwo', true, array() );
        $this->Forms->checkboxes_basic( $box['args']['formid'], 'checkboxesbasic', 'checkboxesbasic', 'Checkboxes Basic', array( 'itemone' => 'Item One', 'itemtwo' => 'Item Two', 'itemthree' => 'Item Three', 'itemfour' => 'Item four' ), array( 'itemthree' ), true, array() );
        $this->Forms->textarea_basic( $box['args']['formid'], 'textareabasic', 'textareabasic', 'Textarea Basic' );
        $this->Forms->switch_basic( $box['args']['formid'], 'switchbasic', 'switchbasic', 'Switch Basic', 'enabled', 'enabled', true );
                                                                     
        // more advanced i.e. HTML 5, ajax, no WP table markup
        $this->Forms->hidden_advanced( $box['args']['formid'], 'hiddenadvanced', 'hiddenadvanced', 'Advanced Hidden Inputs Title', 'hidden value string' );
        $this->Forms->dateandtime_advanced( $box['args']['formid'], 'dateandtimeadvanced', 'dateandtimeadvanced', 'Date and Time Advanced' );
        $this->Forms->text_advanced( $box['args']['formid'], 'textadvanced', 'textadvanced', 'Text Advanced' ); 
        $this->Forms->menu_advanced( $box['args']['formid'], 'menuadvanced', 'menuadvanced', 'Menu Advanced', 'english', array( 'maths' => __( 'Maths', 'wtgtasksmanager' ), 'english' => __( 'English', 'wtgtasksmanager' ), 'science' => __( 'Science', 'wtgtasksmanager' ), 'geography' => __( 'Geography', 'wtgtasksmanager' ) ) );
        $this->Forms->file_advanced( $box['args']['formid'], 'fileadvanced', 'fileadvanced', 'File Advanced' );
        $this->Forms->radiogroup_advanced( $box['args']['formid'], 'radiogroupadvanced', 'radiogroupadvanced', 'Radiogroup Advanced', 'starcitizen', array( 'arenacommander' => __( 'Arena Commander', 'wtgtasksmanager' ), 'starcitizen' => __( 'Star Citizen', 'wtgtasksmanager' ), 'squadron42' => __( 'Squadron 42', 'wtgtasksmanager' ) ) ); 
        $this->Forms->checkboxes_advanced( $box['args']['formid'], 'checkboxesadvanced', 'checkboxesadvanced', 'Checkboxes Advanced', array( 'itemone' => 'Item One', 'itemtwo' => 'Item Two' ), array( 'itemtwo' ) );
        $this->Forms->textarea_advanced( $box['args']['formid'], 'textareaadvanced', 'textareaadvanced', 'Textarea Advanced' );
        $this->Forms->switch_advanced( $box['args']['formid'], 'switchadvanced', 'switchadvanced', 'Switch Advanced' );
            
        echo '</table>';           
               
        $this->UI->postbox_content_footer();
    }

    /**
    * post box function for testing inputs with current values
    * 
    * @author Ryan Bayne
    * @package WTG Tasks Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_betatest6_currentvaluetests( $data, $box ) {    
        $introduction = __( 'Inputs with all possible HTML 5 functionality, later I will setup options to apply specific HTML 5 behaviours.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'], $box );          
       
        echo '<table class="form-table">';

        // most basic range of input functions - common requirements
        $this->Forms->dateandtime_basic( $box['args']['formid'], 'dateandtimecurval', 'dateandtimecurval', 'Data and Time' );
        $this->Forms->text_basic( $box['args']['formid'], 'textcurval', 'textcurval', 'Text Basic', __( 'This is a default value.', 'wtgtasksmanager' ) ); 
        $this->Forms->menu_basic( $box['args']['formid'], 'menucurval', 'menucurval', 'Menu Basic', array( 'itemone' => 'Item One', 'itemtwo' => 'Item Two' ) );
        $this->Forms->file_basic( $box['args']['formid'], 'filecurval', 'filecurval', 'File Basic' );
        $this->Forms->radiogroup_basic( $box['args']['formid'], 'radiogroupcurval', 'radiogroupcurval', 'Radiogroup Basic', array( 'ryan' => 'Ryan', 'zara' => 'Zara' ), 'zara', true, array() );
        $this->Forms->checkboxes_basic( $box['args']['formid'], 'checkboxescurval', 'checkboxescurval', 'Checkboxes Basic', array( 'summer' => 'Summer', 'keira' => 'Keira' ), array( 'summer' ), true, array() );
        $this->Forms->textarea_basic( $box['args']['formid'], 'textareacurval', 'textareacurval', 'Textarea Basic', __( 'This is a default value.', 'wtgtasksmanager' ) );
        $this->Forms->switch_basic( $box['args']['formid'], 'switchcurval', 'switchcurval', 'Switch Basic' );
                                                                     
        // more advanced i.e. HTML 5, ajax, no WP table markup
        $this->Forms->dateandtime_advanced( $box['args']['formid'], 'dateandtimecurvaladv', 'dateandtimecurvaladv', 'Date and Time Advanced' );
        $this->Forms->text_advanced( $box['args']['formid'], 'textcurvaladv', 'textcurvaladv', 'Text Advanced', __( 'This is a default value.', 'wtgtasksmanager' ) ); 
        $this->Forms->menu_advanced( $box['args']['formid'], 'menucurvaladv', 'menucurvaladv', 'Menu Advanced', 'horse', array( 'sheep' => __( 'Sheep', 'wtgtasksmanager' ), 'horse' => __( 'Horse', 'wtgtasksmanager' ), 'cow' => __( 'Cow', 'wtgtasksmanager' ) ) );
        $this->Forms->file_advanced( $box['args']['formid'], 'filecurvaladv', 'filecurvaladv', 'File Advanced' );
        $this->Forms->radiogroup_advanced( $box['args']['formid'], 'radiogroupcurvaladv', 'radiogroupcurvaladv', 'Radiogroup Advanced', 'pink', array( 'blue' => 'Blue', 'purple' => 'Purple', 'pink' => 'Pink', 'yellow' => 'Yellow' ) ); 
        $this->Forms->checkboxes_advanced( $box['args']['formid'], 'checkboxescurvaladv', 'checkboxescurvaladv', 'Checkboxes Advanced', array( 'grapes' => 'Grapes', 'pear' => 'Pear' ), array( 'pear' ) );
        $this->Forms->textarea_advanced( $box['args']['formid'], 'textareacurvaladv', 'textareacurvaladv', 'Textarea Advanced', __( 'This is a default value.', 'wtgtasksmanager' ) );
        $this->Forms->switch_advanced( $box['args']['formid'], 'switchcurvaladv', 'switchcurvaladv', 'Switch Advanced' );
            
        echo '</table>'; 
                         
        $this->UI->postbox_content_footer();
    }
            
    ###############################################################
    #                                                             #
    #                     COMMON BETA PAGE INFORMATION            #
    #                                                             #
    ###############################################################    
    public function postbox_betatest6_errors( $data, $box ) {
        ?>
        
        <p>Errors and notices will be experienced in this area. They will show on your servers error log.
        Normally this will happen when you have visited beta testing pages. It does not means the plugin
        is faulty but you may report what you experience. Just keep in mind that some tests are setup for
        my blog and will fail on others unless you edit the PHP i.e. change post or category ID values to 
        match those in your own blog.</p>
        
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
    public function postbox_betatest6_guidelines( $data, $box ) {
        ?>
        
        <p>Do not make changes to a metabox already marked with "COMPLETE". We need to keep simplier test as they are for re-testing
        early functions as newer tests use them. Possibly resulting in changes being made and breaking older functionality.
        Please copy and paste the metabox to create a new one then work on that.</p>
        
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
    public function postbox_betatest6_warning( $data, $box ) {
        ?>
        
        <p>Some tests may be ALPHA and not BETA. The beta term is simply more recognized. In either case
        you should not copy and paste the form or processing function into a live environment. None of the
        code here is considered finished and I myself will work on it again when putting it on the live pages.</p>
        
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
    public function postbox_betatest6_empty( $data, $box ) {    
        $introduction = __( 'Do not use this box, it allows multiple entries to meta box array without making the boxes.', 'wtgtasksmanager' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'], $box );          
       
 
                         
        $this->UI->postbox_content_footer();
    }
         
}?>