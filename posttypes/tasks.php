<?php
/** 
* Tasks Post Type 
* 
* I've considered storing tasks in a stand alone table and could do that if there is a demand so let me know. The 
* advantage to have the tasks as post type is for anyone wishing to turn a blog into a project management environment
* with blog categories and full integration with other plugins.
* 
* @package WTG Tasks Manager
* @author Ryan Bayne   
* @since 0.0.1
*/

// load in WordPress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );   
                   
add_action( 'init', 'register_customposttype_wtgtasks' );   
add_action( 'save_post', 'save_meta_boxes_wtgtasks', 10, 2 );
add_action( 'add_meta_boxes', 'add_meta_boxes_wtgtasks' );   
             
/**
* REPLACEABOUT
* 
* @author Ryan R. Bayne
* @package WordPress Plugin Framework Pro
* @since 0.0.1
* @version 1.0
*/
function register_customposttype_wtgtasks() {
    $labels = array(
        'name' => _x( 'Task Posts', 'Post type for WebTechGlobal Tasks plugin' ),
        'singular_name' => _x( 'Task Post', 'Task post type for WebTechGlobal Tasks plugin' ),
        'add_new' => _x( 'New Task', 'wtgtasks' ),
        'add_new_item' => __( 'Create Task' ),
        'edit_item' => __( 'Edit Task' ),
        'new_item' => __( 'Create Task' ),
        'all_items' => __( 'All Tasks' ),
        'view_item' => __( 'View Task' ),
        'search_items' => __( 'Search Tasks' ),
        'not_found' =>  __( 'No tasks found' ),
        'not_found_in_trash' => __( 'No tasks found in Trash' ), 
        'parent_item_colon' => '',
        'menu_name' => __( 'Task Posts', 'wtgtasksmanager' )
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 100,
        'supports' => array( 'title', 'editor', 'custom-fields' )
    );   

    register_post_type( 'wtgtasks', $args );    
} 

