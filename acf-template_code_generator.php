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
require_once( plugin_dir_path( __FILE__ ) . '/ACFTemplateCode.php' );

// add hooks
add_action( 'add_meta_boxes', 'add_acf_template_metaboxes' );

function add_acf_template_metaboxes() {
    add_meta_box( 'acf_template_code', 'ACF Template Code', 'acf_show_template_code', 'acf-field-group', 'normal', 'low' );
}

function acf_show_template_code() {
    global $post;
    
    $fields = acf_get_fields( $post->ID );

    echo "<textarea style='display:block; width:100%; height:500px; font-family:courier new' class='langauge-php'>";
    if( !empty( $fields ) ){
        foreach( $fields as $field ){
            $fieldTemplate = new ACFTemplateCode( $field );
            echo $fieldTemplate->get_code();
        }
    }
    echo "</textarea>";
}

