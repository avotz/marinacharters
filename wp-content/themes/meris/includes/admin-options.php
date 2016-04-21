<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	$optionsframework_settings = get_option('optionsframework');
	
	// Edit 'options-theme-customizer' and set your own theme name instead
	$optionsframework_settings['id'] = 'options_theme_customizer';
	update_option('optionsframework', $optionsframework_settings);
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Background Defaults
	
	$page_background = array(
		'color' => '',
		'image' => '',
		'repeat' => 'no-repeat',
		'position' => 'top left',
		'attachment'=>'fixed' );

	$options      = array();
	$social_icons = array('fa fa-facebook'=>'facebook',
						  'fa fa-flickr'=>'flickr',
						  'fa fa-google-plus'=>'google plus',
						  'fa fa-linkedin'=>'linkedin',
						  'fa fa-pinterest'=>'pinterest',
						  'fa fa-twitter'=>'twitter',
						  'fa fa-tumblr'=>'tumblr',
						  'fa fa-digg'=>'digg',
						  'fa fa-rss'=>'rss',
						 
						  );
   // HEADER
	$options[] = array(
		'name' => __('General Options', 'meris'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Upload Logo', 'meris'),
		'id' => 'logo',
		'std' => '',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Favicon', 'meris'),
		'desc' => sprintf(__('An icon associated with a URL that is variously displayed, as in a browser\'s address bar or next to the site name in a bookmark list. Learn more about <a href="%s" target="_blank">Favicon</a>', 'meris'),esc_url("http://en.wikipedia.org/wiki/Favicon")),
		'id' => 'favicon',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Global Color', 'meris'),
		'id' => 'global_color',
		'std' => '#FED136',
		'type' => 'color');
	
	$options[] = array(
		'name' => __('404 Page Content', 'meris'),
		'id' => 'page_404_content',
		'std' => '<i class="fa fa-frown-o"></i>
		<p><strong>OOPS!</strong> Can\'t find the page.</p>',
		'type' => 'editor');
		
	$options[] = array(
		'name' => __('Custom CSS', 'meris'),
		'desc' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'meris'),
		'id' => 'custom_css',
		'std' => 'body{margin:0px;}',
		'type' => 'textarea');

		
		////widget items
		//free version
		$options[] = array(
		'name' => __('Home Page', 'meris'),
		'type' => 'heading');
		
		$options[] = array(
		'name' => __('Enable Home Page Layout', 'meris'),
		'desc' => sprintf(__('Active custom home page layout.  The standardized way of creating Static Front Pages: <a href="%s" target="_blank">Creating a Static Front Page</a>', 'meris'),esc_url('http://codex.wordpress.org/Creating_a_Static_Front_Page')),
		'id' => 'enable_home_page',
		'std'=>'',
		'type' => 'checkbox');
		
		$options[] = array(
		'name' => __('Home Page Sections', 'meris'),
		'id' => 'home_page_sections',
		'std' => '{"section-widget-area-name":["Home Page Secion One","Home Page Secion Two","Home Page Secion Three","Home Page Secion Four"],"list-item-color":["","","",""],"list-item-image":["","","","'.esc_url(MERIS_THEME_BASE_URL.'/images/background-1.jpg').'"],"list-item-repeat":["","","","no-repeat"],"list-item-position":["","","",""],"list-item-attachment":["","","",""],"widget-area-layout":["boxed","full","boxed","boxed"],"widget-area-column":["1","1","1","2"],"widget-area-column-item":{"home-page-secion-one":["12"],"home-page-secion-two":["12"],"home-page-secion-three":["12"],"home-page-secion-four":["6","6"]}}',
		'type' => 'widget-area');
		
		// HEADER
	    $options[] = array(
		'name' => __('Header', 'meris'),
		'type' => 'heading');
	
		$options[] = array(
		'name' => __('Enable Sticky Header', 'meris'),
		'desc' => __('Active Sticky Header', 'meris'),
		'id' => 'enable_sticky_header',
		'std'=>'1',
		'type' => 'checkbox');
		
		$options[] = array(
		'name' => __('Upload Sticky Logo', 'meris'),
		'id' => 'sticky_logo',
		'std' => '',
		'type' => 'upload');
		
		$options[] = array(
		'name' => __('Display Site Name', 'meris'),
		'desc' => __('Display site name in sticky header', 'meris'),
		'id' => 'display_site_name',
		'std'=>'1',
		'type' => 'checkbox');
		
		// FOOTER
	    $options[] = array(
		'name' => __('Footer', 'meris'),
		'type' => 'heading');
	
        for($i=0;$i<9;$i++){
			
	    $options[] = array(
		"name" => sprintf(__('Social Icon #%s', 'meris'),($i+1)),
		"id" => "social_icon_".$i,
		"std" => "",
		"type" => "select",
		"options" => $social_icons );
		
		$options[] = array('name' => sprintf(__('Social Link #%s', 'meris'),($i+1)),'id' => 'social_link_'.$i,'type' => 'text');	
		}
		
		// Slider
		$options[] = array(
		'name' => __('Slider', 'meris'),
		'type' => 'heading');
		
		//HOME PAGE SLIDER
		$options[] = array('name' => __('Slideshow', 'meris'),'id' => 'group_title','type' => 'title');
		
		$options[] = array('name' => __('Slide 1', 'meris'),'id' => 'slide_group_start_1','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'meris'),'id' => 'meris_slide_image_1','type' => 'upload','std'=>MERIS_THEME_BASE_URL.'/images/banner-1.jpg');
		
		$options[] = array('name' => __('Text', 'meris'),'id' => 'meris_slide_text_1','type' => 'editor','std'=>'<h1>It<s>\'</s>s Nice <strong>to meet y<s>o</s>u</strong></h1><button>Tell Me More</button>');
		$options[] = array('name' => __('Link', 'meris'),'id' => 'meris_slide_link_1','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_1','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 2', 'meris'),'id' => 'slide_group_start_2','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'meris'),'id' => 'meris_slide_image_2','type' => 'upload','std'=>MERIS_THEME_BASE_URL.'/images/banner-2.jpg');
		
		$options[] = array('name' => __('Text', 'meris'),'id' => 'meris_slide_text_2','type' => 'editor','std'=>'<h1>It<s>\'</s>s Nice <strong>to meet y<s>o</s>u</strong></h1><button>Tell Me More</button>');
		$options[] = array('name' => __('Link', 'meris'),'id' => 'meris_slide_link_2','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_2','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 3', 'meris'),'id' => 'slide_group_start_3','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'meris'),'id' => 'meris_slide_image_3','type' => 'upload','std'=>MERIS_THEME_BASE_URL.'/images/banner-3.jpg');
		
		$options[] = array('name' => __('Text', 'meris'),'id' => 'meris_slide_text_3','type' => 'editor','std'=>'<h1>It<s>\'</s>s Nice <strong>to meet y<s>o</s>u</strong></h1><button>Tell Me More</button>');
		$options[] = array('name' => __('Link', 'meris'),'id' => 'meris_slide_link_3','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_3','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 4', 'meris'),'id' => 'slide_group_start_4','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'meris'),'id' => 'meris_slide_image_4','type' => 'upload','std'=>MERIS_THEME_BASE_URL.'/images/banner-4.jpg');
		
		$options[] = array('name' => __('Text', 'meris'),'id' => 'meris_slide_text_4','type' => 'editor','std'=>'<h1>It<s>\'</s>s Nice <strong>to meet y<s>o</s>u</strong></h1><button>Tell Me More</button>');
		$options[] = array('name' => __('Link', 'meris'),'id' => 'meris_slide_link_4','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_4','type' => 'end_group');
		
		$options[] = array('name' => __('Slide 5', 'meris'),'id' => 'slide_group_start_5','type' => 'start_group','class'=>'group_close');
		$options[] = array('name' => __('Image', 'meris'),'id' => 'meris_slide_image_5','type' => 'upload');
		
		$options[] = array('name' => __('Text', 'meris'),'id' => 'meris_slide_text_5','type' => 'editor');
		$options[] = array('name' => __('Link', 'meris'),'id' => 'meris_slide_link_5','type' => 'text');
		$options[] = array('name' => '','id' => 'slide_group_end_5','type' => 'end_group');
		

		
		$options[] = array(
		'name' => __('Slide Time', 'meris'),
		'id' => 'slide_time',
		'std' => '5000',
		'desc'=>__('Milliseconds between the end of the sliding effect and the start of the nex one.','meris'),
		'type' => 'text');		
		
		//END HOME PAGE SLIDER
		
	return $options;
}

