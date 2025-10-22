<aside>

    <div id="blognav">

        <section class="sidebar-section">
            <?php get_search_form(); ?>
        </section>
        <hr class="doodle-separator doodle-1">


        <section class="sidebar-section">
            <h4>Archives</h4>
            <?php
            $all_posts = get_posts(array(
                'posts_per_page' => -1 // to show all posts
            ));

            // this variable will contain all the posts in a associative array
            // with three levels, for every year, month and posts.          
            
            $ordered_posts = array();

            foreach ($all_posts as $single) {

                $year = mysql2date('Y', $single->post_date);
                $month = mysql2date('n', $single->post_date);

                // specifies the position of the current post
                $ordered_posts[$year][$month][] = $single;

            }

            // iterates the years
            foreach ($ordered_posts as $year => $months) { ?>
                <details>

                    <summary><?php echo $year ?></summary>
                    <?php foreach ($months as $month => $posts) { ?>
                        <a href="<?php echo esc_url(get_month_link($year, $month)); ?>">
                            <?php echo date_i18n('F', mktime(0, 0, 0, $month, 1)); ?>
                            (<?php echo count($posts); ?>)
                        </a>
                    <?php } // ends foreach for $months ?>

                </details>
                <?php
            } // ends foreach for $ordered_posts
            ?>
        </section>
        <hr class="doodle-separator doodle-2">


        <section class="sidebar-section">
            <?php comics_list(2) ?>
        </section>
        <hr class="doodle-separator doodle-3">


        <section class="sidebar-section">
            <h4> L'avenir en commun et mazette</h4>
        </section>
        <hr class="doodle-separator doodle-4">

        <section class="sidebar-section">
            <h4>Mon tipee</h4>
        </section>
        <hr class="doodle-separator doodle-5">

        <section class="sidebar-section">
            <h4>Liens vers mes amis</h4>
        </section>
        <hr class="doodle-separator doodle-6">


        <section class="sidebar-section">
            <h4>Réseaux socaux, rss et contact</h4>
        </section>
        <hr class="doodle-separator doodle-7">

    </div>
</aside>