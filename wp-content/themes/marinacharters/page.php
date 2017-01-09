<?php
/**
 * The Template for displaying page.
 *
 * @since meris 1.0.0
 */

get_header(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if (have_posts()) :?>
<?php $pageType = get_the_terms($post->id, 'type');	?>
<?php	while ( have_posts() ) : the_post();
        $meris_sidebar          = get_post_meta( $post->ID, '_meris_layout', true );
		$meris_sidebar      = $meris_sidebar==""?"right":$meris_sidebar;
		$column_class_one   = ""; 
		$column_class_two   = ""; 
		$column_class_three = ""; 
		switch($meris_sidebar){
			case "left":
			$column_class_one   = "col-md-9 col-md-push-3"; 
			$column_class_two   = "col-md-3 col-md-pull-9"; 
			$column_class_three = ""; 
			break;
			case "right":
			$column_class_one   = "col-md-9"; 
			$column_class_two   = ""; 
			$column_class_three = "col-md-3";
			break;
			case "both":
			$column_class_one   = "col-md-6 col-md-push-3"; 
			$column_class_two   = "col-md-3 col-md-pull-6"; 
			$column_class_three = "col-md-3"; 
			break;
			case "none":
			$column_class_one   = "col-md-12"; 
			$column_class_two   = ""; 
			$column_class_three = "";
			break;
			default:
			$column_class_one   = "col-md-9"; 
			$column_class_two   = ""; 
			$column_class_three = "col-md-3";
			break;
			
			}
?>
<div class="blog-list">
			<div class="container">
				<div class="row">
					<div class="<?php echo $column_class_one;?>">
						<section class="blog-main text-center" role="main">
							<div class="breadcrumb-box text-left">
								<?php meris_get_breadcrumb();?>
							</div>
                         <article class="post-entry text-left">
								
								<div class="entry-main">
									
									<div class="entry-content">
									<?php if($pageType[0]->slug == 'fleet') : ?>
										<?php $images = rwmb_meta( 'rw_activity_photos', 'type=image&size=full' );

		                                   if ( $images ) {?>
		                                   
		                                   	<div class="banner-page">
		                                   		<h1 class="entry-title"><?php the_title();?></h1>
		                                      <div class="cycle-slideshow"
					                                data-cycle-fx="fade"
					                                data-cycle-timeout="4000"
					                                data-cycle-prev="#prevC"
					                                data-cycle-next="#nextC"
					                                data-cycle-slides=".slide-fleet"

					                                   >

		                                           <?php 
													$id = get_post_thumbnail_id($post->ID);
									  	 			$thumb_url = wp_get_attachment_image_src($id,'full', true); ?>
 												  
 												 <!-- <div class="slide-fleet" style="background-image: url('<?php echo $thumb_url[0] ?>');"></div>-->

		                                           <?php  foreach ( $images as $image ){ ?>

		                                               <div class="slide-fleet" style="background-image: url('<?php echo $image['url'] ?>');"></div>
		                                             
		                                            
		                                            <?php } ?>

		                                           
		                                      </div>
		                                      <div class="center">
					                               <a href=# id="prevC"><i class="fa fa-angle-left"></i></a>
					                               <a href=# id="nextC"><i class="fa fa-angle-right"></i></a>
					                           </div>
					                         </div>

		                                  <?php } ?>
										<?php else: ?>
										
                       

											<?php if ( has_post_thumbnail() ) :

									  	 	$id = get_post_thumbnail_id($post->ID);
									  	 	$thumb_url = wp_get_attachment_image_src($id,'full', true);
									  	 	?>
									    	
											<div class="entry-img float-left" style="background-image: url('<?php echo $thumb_url[0] ?>');"></div>
														
											<?php endif; ?>
										<?php endif;?>
										<?php if($pageType[0]->slug == 'fleet') : ?>
										  <div class="content-fleet">
										  	<div class="content-fleet-item">
										  		 <h1>Features</h1>
										  		 <?php the_content();?>
										  	</div>
										  	<div class="content-fleet-item">
										  		<h1>Prices</h1>
										  		 <?php echo rwmb_meta( 'rw_prices'); ?>
										  	</div>
										  	<div class="content-fleet-item">
										  		<h1>Media</h1>
										  		<?php echo rwmb_meta( 'rw_video'); ?>
										  	</div>
										  </div>
										 
										<?php else: ?>
											<?php the_content();?>
										<?php endif; ?>

									</div>
                                    <?php  wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'meris' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
								</div>
							</article>
							<div class="comments-area text-left">
	                       <?php
									echo '<div class="comment-wrapper">';
									comments_template(); 
									echo '</div>';
                                  ?>                             
	                        </div>

						</section>

					</div>
                    <?php if($meris_sidebar == "left" || $meris_sidebar == "both"){?>
					<div class="<?php echo $column_class_two;?>">
						<aside class="blog-side left text-left">
							<div class="widget-area">
									<?php meris_get_sidebar("page_left_sidebar");?>
							</div>
						</aside>
					</div>
                    <?php }?>
                    <?php if($meris_sidebar == "right" || $meris_sidebar == "both"){?>
					<div class="<?php echo $column_class_three;?>">
						<aside class="blog-side right text-left">
							<div class="widget-area">
						<?php meris_get_sidebar("page_right_sidebar");?>
							</div>
                           
						</aside>
					</div> <?php }?>
				</div>
			</div>	
		</div>
		
<?php endwhile;?>
<?php endif;?>

<?php if($pageType[0]->slug == 'fleet') : ?>
<section class="fleet fleet-details">

                              
                              <div class="container">


                                  
                                  <?php 
                                     
                                     if ( get_query_var('paged') ) {
                                                $paged = get_query_var('paged');
                                            } else if ( get_query_var('page') ) {
                                                $paged = get_query_var('page');
                                            } else {
                                                $paged = 1;
                                            } 
                              
                                            $args = array(
                                              'post_type' => 'page',
                                              'paged' => $paged,
                                              'posts_per_page' => 4,
                                              'orderby' => 'rand',
                                              'tax_query' => array(
                                                array(
                                                  'taxonomy' => 'type',
                                                  'field' => 'slug',
                                                  'terms' => 'fleet'
                                                )
                                              )
                                              /*'post__in' => array(61,67,63,65),*/
                                              
                                            );
                                            $temp = $wp_query; 
                                            $wp_query = null;
                                            $wp_query = new WP_Query( $args );

                                            if( $wp_query->have_posts() ) : while( $wp_query->have_posts() ) : $wp_query->the_post();
                                                
                                              

                                                ?>
                                            
                                                      <div class="col-md-3" >
                                                          <div class="widget home_widget_portfolio">
                                                              <div class="col-sm-6 col-md-12">
                                                                  <div class="portfolio-box text-center">
                                                                     	<?php if($post->ID == 116): ?>
                                                                        	<span class="coming-soon">Coming Soon</span>
                                                                        <?php endif ?>
                                                                        <?php if ( has_post_thumbnail() ) :

                                                                        $id = get_post_thumbnail_id($post->ID);
                                                                        $thumb_url = wp_get_attachment_image_src($id,array(800,600), true);
                                                                        ?>
                                                                         <a href="<?php the_permalink(); ?>">
                                                                            <img src="<?php echo $thumb_url[0] ?>" alt="img">
                                                                        </a>           
                                                                    <?php endif; ?>
                                                                    <a href="<?php the_permalink(); ?>">
                                                                           <h3><?php the_title(); ?></h3>
                                                                    </a>           
                                                                  </div>
                                                                
                                                              </div>
                                                              
                                                          </div>
                                                          
                                                      </div>
                                             
                              
                                                    <?php endwhile; ?>
                                              <!-- post navigation -->
                                            
                                          <?php endif; ?>
                                                          
                                          
                                  
                              
                          </div>
                          <div class="txt-center">
                            <?php /*the_posts_pagination( array( 'mid_size' => 2 ) ); */?>
                            
                          </div>
                      </section>
                       <?php 
                            $wp_query = null; 
                            $wp_query = $temp;  // Reset
                          ?> 
</div>
<?php endif; ?>
<?php if($pageType[0]->slug == 'activity') : ?>
<section class="fleet fleet-details">

                              
                              <div class="container">


                                  
                                  <?php 
                                     
                                     if ( get_query_var('paged') ) {
                                                $paged = get_query_var('paged');
                                            } else if ( get_query_var('page') ) {
                                                $paged = get_query_var('page');
                                            } else {
                                                $paged = 1;
                                            } 
                              
                                            $args = array(
                                              'post_type' => 'page',
                                              'paged' => $paged,
                                              'posts_per_page' => 4,
                                              'orderby' => 'rand',
                                              'tax_query' => array(
                                                array(
                                                  'taxonomy' => 'type',
                                                  'field' => 'slug',
                                                  'terms' => 'activity'
                                                )
                                              )
                                              /*'post__in' => array(61,67,63,65),*/
                                              
                                            );
                                            $temp = $wp_query; 
                                            $wp_query = null;
                                            $wp_query = new WP_Query( $args );

                                            if( $wp_query->have_posts() ) : while( $wp_query->have_posts() ) : $wp_query->the_post();
                                                
                                              

                                                ?>
                                            
                                                      <div class="col-md-3" >
                                                          <div class="widget home_widget_portfolio">
                                                              <div class="col-sm-6 col-md-12">
                                                                  <div class="portfolio-box text-center">
                                                                     	<?php if($post->ID == 116): ?>
                                                                        	<span class="coming-soon">Coming Soon</span>
                                                                        <?php endif ?>
                                                                        <?php if ( has_post_thumbnail() ) :

                                                                        $id = get_post_thumbnail_id($post->ID);
                                                                        $thumb_url = wp_get_attachment_image_src($id,'medium', true);
                                                                        ?>
                                                                         <a href="<?php the_permalink(); ?>">
                                                                            <img src="<?php echo $thumb_url[0] ?>" alt="img">
                                                                        </a>           
                                                                    <?php endif; ?>
                                                                    <a href="<?php the_permalink(); ?>">
                                                                           <h3><?php the_title(); ?></h3>
                                                                    </a>           
                                                                  </div>
                                                                
                                                              </div>
                                                              
                                                          </div>
                                                          
                                                      </div>
                                             
                              
                                                    <?php endwhile; ?>
                                              <!-- post navigation -->
                                            
                                          <?php endif; ?>
                                                          
                                          
                                  
                              
                          </div>
                          <div class="txt-center">
                            <?php /*the_posts_pagination( array( 'mid_size' => 2 ) ); */?>
                            
                          </div>
                      </section>
                       <?php 
                            $wp_query = null; 
                            $wp_query = $temp;  // Reset
                          ?> 
</div>
<?php endif; ?>
<?php get_footer(); ?>