<?php 

$left_classes = '';
$right_classes = '';
/*echo '<pre><!-- single_service__images.php:5 -->';
print_r($key);
// print_r(var_dump($_POST));
// die('---end debug single_service__images.php:5 ---');        
echo '</pre>';*/
if ($i % 2 != 0) {
    $left_classes = 'medium-order-2';
    $right_classes = 'medium-order-1';
} // end if 

$image = get_field('image',$service->ID);
 ?>
<section class="columns small-12 single-service single-service-type-images">
    <div class="row align-middle">

        <?php if (!empty($image )): ?>
        <aside class="service-image columns small-12 medium-6 <?php echo $left_classes ?>">
            
            <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>" />
        </aside> <!-- /.service-image -->
        <article class="columns service-text small-12 medium-6 <?php echo $right_classes ?>">
        <?php else: ?>    
        <article class="columns service-text small-12 <?php echo $right_classes ?>">
        <?php endif ?>
            <h3><?php echo $service->post_title ?></h3>
            <?php echo get_field('excerpt',$service->ID) ?>
            <p><a href="<?php echo get_permalink($service->ID ); ?>" class="button secondary">READ MORE</a></p>
        </article> <!-- /.columns service-text small-12 medium-6--MAYBE -->
            
        
    </div> <!-- /.row -->

   
</section>