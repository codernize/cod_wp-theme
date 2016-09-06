<?php get_header(); ?>

<main class="row">
	<section class="columns medium-9">
		<h1><?php printf( __( 'Author Archives: %s', 'twentytwelve' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
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
	</section>
	<?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>
