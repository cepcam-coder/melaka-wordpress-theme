<?php get_header(); ?>

<div id = "wrapper" class="main-column">
    <main id="main">
        <div id="content">

        <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            /** When in a single post, nav is a table. Could be a grid */
        ?>
        
        <table id="navlinks" border="0" width="100%" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        <?php if ( $prev_post ) : ?>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>" 
                            title="<?php echo esc_attr(get_the_title($prev_post->ID)); ?>" 
                            class="prev">◄ <?php echo get_the_title($prev_post->ID); ?></a>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:right">
                        <?php if ( $next_post ) : ?>
                            <a href="<?php echo get_permalink($next_post->ID); ?>" 
                            title="<?php echo esc_attr(get_the_title($next_post->ID)); ?>" 
                            class="next"><?php echo get_the_title($next_post->ID); ?> ►</a>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>


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
            <?php
                /** Comments */
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
            ?>

        </div>
    </main>

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>