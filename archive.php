<?php get_header(); ?>

<main class="row">
	<article class="columns medium-9">
		<h1><?php
				if ( is_day() ) :
					printf( __( 'Daily Archives: %s', 'twentytwelve' ), '<span>' . get_the_date() . '</span>' );
				elseif ( is_month() ) :
					printf( __( 'Monthly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentytwelve' ) ) . '</span>' );
				elseif ( is_year() ) :
					printf( __( 'Yearly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentytwelve' ) ) . '</span>' );
				else :
					_e( 'Archives', 'twentytwelve' );
				endif;
			?></h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe culpa illo vero adipisci maiores consequuntur! Nobis tempora saepe, ut sint?</p>
		<hr>
		<?php if (have_posts()): ?>
			<?php while (have_posts()) : ?>
				<?php the_post(); ?>
				<?php get_template_part('loop','single');	?>
			<?php endwhile ?>
			<?php cod_paginate(); ?>
		<?php else: ?>	
			<p>No Posts Found!</p>
		<?php endif ?>
	</article>
	<?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>
