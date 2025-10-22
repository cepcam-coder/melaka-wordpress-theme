<?php get_header(); ?>

<div id="wrapper" class="main-column">
    <main id="main">


        <div id="content" class="item-list">
            <h2 class="archive-title">
                <?php
                if (is_month()) {
                    printf(__('Archives du mois de %s'), get_the_date('F Y'));
                } elseif (is_year()) {
                    printf(__('BD de l’année %s'), get_the_date('Y'));
                }
                ?>
            </h2>
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    /** Small header before post content */
                    ?>
                    <?php if (is_day()) { ?>
                        <h2 class="post-title">
                            <img class="avatar" src="<?php echo get_template_directory_uri(); ?>/assets/css/img/melaka.png"
                                alt="avatar">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <p class="post-info">le <?php echo get_the_date('l j F Y'); ?> à <?php echo get_the_time(); ?></p>

                        <?php
                        the_content();
                        /** Comments */
                        if (comments_open() || get_comments_number()) {
                            comments_template();
                        }
                    } else { ?>
                        <div class="item">
                            <h2 class="post-title">
                                <img class="avatar" src="<?php echo get_template_directory_uri(); ?>/assets/css/img/melaka.png"
                                    alt="avatar">
                                <small>
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </small>
                            </h2>
                            <p class="post-info">
                                <?php echo get_comments_number(); ?> commentaire<?php if (get_comments_number() > 1)
                                        echo 's'; ?>
                            </p>
                            <p class="day-date"><?php echo get_the_date('l j F Y'); ?> à <?php echo get_the_time(); ?></p>
                        </div>
                    <?php } ?>

                    <?php

                endwhile;
            endif;
            ?>


        </div>
    </main>

    <div id="sidebar"><?php get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>