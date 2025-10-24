<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>

    <div id="page">
        <header id="top">
            <a href="index.php">
                <!-- PARALLAX -->
                <div id="parallax" class="parallax-viewport">
                    <div class="parallax-layer" style="width:1000px; height:200px;">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/banner/melaka_banner_1.png') ?>" alt=""
                            style="width:1000px; height:200px;" />
                    </div>
                    <div class="parallax-layer" style="width:1100px; height:200px;">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/banner/melaka_banner_2.png') ?>" alt=""
                            style="width:1100px; height:200px;" />
                    </div>
                    <div class="parallax-layer" style="width:1200px; height:200px;">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/banner/melaka_banner_3.png') ?>" alt=""
                            style="width:1200px; height:200px;" />
                    </div>
                    <div class="parallax-layer" style="padding-left:890px;height:200px">
                        <img src="<?php echo get_theme_file_uri('/assets/css/img/random/rotate.php') ?>" alt=""                        
                    </div>
                </div>
                <!-- /PARALLAX -->
            </a>
        </header>