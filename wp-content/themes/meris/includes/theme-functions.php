<?php

 	/*	
	*	get background 
	*	---------------------------------------------------------------------
	*/
function meris_get_background($args){
$background = "";
 if (is_array($args)) {
	if (isset($args['image']) && $args['image']!="") {
	$background =  "background:url(".$args['image']. ")  ".$args['repeat']." ".$args['position']." ".$args['attachment'].";";
	}
	else
	{
	if(isset($args['color']) && $args['color'] !=""){
	$background = "background:".$args['color'].";";
	}
	}
	}
return $background;
}

 	/*	
	*	send email
	*	---------------------------------------------------------------------
	*/
function meris_contact(){
	if(trim($_POST['contact-name']) === '') {
		$Error = __('Please enter your name.','meris');
		$name     = "";
		$hasError = true;
	} else {
		$name = trim($_POST['contact-name']);
	}
  
	if(trim($_POST['contact-email']) === '')  {
		$Error = __('Please enter your email address.','meris');
		$email    = "";
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['contact-email']))) {
		$Error = __('You entered an invalid email address.','meris');
		$email    = "";
		$hasError = true;
	} else {
		$email = trim($_POST['contact-email']);
	}
	

	if(trim($_POST['contact-msg']) === '') {
		$Error =  __('Please enter a message.','meris');
		$message  = "";
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$message = stripslashes(trim($_POST['contact-msg']));
		} else {
			$message = trim($_POST['contact-msg']);
		}
	}

	if(!isset($hasError)) {
		
		$options = get_option("widget_meris_home_contact");
		$sendto  = $options[2]['contact_email'];
		
	   if (isset($sendto) && preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($sendto))) {
	     $emailTo = $sendto;
	   }
	   else{
	 	 $emailTo = get_option('admin_email');
		}
		 if($emailTo !=""){
		$subject = 'From '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nMessage: $message";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		wp_mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
		}
		echo json_encode(array("msg"=>__("Your message has been successfully sent!","meris"),"error"=>0));
		
	}
	else
	{
	echo json_encode(array("msg"=>$Error,"error"=>1));
	}
	die() ;
	}
	add_action('wp_ajax_meris_contact', 'meris_contact');
	add_action('wp_ajax_nopriv_meris_contact', 'meris_contact');
	
	// get breadcrumbs
 function meris_get_breadcrumb(){
   global $post,$wp_query;
   $postid = isset($post->ID)?$post->ID:"";
   $show_breadcrumb = "";
   if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) { 
    $postid = $wp_query->get_queried_object_id();
   }
   if(isset($postid) && is_numeric($postid)){
    $show_breadcrumb = get_post_meta( $postid, '_meris_show_breadcrumb', true );
	}
	if($show_breadcrumb == 'yes' || $show_breadcrumb==""){

     new meris_breadcrumb;

	}
	}
	
	
/*
*  page navigation
*
*/
function meris_native_pagenavi($echo,$wp_query){
    if(!$wp_query){global $wp_query;}
    global $wp_rewrite;      
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
    'base' => @add_query_arg('paged','%#%'),
    'format' => '',
    'total' => $wp_query->max_num_pages,
    'current' => $current,
    'prev_text' => '&laquo; ',
    'next_text' => ' &raquo;'
    );
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
    if($echo == "echo"){
    echo '<div class="page_navi">'.paginate_links($pagination).'</div>'; 
	}else
	{
	
	return '<div class="page_navi">'.paginate_links($pagination).'</div>';
	}
}
   
    //// Custom comments list
   
   function meris_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   
   <li  <?php comment_class("comment"); ?> id="comment-<?php comment_ID() ;?>">
                                	<article class="comment-body">
                                    	<div class="comment-avatar"><?php echo get_avatar($comment,'52','' ); ?></div>
                                        <div class="comment-box">
                                            <div class="comment-info"><?php printf(__('%s <span class="says">says:</span>','meris'), get_comment_author_link()) ;?> <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">
