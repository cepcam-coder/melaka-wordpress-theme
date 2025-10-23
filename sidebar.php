<aside>

    <div id="blognav">

        <section class="sidebar-section">
            <?php get_search_form(); ?>
        </section>
        <hr class="doodle-separator doodle-1">


        <section class="sidebar-section">
            <h4 class="brown">Archives</h4>
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
                <details class="archive-year">

                    <summary><?php echo $year ?></summary>
                    <ul>
                        <?php foreach ($months as $month => $posts) { ?>
                            <li><a href="<?php echo esc_url(get_month_link($year, $month)); ?>">
                                    <?php echo date_i18n('F', mktime(0, 0, 0, $month, 1)); ?>
                                    (<?php echo count($posts); ?>)
                                </a></li>
                        <?php } // ends foreach for $months ?>
                    </ul>
                </details>
                <?php
            } // ends foreach for $ordered_posts
            ?>
        </section>
        <hr class="doodle-separator doodle-2">


        <section class="sidebar-section">
            <h2>Albums</h2>
            <?php comics_list(3) ?>
        </section>
        <hr class="doodle-separator doodle-3">


        <section class="sidebar-section">
            <p><a href="https://bd.laec.fr" target="_blank"
                    title="le programme de l'Union Populaire en BD, par Mélaka &amp; Reno">Pour lire la BD "l'Avenir en
                    commun ?", cliquez ici !</a></p>
        </section>
        <section class="sidebar-section">
            <p>Pour télécharger le PDF en haute définition de la BD "L'Avenir en commun ?", cliquez sur l'image !</p>

            <figure style="float: left; margin: 0 1em 1em 0;"><a class="laec"
                    href="https://melaka.free.fr/JLM2017/LAECBD2022.pdf">
                </a>

                <figcaption>laecBDmini.png, fév. 2022</figcaption>
            </figure>
        </section>
        <section class="sidebar-section">
            <div class="widget text">
                <h2>Abonnez-vous !</h2>
                <p><strong>&nbsp;</strong><span class="mazette"></span><a
                        href="https://melaka.free.fr/imagesweb/dossierpresse.pdf">C'est quoi, Mazette ?</a></p>

                <p><a href="https://mazette.media">Mazette a cessé de paraître, mais tous les numéros sont consultables
                        en cliquant ici</a></p>
            </div>
        </section>
        <hr class="doodle-separator doodle-4">

        <section class="sidebar-section">
            <p><br id="sites">
                <a class="tipee" href="https://www.tipeee.com/melakarnets"></a>
            </p>
        </section>
        <hr class="doodle-separator doodle-5">

        <section class="sidebar-section">
            <?php blogroll(); ?>
        </section>
        <hr class="doodle-separator doodle-6">


        <section class="sidebar-section">
            <h2><a href="mailto:melaka@mazette.media">Contact</a></h2>
            <?php get_social_links() ?>
        </section>
        <hr class="doodle-separator doodle-7">

        <section class="sidebar-section">
            <h2>S'abonner</h2>
            <p>
                <a href="<?php bloginfo('rss2_url'); ?>" title="Flux RSS des articles" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/css/img/rss-icon.png"
                        alt="RSS Articles" style="width:16px;height:16px;">
                    Flux RSS des articles
                </a>
            </p>
            <p>
                <a href="<?php bloginfo('comments_rss2_url'); ?>" title="Flux RSS des commentaires" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/css/img/rss-icon.png"
                        alt="RSS Commentaires" style="width:16px;height:16px;">
                    Flux RSS des commentaires
                </a>
            </p>
        </section>
        <hr class="doodle-separator doodle-8">

    </div>
</aside>