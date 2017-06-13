<!--Footer-->
		<div class="footer-info"> Refereal fee available for agencies & concierce <br>
		<a href="http://www.pexscr.com/" class="partners__link" target="_blank"><img src="http://costarica-brokers.com/wp-content/themes/costaricabrokers/img/partners/PEXS-Costa-Rica-Logo.jpg" alt="pexscr"></a>
             <a href="http://costarica-brokers.com/" class="partners__link" target="_blank"><img src="http://costarica-brokers.com/wp-content/themes/costaricabrokers/img/logo.png" alt="Costa Rica Brokers"></a>
             <a href="http://caturgua.com/" class="partners__link" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();  ?>/images/partners/Guanacaste.png" alt="Guanacaste Caturga"></a>
             <a href="http://caturgua.com/" class="partners__link" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();  ?>/images/partners/caturga.png" alt="Guanacaste Caturga"></a>
             <a href="http://www.johansens.com/north-america/costa-rica/" class="partners__link" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();  ?>/images/partners/Jo-Logo.jpg" alt="Johansen"></a>
             <a href="https://www.budget.co.cr/rental-hermosa-guanacaste/" class="partners__link budget-logo" target="_blank"><img src="https://www.budget.com/budgetWeb/images/newlayout/budgetLogoNew1.png" alt="budgetLogo"></a>
		</div>
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