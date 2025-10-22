<aside>

    <div id="blognav">

        <section class="sidebar-section">
        <?php get_search_form(); ?>
        </section>
        <hr class="doodle-separator doodle-1">

        
        <h4>Archives</h4>
        <ul>
            <?php wp_get_archives(array('type' => 'monthly', 'limit' => 18)); ?>
        </ul>
    </div>

    <div id="blogextra">
        <?php comics_list(2) ?>
    </div>
</aside>