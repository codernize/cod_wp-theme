<section class="columns small-12 medium-6 xlarge-4 text-center align-center  single-service-type-icons">
    <article class="single-service">
        <header class="service-icon">
            <img src="<?php $icon = get_field('icon',$service->ID); echo $icon ?>" <?php echo substr(strtolower($icon), -4) == '.svg'  ? 'class="svg"' : ''?> />
        </header> <!-- /.service-icon -->
        <main>
            <h3 ><?php echo $service->post_title ?></h3>
            <?php echo apply_filters('the_content',get_field('excerpt',$service->ID)); ?>
        </main>
        <footer>
            <p><a href="<?php echo get_permalink($service->ID ); ?>" class="button">READ MORE</a></p>
        </footer>
        
    </article>
</section>