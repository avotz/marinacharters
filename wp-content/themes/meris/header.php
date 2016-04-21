<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <?php wp_head();?>
</head>
<body <?php body_class(); ?>>
<?php 
global $enable_home_page;
$enable_home_page = meris_options_array('enable_home_page');
if(is_home()){$wrapper_class = 'homepage header-wrapper';}else{$wrapper_class = 'blog-list-page both-aside header-wrapper';}
       if(('page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' )) || $enable_home_page==""){$wrapper_class = 'blog-list-page both-aside header-wrapper';}
?>
	<div class="<?php echo $wrapper_class;?>">
		<!--Header-->
		<header class="theme-header">
			<div class="container">
				<div class="logo-box text-left">
					
        <?php if ( meris_options_array('logo')!="") { ?>
        <a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo esc_url(meris_options_array('logo')); ?>" class="site-logo" alt="<?php bloginfo('name'); ?>" />
        </a>
        <?php } ?>
					<div class="name-box">
						<a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
						<span class="site-tagline"><?php echo  get_bloginfo( 'description' );?></span>
					</div>
				</div>
				<button class="site-search-toggle">
					<span class="sr-only"><?php _e( 'Toggle search', 'meris' );?></span>
					<i class="fa fa-search fa-2x"></i>
				</button>
				<button class="site-nav-toggle">
					<span class="sr-only"><?php _e( 'Toggle navigation', 'meris' );?></span>
					<i class="fa fa-bars fa-2x"></i>
				</button>
				<form role="search" action="<?php echo esc_url(home_url('/')); ?>" class="search-form">
					<div>
						<label class="sr-only"><?php _e( 'Search for', 'meris' );?>:</label>
						<input type="text" value="" name="s" id="s" placeholder="<?php _e( 'Search', 'meris' );?>...">
						<input type="submit" value="">
					</div>
				</form>
				<nav class="site-nav" role="navigation">
					<?php 
					 wp_nav_menu(array('theme_location'=>'primary','depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
					?>
				</nav>
			</div>
		</header>
<?php
   $enable_sticky_header      =  meris_options_array('enable_sticky_header');
   if( $enable_sticky_header != "" ){
	   get_template_part("header","sticky");
 }