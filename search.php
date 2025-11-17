<?php get_header(); ?>

<div id="wrapper" class="main-column">
    <main id="main">
        <div id="content" class="item-list">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    /** Small header before post content */
                    ?>
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
                    <?php

                endwhile;
            endif;
            ?>
            <p class="pagination">
                <?php
                global $wp_query;

                $total_pages = $wp_query->max_num_pages;
                $current_page = max(1, get_query_var('paged'));
                if (get_next_posts_link()) {
                    next_posts_link('« entrées précédentes');
                }
                echo ' - page ' . $current_page . ' de ' . $total_pages;
                if (get_previous_posts_link()) {
                    if (get_next_posts_link())
                        echo ' | ';
                    previous_posts_link('entrées suivantes »');
                }


                ?>
            </p>
        </div>
    </main>

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>