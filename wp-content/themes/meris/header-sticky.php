<header class="sticky-header">
  <div class="container">
    <div class="logo-box text-left">
    <?php if ( meris_options_array('sticky_logo')!="") { ?>
        <a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo meris_options_array('sticky_logo'); ?>"  class="site-logo"  alt="<?php bloginfo('name'); ?>" />
        </a>
        <?php } ?>
        <?php 
		$display_site_name = meris_options_array('display_site_name') ;
		if( $display_site_name != "" ){
		?>
      <div class="name-box">
         <a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
      </div>
       <?php } ?>
    </div>
    <button class="site-nav-toggle">
      <span class="sr-only"><?php _e( 'Toggle navigation', 'meris' );?></span>
      <i class="fa fa-bars fa-2x"></i>
    </button>
    <nav class="site-nav" role="navigation">
      <?php wp_nav_menu(array('theme_location'=>'primary','depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'','menu_id'=>'','menu_class'=>'sticky-header-menu','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
						?>
    </nav>
  </div>
</header>