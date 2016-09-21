<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;

        wp_title( '|', true, 'right' );

        // Add the blog name.
        bloginfo( 'name' );

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            echo " | $site_description";

        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 )
            echo ' | ' . sprintf( __( 'Page %s', 'themename' ), max( $paged, $page ) );

        ?></title>
            
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
              <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
       
        
        
       
        <?php wp_head(); ?>
    </head>
    <body <?php body_class() ?>>
        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        
    <header>
        <div class="row">
            <div class="columns medium-2"><a href="<?php echo site_url(); ?>/"><?php bloginfo('name'); ?></a></div>
            <div class="columns medium-10">
                <?php 
                    $args = array(
                        'theme_location'  => 'primary',
                        // 'container'       => 'div', // Use false for no container
                        'container_class' => '',
                        // 'container_id'    => '',
                        'menu_class'      => 'menu',
                        // 'menu_id'         => '',
                        'depth'           => 0,
                        'echo'              => 'false' ,
                    );
                    $menu = wp_nav_menu($args);
                    // play with $menu
                    
                    echo $menu; 
                ?>
            </div>
        </div>
    </header>