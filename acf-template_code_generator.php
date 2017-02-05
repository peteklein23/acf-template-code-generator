<?php
/**
 * @package ACF_Template_Code_Generator
 * @version 1.0
 */
/*
Plugin Name: Advanced Custom Fields: Template Code Generator
Plugin URI: http://peteklein.com/
Description: Creates the the base template code for an entire advanced custom field group.
Author: Pete Klein
Version: 1.0
Author URI: http://peteklein.com
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

    // include classes
    require_once( dirname( __FILE__ ) . '/ACFTemplateCode.php' );


    add_action( 'add_meta_boxes', 'add_events_metaboxes' );

    // Add the Events Meta Boxes

    function add_events_metaboxes() {
        add_meta_box( 'acf_template_code', 'ACF Template Code', 'acf_show_template_code', 'acf-field-group', 'normal', 'low' );
    }


    // The Event Location Metabox

    function acf_show_template_code() {
        global $post;
        
        $fields = acf_get_fields( $post->ID );

        echo "<textarea style='display:block; width:100%; height:500px; font-family:courier new'>";
        if( !empty( $fields ) ){
            foreach( $fields as $field ){
                $fieldTemplate = new ACFTemplateCode( $field );
                echo $fieldTemplate->get_code();
            }
        }
        echo "</textarea>";

        /*

        // Noncename needed to verify where the data originated
        echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
        
        // Get the location data if its already been entered
        $location = get_post_meta($post->ID, '_location', true);
        
        // Echo out the field
        echo '<input type="text" name="_location" value="' . $location  . '" class="widefat" />';*/

    }


?>
