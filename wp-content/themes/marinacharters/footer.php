<!--Footer-->
		<footer>
			<div class="container text-center">
				<div class="site-sns">
                <?php 
				
				for($i=0;$i<9; $i++){
					$social_icon = esc_attr(meris_options_array('social_icon_'.$i));
					$social_link = esc_url(meris_options_array('social_link_'.$i));
					if($social_link !=""){
					echo '<a href="'.$social_link.'" target="_blank"><i class="'.$social_icon.'"></i></a>';
					}
					}
					?>
					
				</div>
				<div class="site-info">
					Marina Charters CR 2016 @ <a href="http://www.avotz.com">Avotz</a>
				</div>
			</div>
		</footer>
	</div>	
    <?php wp_footer();?>
    <script src="<?php echo get_stylesheet_directory_uri();  ?>/js/jquery.cycle2.min.js"></script>
   
</body>
</html>