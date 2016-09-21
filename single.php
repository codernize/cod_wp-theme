<?php get_header(); ?>
<?php the_post(); ?>
<main class="row">
	<article class="columns medium-9">
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</article>
	<?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>