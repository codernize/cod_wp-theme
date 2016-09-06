	<footer>
		<div class="row">
			<div class="columns text-center">
				<?php 
					$args = array(
						'theme_location'  => 'footer',
						// 'container'       => 'div', // Use false for no container
						'container_class' => '',
						// 'container_id'    => '',
						'menu_class'      => 'menu',
						// 'menu_id'         => '',
						'depth'           => 0,
						'echo'			  => 'false' ,
					);
					$menu = wp_nav_menu($args);
					// play with $menu
					
					echo $menu; 
				?>
			</div>
		</div>
	</footer>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php bloginfo('template_url'); ?>/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        
        <?php wp_footer() ?>
        

    </body>
</html>