/**
* Optional keywords for task.
* 
* @author Ryan R. Bayne
* @package WTG Tasks Manager
* @since 0.0.1
* @version 1.0
*/
function keywords_taxonomy_for_tasksmanager() {
    $labels = array(
        'name'                       => _x( 'Task Keywords', 'taxonomy general name' ),
        'singular_name'              => _x( 'Keyword', 'taxonomy singular name' ),
        'search_items'               => __( 'Search Keywords' ),
        'popular_items'              => __( 'Popular Keywords' ),
        'all_items'                  => __( 'All Keywords' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Keyword' ),
        'update_item'                => __( 'Update Keyword' ),
        'add_new_item'               => __( 'Add New Keyword' ),
        'new_item_name'              => __( 'New Keyword' ),
        'separate_items_with_commas' => __( "Enter keywords separated by commas." ),
        'add_or_remove_items'        => __( 'Add or remove keywords' ),
        'choose_from_most_used'      => __( 'Choose from the most used keywords' ),
        'not_found'                  => __( 'No keywords found.' ),
        'menu_name'                  => __( 'Keywords' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'tasksmanagerkeywords' ),
    );

    register_taxonomy( 'wtgtaskmanagerkeywords', 'wtgtasks', $args );
}add_action( 'init', 'keywords_taxonomy_for_tasksmanager', 0 );

function custom_post_status_wtgtasks_new(){
     register_post_status( 'newtask', array(
          'label'                     => _x( 'New', 'wtgtasksmanager' ),
          'public'                    => false,
          'show_in_admin_all_list'    => false,
          'show_in_admin_status_list' => true,
          'label_count'               => _n_noop( 'New <span class="count">(%s)</span>', 'New <span class="count">(%s)</span>' )
     ) );
}
add_action( 'init', 'custom_post_status_wtgtasks_new' );

function custom_post_status_wtgtasks_started(){
     register_post_status( 'startedtask', array(
          'label'                     => _x( 'Started', 'post' ),
          'public'                    => false,
          'show_in_admin_all_list'    => false,
          'show_in_admin_status_list' => true,
          'label_count'               => _n_noop( 'Started <span class="count">(%s)</span>', 'Started <span class="count">(%s)</span>' )
     ) );
}
add_action( 'init', 'custom_post_status_wtgtasks_started' );

function custom_post_status_wtgtasks_finished(){
     register_post_status( 'finishedtask', array(
          'label'                     => _x( 'Finished', 'post' ),
          'public'                    => false,
          'show_in_admin_all_list'    => false,
          'show_in_admin_status_list' => true,
          'label_count'               => _n_noop( 'Finished <span class="count">(%s)</span>', 'Finished <span class="count">(%s)</span>' )
     ) );
}
add_action( 'init', 'custom_post_status_wtgtasks_finished' );


function custom_post_status_wtgtasks_closed(){
     register_post_status( 'closedtask', array(
          'label'                     => _x( 'Closed', 'post' ),
          'public'                    => false,
          'show_in_admin_all_list'    => false,
          'show_in_admin_status_list' => true,
          'label_count'               => _n_noop( 'Closed <span class="count">(%s)</span>', 'Closed <span class="count">(%s)</span>' )
     ) );
}
add_action( 'init', 'custom_post_status_wtgtasks_closed' );


function custom_post_status_wtgtasks_cancelled(){
     register_post_status( 'cancelledtask', array(
          'label'                     => _x( 'Cancelled', 'post' ),
          'public'                    => false,
          'show_in_admin_all_list'    => false,
          'show_in_admin_status_list' => true,
          'label_count'               => _n_noop( 'Cancelled <span class="count">(%s)</span>', 'Cancelled <span class="count">(%s)</span>' )
     ) );
}
add_action( 'init', 'custom_post_status_wtgtasks_cancelled' );


function projecttaskmanager_append_post_status_list(){
    global $post;
    if( $post->post_type == 'wtgtasks' ){
        
        // New (newtask)
        $complete = '';
        $label = '';   
        
        if( $post->post_status == 'newtask' ){
            $complete = ' selected=\"selected\"';
            $label = '<span id=\"post-status-display\"> New</span>';
        }

        echo '<script>
        jQuery(document).ready(function($){
        $("select#post_status").append("<option value=\"newtask\" '.$complete.'>New</option>");
        $(".misc-pub-section label").append("'.$label.'");
        });
        </script>';

        // Started (startedtask)
        $complete = '';
        $label = '';    
                       
        if( $post->post_status == 'startedtask' ){
            $complete = ' selected=\"selected\"';
            $label = '<span id=\"post-status-display\"> Started</span>';
        }
        
        echo '<script>
        jQuery(document).ready(function($){
        $("select#post_status").append("<option value=\"startedtask\" '.$complete.'>Started</option>");
        $(".misc-pub-section label").append("'.$label.'");
        });
        </script>';        
        
        // Finished (finishedtask)
        $complete = '';
        $label = '';  
        
        if( $post->post_status == 'finishedtask' ){
            $complete = ' selected=\"selected\"';
            $label = '<span id=\"post-status-display\"> Finished</span>';
        }
        
        echo '<script>
        jQuery(document).ready(function($){
        $("select#post_status").append("<option value=\"finishedtask\" '.$complete.'>Finished</option>");
        $(".misc-pub-section label").append("'.$label.'");
        });
        </script>';
        
        // Closed (closedtask)
        $complete = '';
        $label = '';
                
        if( $post->post_status == 'closedtask' ){
            $complete = ' selected=\"selected\"';
            $label = '<span id=\"post-status-display\"> Closed</span>';
        }
        
        echo '<script>
        jQuery(document).ready(function($){
        $("select#post_status").append("<option value=\"closedtask\" '.$complete.'>Closed</option>");
        $(".misc-pub-section label").append("'.$label.'");
        });
        </script>';
        
        // Cancelled (cancelledtask)
        $complete = '';
        $label = '';
                
        if( $post->post_status == 'cancelledtask' ){
            $complete = ' selected=\"selected\"';
            $label = '<span id=\"post-status-display\"> Cancelled</span>';
        }

        echo '<script>
        jQuery(document).ready(function($){
        $("select#post_status").append("<option value=\"cancelledtask\" '.$complete.'>Cancelled</option>");
        $(".misc-pub-section label").append("'.$label.'");
        });
        </script>';
 
        $complete = '';
    }
}add_action('admin_footer-post.php', 'projecttaskmanager_append_post_status_list');

/**
* Change the post data or respond to inputs.
* 
* @author Ryan R. Bayne
* @package WordPress Plugin Framework Pro
* @since 0.0.1
* @version 1.0
*/
function wtg_post_change_save( $data, $postarr ) {  
    // if no post ID - return
    if ( ! isset($postarr['ID']) || ! $postarr['ID'] ) { 
        return $data;
    }
  
    // apply to wtgtasks post type only - else return
    if ( $postarr['post_type'] != 'wtgtasks' ) {
        return $data;
    }
  
    // apply users selected status if it is a custom one

  /*
    $old = get_post($postarr['ID']); // the post before update
    if (
        $old->post_status != 'incomplete' &&
        $old->post_status != 'trash' && // without this post restoring from trash fail
        $data['post_status'] == 'publish' 
    ) {
        // force a post to be setted as incomplete before be pubblished
        $data['post_status'] == 'incomplete';
    }
    */
    
    return $data;
}
//add_filter( 'wp_insert_post_data', 'wtg_post_change_save', 10, 2 );


/**
* Save flag meta box's
* 
* @param mixed $post_id
* @param mixed $post
*/
function save_meta_boxes_wtgtasks( $post_id, $post ) {

    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST['wtgtasksnonce'] ) || !wp_verify_nonce( $_POST['wtgtasksnonce'], basename( __FILE__ ) ) )    
        return $post_id;
        
    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
                                        
    // check permissions
    if ( (key_exists( 'post_type', $post) ) && ( 'page' == $post->post_type) ) {
        if (!current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }        

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
        return $post_id;
    }

    // array of custom meta fields - used in nonce security on a per field basis
    $flagmeta_array = array( 'taskstatus' );

    // loop through our terms and meta functions
    foreach( $flagmeta_array as $key => $term ){  
        $new_meta_value = '';
         
        /* Get the meta key. */
        $meta_key = '_wtgtasks_' . $term;

        if( isset( $_POST['wtgtasks_'.$term] ) ){
            $new_meta_value = $_POST['wtgtasks_'.$term];    
        }
        
        /* Get the meta value of the custom field key. */
        $meta_value = get_post_meta( $post_id, $meta_key, true );

        if ( $new_meta_value && '' == $meta_value ){
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );# new meta value was added and there was no previous value
        }elseif ( $new_meta_value && $new_meta_value != $meta_value ){
            update_post_meta( $post_id, $meta_key, $new_meta_value );# new meta value does not match the old value, update it
        }elseif ( '' == $new_meta_value && $meta_value ){
            delete_post_meta( $post_id, $meta_key, $meta_value );# no new meta value but an old value exists, delete it
        }
    }
} 

function add_meta_boxes_wtgtasks() {
    // start task
    /* add_meta_box(
        'wtgtasks-meta-starttask',// form id            
        esc_html__( 'Start Task' ),// meta box title       
        'metabox_wtgtasks_starttask',// function name        
        'wtgtasks',                  
        'side',                 
        'default'                  
    );  */
}

// start task meta box
function metabox_wtgtasks_starttask( $object, $box ) { 
    
    ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'wtgtasks_starttasknonce' ); ?>
    <p>
        <input class="widefat" type="text" name="wtgtasks_starttask" id="starttask" value="<?php echo esc_attr( get_post_meta( $object->ID, '_wtgtasks_starttask', true ) ); ?>" size="30" />
    </p><?php 
}
?>