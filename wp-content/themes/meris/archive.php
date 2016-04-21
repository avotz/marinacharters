<?php
/**
 * The archive template file.
 *
 * @since meris 1.0.0
 */

get_header(); ?>
<div class="blog-list">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<section class="blog-main text-center" role="main">
							<div class="breadcrumb-box text-left">
								<?php meris_get_breadcrumb();?>
							</div>
                            <?php if (have_posts()) :?>
                            <div class="blog-list-wrap">
                    <?php while ( have_posts() ) : the_post(); 
					
					    get_template_part("content","article");
					?>
                   <?php endwhile;?>
                   </div>
                   <?php endif;?>
                            		<div class="list-pagition text-center">
							<?php if(function_exists("meris_native_pagenavi")){meris_native_pagenavi("echo",$wp_query);}?>
							</div>
						</section>
					</div>
                    <div class="col-md-3">
						<aside class="blog-side left text-left">
							<div class="widget-area">
						<?php meris_get_sidebar("archive_sidebar");?>
							</div>
						</aside>
					</div>
				</div>
			</div>	
		</div>
<?php get_footer(); ?>