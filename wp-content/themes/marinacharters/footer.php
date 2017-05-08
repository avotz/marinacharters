<!--Footer-->
		<div class="footer-info"> Refereal fee available for agencies & concierce  <a href="https://www.budget.com/budgetWeb/home/home.ex?HP" class="budget-logo" target="_blank"><img src="https://www.budget.com/budgetWeb/images/newlayout/budgetLogoNew1.png" alt="budgetLogo"></a></div>
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
    <script>
 
	    var wpcf7ElmContact = document.querySelector( '.wpcf7' ); //form contact
	    

	      if(wpcf7ElmContact)
	    {
	          wpcf7ElmContact.addEventListener( 'wpcf7submit', function( event ) {
	            ga('send', 'event', 'Contact Form', 'submit');
	        }, false );
	      }
	   
	</script>
   
</body>
</html>