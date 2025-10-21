<?php get_header(); ?>

<div id = "wrapper" class="main-column">
    <main id="main">
        <div id="content">
            <?php
            if (have_posts()):
                while (have_posts()):the_post();
                /** Small header before post content */
            ?>
                    
                    <h2 class="post-title">
                        <img class="avatar" src="<?php echo get_template_directory_uri(); ?>/assets/css/img/melaka.png" alt="avatar">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
        
                    <p class="post-info">le <?php echo get_the_date('l j F Y'); ?> à <?php echo get_the_time(); ?></p>
            <?php
                    the_content();
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
                    if (get_next_posts_link()) echo ' | ';
                    previous_posts_link('entrées suivantes »');
                }
            

            ?>
            </p>
        </div>
    </main>

    <div id="sidebar"><?php get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>