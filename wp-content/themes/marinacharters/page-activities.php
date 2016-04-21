<?php
/*
    Template Name: Page Activities
     */

get_header(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="blog-list">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <section class="blog-main text-center" role="main">
              <div class="breadcrumb-box text-left">
                <?php meris_get_breadcrumb();?>
              </div>
              <article class="post-entry text-left">
              
                <div class="entry-main">
                  <h1 class="entry-title"><?php the_title(); ?></h1>
                  <div class="entry-content">
                      <?php if (have_posts()) :?>
                        <?php while ( have_posts() ) : the_post(); ?>
                              <?php the_content();?>
                      <?php endwhile;?>
                      <?php endif;?>
                      <section class="activities">

                              
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
                                              'posts_per_page' => 12,
                                              'orderby' => 'menu_order',
                                              'order' => 'asc',
                                              'tax_query' => array(
                                                array(
                                                  'taxonomy' => 'type',
                                                  'field' => 'slug',
                                                  'terms' => 'activity'
                                                )
                                              )
                                              /*'post__in' => array(31,2,35,33,39,42),*/

                                              
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
                            <?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
                            
                          </div>
                      </section>  
                  </div>
                                   
                </div>
              </article>
              
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
</div> 
	
  <?php 
                            $wp_query = null; 
                            $wp_query = $temp;  // Reset
                          ?>

<?php
/*get_sidebar();*/
get_footer();
