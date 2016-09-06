<?php get_header(); ?>

<main class="row">
	<article class="columns medium-9">
		<h1><?php printf( __( 'Search: <strong>%s</strong>', 'codernize' ), esc_attr(get_search_query()) ); ?></h1>
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