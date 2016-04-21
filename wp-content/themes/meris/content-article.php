<article class="entry-box text-left">
								<div class="entry-date">
									<div class="day"><?php echo get_the_time('d');?></div>
									<div class="month"><?php echo get_the_time("M Y"); ?></div>
								</div>
								
								<div class="entry-main">
									<div class="entry-header">
										<a href="<?php the_permalink();?>"><h1 class="entry-title"><?php the_title();?></h1></a>
                                        <div class="entry-meta">
									<div class="entry-author"><i class="fa fa-user"></i><?php echo get_the_author_link();?></div> 
									<div class="entry-category"><i class="fa fa-file-o"></i><?php the_category(', '); ?></div>
									<div class="entry-comments"><i class="fa fa-comments"></i><?php  comments_popup_link( __('No comments yet','meris'), __('1 comment','meris'), __('% comments','meris'), 'comments-link', __('No comment','meris'));?></div>
				<?php edit_post_link( __('Edit','meris'), '<div class="entry-edit"><i class="fa fa-pencil"></i>', '</div>', get_the_ID() ); ?> 
								</div>
									</div>
									<div class="entry-summary">
										<?php 
												if ( has_post_thumbnail() ) {
												  the_post_thumbnail();
												} 
												?>
										<?php the_excerpt();?>	
									</div>
									<div class="entry-footer">
										<a href="<?php the_permalink();?>"><div class="entry-more"><?php _e("Read More","meris");?> <i class="fa fa-angle-double-right"></i></div></a>
									</div>
								</div>
							</article>