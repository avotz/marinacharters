<?php
/**
 * The Template for displaying 404 Page not Found .
 *
 * @since meris 1.0.0
 */

get_header(); ?>

<div class="blog-list">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-push-3">
						<section class="blog-main text-center" role="main">
							<div class="breadcrumb-box text-left">
								<?php meris_get_breadcrumb();?>
							</div>
							<article class="post-entry text-left">
								<div class="page-404 text-center">
									<?php 
									$page_404_content = meris_options_array('page_404_content');
									echo $page_404_content ;
									?>
								</div>
							</article>
						</section>
					</div>
					<div class="col-md-3 col-md-pull-6">
						<aside class="blog-side left text-left">
							<div class="widget-area">
								<?php meris_get_sidebar("page_404_left_sidebar");?>
							</div>
						</aside>
					</div>
					<div class="col-md-3">
						<aside class="blog-side right text-left">
							<div class="widget-area">
	                         <?php meris_get_sidebar("page_404_right_sidebar");?>
							</div>
						</aside>
					</div>
				</div>
			</div>	
		</div>

<?php get_footer(); ?>