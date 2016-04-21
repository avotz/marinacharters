<?php

add_action('init', 'meris_custom_init');
function meris_custom_init() {
	add_post_type_support( 'page', 'excerpt' );
}

function meris_admin_init(){
	
	if(isset($_POST['widget-area']) && is_array($_POST['widget-area'])){
	$meris_list_item = json_encode($_POST['widget-area']);
	update_option("_meris_home_widget_area",$meris_list_item );
	}

if ( isset( $_POST['reset'] ) ) {
	 $output = array();
 $location = apply_filters( 'options_framework_location', array('admin-options.php') );

	        if ( $optionsfile = locate_template( $location ) ) {
	            $maybe_options = require_once $optionsfile;
	            if ( is_array( $maybe_options ) ) {
					$options = $maybe_options;
	            } else if ( function_exists( 'optionsframework_options' ) ) {
					$options = optionsframework_options();
				}
	        }
			
		if(isset($options)){
			$config  =  $options;
			foreach ( (array) $config as $option ) {
			
				if(isset($option['id']) && $option['id']=='home_page_sections'){
					update_option("_meris_home_widget_area",$option['std'] );
					}
				}
			
		}

		}
	
	}
	
	add_action('admin_init', 'meris_admin_init');

function meris_tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

add_action('pre_get_posts', 'meris_tags_support_query');

function meris_setup(){
	global $content_width;
	$lang = get_template_directory(). '/languages';
	load_theme_textdomain('meris', $lang);
	add_theme_support( 'post-thumbnails' ); 
	$args = array();
	$header_args = array( 
	    'default-image'          => get_template_directory_uri().'/images/banner-1.jpg',
		'default-repeat' => 'no-repeat',
        'default-text-color'     => 'fff',
		'url'                    => get_template_directory_uri().'/images/banner-1.jpg',
        'width'                  => 1920,
        'height'                 => 105,
        'flex-height'            => true
     );
	add_theme_support( 'custom-background', $args );
	add_theme_support( 'custom-header', $header_args );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('nav_menus');
	add_theme_support( "title-tag" );
	register_nav_menus( array('primary' => __( 'Primary Menu', 'meris' )));
	add_editor_style("editor-style.css");
	add_image_size( 'portfolio', 800, 600 , true);  
	add_image_size( 'side-slider', 700, 400 , true);
	if ( !isset( $content_width ) ) $content_width = 1170;
}

add_action( 'after_setup_theme', 'meris_setup' );


 function meris_custom_scripts(){
	 global $is_IE;
	wp_enqueue_style('meris-bootstrap',  get_template_directory_uri() .'/css/bootstrap.css', false, '4.0.3', false);
    wp_enqueue_style('meris-font-awesome',  get_template_directory_uri() .'/css/font-awesome.min.css', false, '4.0.3', false);

	wp_enqueue_style( 'meris-main', get_stylesheet_uri(), array(), '1.0.4' );
	
	wp_enqueue_style('meris-scheme', get_template_directory_uri().'/css/scheme.less', false, '1.0.0', false);
	wp_enqueue_style('montserrat', esc_url('//fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:300,400,700'), false, '', false );
	
   $header_image      = get_header_image();

   $header_background = ""  ;
   $meris_custom_css = "";
	if (isset($header_image) && ! empty( $header_image )) {
	$meris_custom_css .= ".blog-list-page header{background:url(".$header_image. ") no-repeat;}\n";
	}
    if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() ){
     $header_background  .=  ' color:#' . get_header_textcolor() . ';';
	 $meris_custom_css .=  '.header-wrapper header .name-box .site-name,.header-wrapper header .name-box .site-tagline {'.$header_background.'}';
		}
	$custom_css           =  meris_options_array("custom_css");
	
	$meris_custom_css  .=  $custom_css;
	
	wp_add_inline_style( 'meris-main', $meris_custom_css );
	
	$global_color           =  meris_options_array("global_color");

	wp_enqueue_script( 'meris-bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array( 'jquery' ), '3.0.3', false );
	wp_enqueue_script( 'meris-less', get_template_directory_uri().'/js/less.min.js', array( 'jquery' ), '1.4.2', false );
	wp_enqueue_script( 'meris-respond', get_template_directory_uri().'/js/respond.min.js', array( 'jquery' ), '1.4.2', false );
	wp_enqueue_script( 'meris-main', get_template_directory_uri().'/js/meris.js', array( 'jquery' ), '1.0.4', false );
	wp_enqueue_script( 'meris-modernizr', get_template_directory_uri().'/js/modernizr.custom.js', array( 'jquery' ), '2.8.2', false );
	
	if(isset($global_color) && $global_color != ""){
	 wp_localize_script( 'meris-less', 'meris_js_var', array("global_color"=>$global_color));
	}
	
	if( $is_IE ) {
	wp_enqueue_script( 'meris-html5', get_template_directory_uri().'/js/html5.js', array( 'jquery' ), '', false );
	}
	
		wp_localize_script( 'meris-main', 'meris_params',  array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl' => MERIS_THEME_BASE_URL,
		)  );
		
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){wp_enqueue_script( 'comment-reply' );}
	}

   if (!is_admin()) {
  add_action( 'wp_enqueue_scripts', 'meris_custom_scripts' );
  }




