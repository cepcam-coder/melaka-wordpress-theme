<?php get_header(); ?>

<div id="wrapper" class="main-column">
    <main id="main">
        <div id="content">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    $post_id = get_the_ID();
                    /** Small header before post content */
                    ?>

                    <h2 id="post-<?php echo $post_id; ?>" class="post-title">
                        <img class="avatar" src="<?php echo get_template_directory_uri(); ?>/assets/css/img/melaka.png"
                            alt="avatar">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <p class="post-info">le <?php echo get_the_date('l j F Y'); ?> à <?php echo get_the_time(); ?></p>
                    <?php the_content(); ?>

                    <p class="post-info-co">
                        <span class="haut">
                            <a href="#post-<?php echo $post_id; ?>">Haut de l'article</a>
                        </span>
                        <a class="comment_count" href="<?php echo get_comments_link(); ?>"><?php echo get_comments_number(); ?>
                            commentaire<?php if (get_comments_number() > 1)
                                echo 's'; ?>
                        </a>

                        
                        <span>
                        <?php
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) {
                            foreach ( $categories as $category ) {
                                if ( $category->slug == 'uncategorized' ) {
                                    continue;
                                }
                                if ( $category->slug == 'non-classe' ) {
                                    continue;
                                }
                            echo '<a class="category-link"  href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a> ';
                            }
                            }
                        ?>
                        </span>

                    </p>
                <?php endwhile;
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

    <div id="sidebar"><?php get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>