<?php printf(__('%1$s at %2$s','meris'), get_comment_date(), get_comment_time()) ;?></a>  <?php edit_comment_link(__('(Edit)','meris'),'  ','') ;?></div>

 <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.','meris') ;?></em>
         <br />
      <?php endif; ?>
     <div class="comment-content"><?php comment_text() ;?>
      <div class="reply-quote">
             <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
			</div>
       </div>
    </div></article>

<?php
        }
		
 function meris_get_default_slider(){
	global $allowedposttags ;
	$controller   = '';
	$slideContent = '';
	
	$slide_time       = meris_options_array("slide_time");
	$slide_height     = meris_options_array("slide_height");
	$slide_height     = $slide_height==""?"":"height:".esc_attr($slide_height).";";
	$slide_time       = is_numeric($slide_time)?$slide_time:"5000";
		  
	$return = '<section class="homepage-slider"><div id="carousel-meris-generic" style="'.$slide_height.'" class="carousel slide" data-interval="'.absint($slide_time).'" data-ride="carousel">';
	$j = 0 ;
	 for($i=1;$i<=5;$i++){
	$active = '';
	// $title = meris_options_array('meris_slide_title_'.$i);
	 $text  = meris_options_array('meris_slide_text_'.$i);
	 $image = meris_options_array('meris_slide_image_'.$i);
	 $link  = meris_options_array('meris_slide_link_'.$i);
	
	if( $image != "") {
	 if($j==0) $active     = 'active';

	 
	 if(isset($image) && strlen($image)>10){
		 $controller   .= '<li data-target="#carousel-meris-generic" data-slide-to="'.$j.'" class="'.$active.'"></li>';
		 
		 $slideContent .= '<div class="item '.$active.'">';
		 
		 if(trim($link) == ""){
         $slideContent .= '<img src="'.esc_url($image).'" alt="" />';
		 }else{
		$slideContent .= '<a href="'.esc_url($link).'" target="_blank"><img src="'.esc_url($image).'" alt="" /></a>';
			 }
         $slideContent .= '<div class="carousel-caption">'.wp_kses( $text, $allowedposttags  ).'</div></div>';
		 
		 }
		 $j++;
	  }
	}
	     $return .= '<ol class="carousel-indicators">'. $controller .'</ol>';
		 $return .= '<div class="carousel-inner">'. $slideContent .'</div>';
		 
		 $return .= '<a class="left carousel-control" href="#carousel-meris-generic" data-slide="prev">
						<span class="fa fa-angle-left"></span>
					</a>
					<a class="right carousel-control" href="#carousel-meris-generic" data-slide="next">
						<span class="fa fa-angle-right"></span>
					</a>';
		$return .= '</div></section>';

        return $return;
   }
   
   	// get sidebar
	
 function meris_get_sidebar($sidebar,$default = true){

	 if($default){
	 if ( is_active_sidebar($sidebar) ){
	 dynamic_sidebar($sidebar);
	 }
	 else{
	 dynamic_sidebar('displayed_everywhere');
	 }
	 }else{
	 if ( is_active_sidebar($sidebar) ){
	 dynamic_sidebar($sidebar);
	 }
	 }

 }
		// fix shortcode

 function meris_fix_shortcodes($content){   
			$replace_tags_from_to = array (
				'<p>[' => '[', 
				']</p>' => ']', 
				']<br />' => ']',
				']<br>' => ']',
				']\r\n' => ']',
				']\n' => ']',
				']\r' => ']',
				'\r\n[' => '[',
			);

			return strtr( $content, $replace_tags_from_to );
		}

 function meris_the_content_filter($content) {
	  $content = meris_fix_shortcodes($content);
	  return $content;
	}
	
 add_filter( 'the_content', 'meris_the_content_filter' );
 
  function meris_enqueue_less_styles($tag, $handle) {
		global $wp_styles;
		$match_pattern = '/\.less$/U';
		if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
			$handle = $wp_styles->registered[$handle]->handle;
			$media = $wp_styles->registered[$handle]->args;
			$href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
			$rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
			$title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';
	
			$tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
		}
		return $tag;
	}
	add_filter( 'style_loader_tag', 'meris_enqueue_less_styles', 5, 2);
	
	
