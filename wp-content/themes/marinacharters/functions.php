<?php

define( 'MERIS_THEME_BASE_URL', get_template_directory_uri());
define( 'MERIS_OPTIONS_FRAMEWORK', get_template_directory().'/admin/' ); 
define( 'MERIS_OPTIONS_FRAMEWORK_URI',  MERIS_THEME_BASE_URL. '/admin/'); 
define('MERIS_OPTIONS_PREFIXED' ,'meris_');

/**
 * Required: include options framework.
 */
 
load_template( trailingslashit( get_template_directory() ) . 'admin/options-framework.php' );

/**
 * Theme setup
 */
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-setup.php' );

/**
 * Theme Functions
 */
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-functions.php' );

/**
 * Theme breadcrumb
 */
load_template( trailingslashit( get_template_directory() ) . 'includes/class-breadcrumb.php');
/**
 * Theme widget
 */
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-widget.php' );
/**
 * Theme Metabox
 */
 
load_template( trailingslashit( get_template_directory() ) . 'includes/metabox-options.php' );


add_filter( 'rwmb_meta_boxes', 'marinacharters_register_meta_boxes' );

function marinacharters_register_meta_boxes( $meta_boxes )
{

    $prefix = 'rw_';

    // 1st meta box
    $meta_boxes[] = array(
        'id'       => 'additional_information',
        'title'    => 'Información Adicional',
        'pages'    => array('page'),
        'context'  => 'normal',
        'priority' => 'high',

        'fields' => array(
            
             
             array(
                'name'  => 'Photos',
                'desc'  => 'Format: Image File',
                'id'    => $prefix . 'activity_photos',
                'type'  => 'image_advanced',
                'std'   => '',
                'class' => 'custom-class'
                
            ),
             array(
                'name'  => 'Prices',
                'id'    => $prefix . 'prices',
                'type'  => 'wysiwyg',
                'std'   => '',
                'class' => 'prices',
                'rows' => 6
                
                
            ),
              // OEMBED
            array(
              'name' => 'video',
              'id'   =>  $prefix. "video",
              'type' => 'oembed',
            ),
           
            
          
             

        )
    );


    return $meta_boxes;
}

/**
 * Trick for class to anchor menu
 * @param [type] $ulclass [description]
 */
function add_menuclass($ulclass) {
return preg_replace('/rel="anchor"/', 'class="anchor"', $ulclass, -1);
}
add_filter('wp_nav_menu','add_menuclass');

