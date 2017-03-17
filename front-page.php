<?php get_header(); ?>

<main class="row">
	<article class="columns medium-9">
		<h1>Front Page</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe culpa illo vero adipisci maiores consequuntur! Nobis tempora saepe, ut sint?</p>
	</article>
	<?php get_sidebar(); ?>
</main>

<?php 
    $section = get_field('sections');
    if (!empty($section)) {
        foreach ($section as $key => $value) {
            $class = '' ;
            if ($key > 1)
                $class .= ' when-in-view';
            if ($key == 1) // when in view for the second if first is hero
                if($section[0]['acf_fc_layout'] == 'content') 
                    if($section[0]['content__hero'])
                        $class .= ' when-in-view';
                    
            include 'flexi/flexi_'.$value['acf_fc_layout'].'.php';
        }
    } 
 ?>

<?php get_footer(); ?>