function meris_of_get_option($name, $default = false) {
	
	$optionsframework_settings = get_option('optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
		
	}
}

function meris_of_get_options($default = false) {
	
	$optionsframework_settings = get_option('optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options) ) {
		return $options;
	} else {
		return $default;
	}
}

global $meris_options;
$meris_options = meris_of_get_options();


function meris_options_array($name){
	global $meris_options;
	if(isset($meris_options[$name]))
	return $meris_options[$name];
	else
	return "";
}
// set default options
function meris_on_switch_theme(){
global $meris_options;
 $optionsframework_settings = get_option( 'optionsframework' );
 if(!get_option($optionsframework_settings['id'])){
 $config = array();
 $output = array();
 $location = apply_filters( 'options_framework_location', array('admin-options.php') );

	        if ( $optionsfile = locate_template( $location ) ) {
	            $maybe_options = require_once $optionsfile;
	            if ( is_array( $maybe_options ) ) {
					$options = $maybe_options;
	            } else if ( function_exists( 'optionsframework_options' ) ) {
					$options = optionsframework_options();
				}
	        }
	
		if(isset($options)){
	    $options = apply_filters( 'of_options', $options );
		$config  =  $options;
		foreach ( (array) $config as $option ) {
			if ( ! isset( $option['id'] ) ) {
				continue;
			}
			if ( ! isset( $option['std'] ) ) {
				continue;
			}
			if ( ! isset( $option['type'] ) ) {
				continue;
			}
				$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
		}
		}
		add_option($optionsframework_settings['id'],$output);
		
	
				
}
	//Free version home page sections
	 if(!get_option( '_meris_home_widget_area' )){
			 
			 	$sections_json = '{"section-widget-area-name":["Home Page Secion One","Home Page Secion Two","Home Page Secion Three","Home Page Secion Four"],"list-item-color":["","","",""],"list-item-image":["","","","'.esc_url(MERIS_THEME_BASE_URL.'/images/background-1.jpg').'"],"list-item-repeat":["","","","no-repeat"],"list-item-position":["","","",""],"list-item-attachment":["","","",""],"widget-area-layout":["boxed","full","boxed","boxed"],"widget-area-padding":["50","50","50","50"],"widget-area-column":["1","1","1","2"],"widget-area-column-item":{"home-page-secion-one":["12"],"home-page-secion-two":["12"],"home-page-secion-three":["12"],"home-page-secion-four":["6","6"]}}';

			
			add_option('_meris_home_widget_area' ,$sections_json);
			 
			 }
$meris_options = meris_of_get_options();
}
add_action( 'after_setup_theme', 'meris_on_switch_theme' );
add_action('after_switch_theme', 'meris_on_switch_theme');

		

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'meris_optionsframework_custom_scripts');

function meris_optionsframework_custom_scripts() { 

}

add_filter('options_framework_location','meris_options_framework_location_override');

function meris_options_framework_location_override() {
	return array('includes/admin-options.php');
}

function meris_optionscheck_options_menu_params( $menu ) {
	
	$menu['page_title'] = __( 'Meris ( Lite ) Options', 'meris');
	$menu['menu_title'] = __( 'Meris ( Lite ) Options', 'meris');
	$menu['menu_slug'] = 'meris-options';
	return $menu;
}
add_filter( 'optionsframework_menu', 'meris_optionscheck_options_menu_params' );

/*function meris_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( ' Page %s ', 'meris' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'meris_wp_title', 10, 2 );*/


  function meris_title( $title ) {
  if ( $title == '' ) {
  return __( 'Untitled', 'meris' );
  } else {
  return $title;
  }
  }
  add_filter( 'the_title', 'meris_title' );


if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function meris_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'meris_slug_render_title' );
}



  if(isset($_POST['meris-list-item']) && is_array($_POST['meris-list-item'])){
	  $meris_list_item = json_encode($_POST['meris-list-item']);
	  update_option("meris_home_widget",$meris_list_item );
	  }
  
  if ( isset( $_POST['reset'] ) ) {
	   $output = array();
   $location = apply_filters( 'options_framework_location', array('admin-options.php') );

	        if ( $optionsfile = locate_template( $location ) ) {
	            $maybe_options = require_once $optionsfile;
	            if ( is_array( $maybe_options ) ) {
					$options = $maybe_options;
	            } else if ( function_exists( 'optionsframework_options' ) ) {
					$options = optionsframework_options();
				}
	        }
			//print_r($options);
		if(isset($options)){
			$config  =  $options;
			foreach ( (array) $config as $option ) {
			
				if(isset($option['id']) && $option['id']=='home_widget'){
					update_option("meris_home_widget",$option['std'] );
					}
				}
			
		}

		}
		
    add_action( 'wp_head', 'meris_favicon' );

	function meris_favicon()
	{
	    $url =  meris_options_array('favicon');
	
		$icon_link = "";
		if($url)
		{
			$type = "image/x-icon";
			if(strpos($url,'.png' )) $type = "image/png";
			if(strpos($url,'.gif' )) $type = "image/gif";
		
			$icon_link = '<link rel="icon" href="'.esc_url($url).'" type="'.$type.'">';
		}
		
		echo $icon_link;
	}