add_action( 'optionsframework_sidebar','meris_options_panel_sidebar' );


/**
 * Meris widget area generator
 */

function meris_widget_area_generator($args = array(),$echo = true){
	
	$column            = isset($_POST['column'])?$_POST['column']:1;
	$num               = isset($_POST['num'])?$_POST['num']:0;
	$areaname          = isset($_POST['areaname'])?$_POST['areaname']:0;
	$column_items      = array();
	for($i=0; $i<$column; $i++){
		$column_items[] = 12/$column; 
		}
	$defaults = array("areaname" => $areaname,
							 "color" => '',
							 "image" => '',
							 "repeat" => '',
							 "position" => '',
							 "attachment" => '',
							 "layout" => '',
							 "column" => $column,
							 "columns" => $column_items,
							 "num"     => $num,
							 "padding" => 50
							 );

	$args = wp_parse_args( $args, $defaults );
	$sanitize_areaname = sanitize_title($args['areaname']);

	       $image_show = $args['image']==''?'':'<img src="'.$args['image'].'"><a class="remove-image">'.__("Remove","meris").'</a>';
		   if($args['image']==''){
			   $button = '<input type="button" value="Upload" class="upload-button button" id="upload-list-item-image-'.$args['num'].'">';
		   }else{
			   $button = '<input type="button" value="Remove" class="remove-file  button" id="upload-list-item-image-'.$args['num'].'">';
			   }
		   
		   
	// Background Color
	            $output  = '<div class="list-item ">';
				$output .= '<div class="section-widget-area-name"><span class="widget-area-name">'.$args['areaname'].'</span><span><a href="javascript:;" class="edit-section">'.__("Edit","meris").'</a> | <a href="javascript:;" data-href="javascript:;" data-toggle="confirmation" class="remove-section ">'.__("Remove","meris").'</a></span></div>';
				$output .= '<input type="hidden" name="widget-area[section-widget-area-name][]" class="section-widget-area-name-item" id="section-widget-area-name-'.$args['num'].'" value="'.$args['areaname'].'" />';
				$output .= '<input type="hidden" class="section-widget-sanitize-areaname" value="'.$sanitize_areaname.'" />';
				
				$output .= '<div class="section-widget-area-wrapper">';
				$output .= '<div class="section section-color section-widget-area-background" id="section-widget-area-background-'.$args['num'].'"><label>'. __("Background","meris").':</label>
  <div class="wp-picker-container"><span class="wp-picker-input-wrap">
    <input type="text" value="'.$args['color'].'" class="of-color of-background-color wp-color-picker" id="list-item-color-'.$args['num'].'"  name="widget-area[list-item-color][]" style="display: none;">
    <input type="button" class="button button-small hidden wp-picker-clear" value="Clear">
    </span>
    <div class="wp-picker-holder">
      <div class="iris-picker iris-mozilla iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;">
        <div class="iris-picker-inner">
          <div class="iris-square" style="width: 182.125px; height: 182.125px;"><a href="#" class="iris-square-value ui-draggable" style="left: 0px; top: 182.133px;"><span class="iris-square-handle ui-slider-handle"></span></a>
            <div class="iris-square-inner iris-square-horiz" style="background-image: -moz-linear-gradient(left center , rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div>
            <div class="iris-square-inner iris-square-vert" style="background-image: -moz-linear-gradient(center top , transparent, rgb(0, 0, 0));"></div>
          </div>
          <div class="iris-slider iris-strip" style="width: 28.2px; height: 205.346px; background-image: -moz-linear-gradient(center top , rgb(0, 0, 0), rgb(0, 0, 0));">
            <div class="iris-slider-offset ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="bottom: 0%;"></a></div>
          </div>
        </div>
        <div class="iris-palette-container"><a tabindex="0" class="iris-palette" style="background-color: rgb(0, 0, 0); width: 19.5784px; height: 19.5784px; margin-left: 0px;"></a><a tabindex="0" class="iris-palette" style="background-color: rgb(255, 255, 255); width: 19.5784px; height: 19.5784px; margin-left: 3.6425px;"></a><a tabindex="0" class="iris-palette" style="background-color: rgb(221, 51, 51); width: 19.5784px; height: 19.5784px; margin-left: 3.6425px;"></a><a tabindex="0" class="iris-palette" style="background-color: rgb(221, 153, 51); width: 19.5784px; height: 19.5784px; margin-left: 3.6425px;"></a><a tabindex="0" class="iris-palette" style="background-color: rgb(238, 238, 34); width: 19.5784px; height: 19.5784px; margin-left: 3.6425px;"></a><a tabindex="0" class="iris-palette" style="background-color: rgb(129, 215, 66); width: 19.5784px; height: 19.5784px; margin-left: 3.6425px;"></a><a tabindex="0" class="iris-palette" style="background-color: rgb(30, 115, 190); width: 19.5784px; height: 19.5784px; margin-left: 3.6425px;"></a><a tabindex="0" class="iris-palette" style="background-color: rgb(130, 36, 227); width: 19.5784px; height: 19.5784px; margin-left: 3.6425px;"></a></div>
      </div>
    </div>
  </div>
  <input type="text" placeholder="'. __("No file chosen","meris").'" value="'.$args['image'].'" name="widget-area[list-item-image][]" class="upload" id="list-item-image-'.$args['num'].'">
  '.$button.'
  <div id="list-item-image-'.$args['num'].'-image" class="screenshot">'.$image_show.'</div>
  <div class="of-background-properties">
    <select id="list-item-repeat-'.$args['num'].'" name="widget-area[list-item-repeat][]" class="of-background of-background-repeat">
      <option '.($args['repeat'] == 'no-repeat'?'selected="selected"':'').' value="no-repeat">No Repeat</option>
      <option '.($args['repeat'] == 'repeat-x'?'selected="selected"':'').' value="repeat-x">Repeat Horizontally</option>
      <option '.($args['repeat'] == 'repeat-y'?'selected="selected"':'').' value="repeat-y">Repeat Vertically</option>
      <option '.($args['repeat'] == 'repeat'?'selected="selected"':'').' value="repeat">Repeat All</option>
    </select>
    <select id="list-item-position-'.$args['num'].'" name="widget-area[list-item-position][]" class="of-background of-background-position">
      <option '.($args['position'] == 'top left'?'selected="selected"':'').' value="top left">Top Left</option>
      <option '.($args['position'] == 'top center'?'selected="selected"':'').' value="top center">Top Center</option>
      <option '.($args['position'] == 'top right'?'selected="selected"':'').' value="top right">Top Right</option>
      <option '.($args['position'] == 'center left'?'selected="selected"':'').' value="center left">Middle Left</option>
      <option '.($args['position'] == 'center center'?'selected="selected"':'').' value="center center">Middle Center</option>
      <option '.($args['position'] == 'center right'?'selected="selected"':'').' value="center right">Middle Right</option>
      <option '.($args['position'] == 'bottom left'?'selected="selected"':'').' value="bottom left">Bottom Left</option>
      <option '.($args['position'] == 'bottom center'?'selected="selected"':'').' value="bottom center">Bottom Center</option>
      <option '.($args['position'] == 'bottom right'?'selected="selected"':'').' value="bottom right">Bottom Right</option>
    </select>
    <select id="list-item-attachment-'.$args['num'].'" name="widget-area[list-item-attachment][]" class="of-background of-background-attachment">
      <option  '.($args['attachment'] == 'scroll'?'selected="selected"':'').'value="scroll">Scroll Normally</option>
      <option '.($args['attachment'] == 'fixed'?'selected="selected"':'').' value="fixed">Fixed in Place</option>
    </select>
  </div>
</div>';

				
				/////widget secton layout
		$output .= '<div id="section-widget-area-layout-'.$args['num'].'" class="section section-layout">';
		$output .= '<label> '.__("Layout","meris").' :</label><select name="widget-area[widget-area-layout][]" id="widget-area-layout-'.$args['num'].'">
			    	<option '.($args['layout'] == 'boxed'?'selected="selected"':'').' value="boxed">'.__("boxed","meris").'</option>
				    <option '.($args['layout'] == 'full'?'selected="selected"':'').' value="full">'.__("full width","meris").'</option></select>';
				
		$output .= '</div>';
		
		$output .= '<div id="section-widget-area-padding-'.$args['num'].'" class="section section-padding">';
		$output .= '<label> '.__("Padding top & bottom","meris").' :</label>';
		$output .= '<input style=" width:50%;" type="text" value="'.$args['padding'].'" name="widget-area[widget-area-padding][]" id="widget-area-padding-'.$args['num'].'"> px';
		$output .= '</div>';
		
				/////widget secton column
		$output .= '<div id="section-widget-area-column-'.$args['num'].'" class="section section-column">';
		$output .= '<label> '.__("Column","meris").' :</label><select class="widget-area-column" name="widget-area[widget-area-column][]" id="widget-area-column-'.$args['num'].'">
			        <option value="1">'.__("choose column","meris").'</option>';
					for($j=1;$j<=4;$j++){
						$selected   = "";
						$column_n   = __("columns","meris");
						if($j == $args['column']){$selected = " selected='selected' ";}
						if($j == 1){$column_n = __("column","meris");}
						
			    	    $output .= '<option value="'.$j.'" '.$selected.'>'.$j.' '.$column_n.'</option>';
				   
					}
					
		$output .= '</select>';
				/////widget secton column items
		$output .= '<div class="widget-secton-column">';
				if(count($args['columns']) > 1){
					$j = 1 ;
					foreach($args['columns'] as $c){
						
			        $output .= '<label> '.sprintf(__("Column %s width","meris"),$j).' :</label><select class="widget-area-column-item" name="widget-area[widget-area-column-item]['.$sanitize_areaname.'][]" id="widget-area-column-item-'.$j.'">';
			        
					for($k=1;$k<=12;$k++){
					$selected   = "";
					if($c == $k){$selected = ' selected="selected" ';}
			    	$output .= '<option value="'.$k.'" '.$selected.'>'.$k.'/12</option>';
				   
					}
					
		$output .= '</select>';
		$j++;
					  }
					}
		$output .= '</div>';
				/////
		$output .= '</div>';
				//				
		$output .= '</div>';
		$output .= '</div>';
				if($echo == true){
				    echo $output ;
				    exit(0);
				}else{
					return $output ;
					}
	
	}
    add_action('wp_ajax_meris_widget_area_generator', 'meris_widget_area_generator');
	add_action('wp_ajax_nopriv_meris_widget_area_generator', 'meris_widget_area_generator');

/**
 * Meris admin sidebar
 */
function meris_options_panel_sidebar() { ?>
	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
	    	<div class="postbox">
	    		<h3><?php esc_attr_e( 'Quick Links', 'meris' ); ?></h3>
      			<div class="inside"> 
		          <ul>
                   <li><a href="<?php echo esc_url( 'http://www.mageewp.com/meris-theme.html' ); ?>" target="_blank"><?php _e( 'Upgrade to Pro', 'meris' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/themes/' ); ?>" target="_blank"><?php _e( 'MageeWP Themes', 'meris' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/documents/tutorials' ); ?>" target="_blank"><?php _e( 'Tutorials', 'meris' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/documents/faq/' ); ?>" target="_blank"><?php _e( 'FAQ', 'meris' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/knowledges/' ); ?>" target="_blank"><?php _e( 'Knowledge', 'meris' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/forums/meris-theme/' ); ?>" target="_blank"><?php _e( 'Support Forums', 'meris' ); ?></a></li>
                  </ul>
      			</div>
	    	</div>
	  	</div>
	</div>
    <div class="clear"></div>
<?php
} 