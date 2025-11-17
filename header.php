<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>

    <div id="page">
        <div id="container">
        <header id="top">
            <a href="<?php echo get_home_url(); ?>">
                <!-- PARALLAX -->
                <div id="parallax" class="parallax-viewport">
                    <div class="parallax-layer parralax-1200x200">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/banner/fond_logo.png') ?>" alt=""
                          class="parralax-1200x200"/>
                    </div>
                    <div class="parallax-layer parralax-1100x200">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/banner/troisiemeplan.png') ?>" alt=""
                        class="parralax-1100x200"/>
                    </div>
                    <div class="parallax-layer parralax-1200x200">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/banner/secondplan.png') ?>" alt=""
                        class="parralax-1200x200"/>
                    </div>
                    <div class="parallax-layer parralax-980x200">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/banner/premierplan.png') ?>" alt=""
                        class="parralax-980x200"/>
                    </div>
                    <div class="parallax-layer" style="padding-left:950px;height:200px">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/random/rotate.php') ?>" alt=""                        
                    </div>
                </div>
                <!-- /PARALLAX -->
            </a>
        </header>