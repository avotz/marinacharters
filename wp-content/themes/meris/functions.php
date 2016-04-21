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

