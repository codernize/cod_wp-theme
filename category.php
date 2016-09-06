<?php get_header(); ?>

<main class="row">
	<section class="columns medium-9">
		<h1><?php printf( __( 'Category: <strong>%s</strong>', 'codernize' ), single_cat_title( '', false ) ); ?></h1>
		<?php 
		$term_description = term_description();
		if (! empty( $term_description ) ): ?>
		  <?php echo apply_filters('the_content',$term_description) ?>
		<?php endif;
		?>
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

