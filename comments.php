<?php
if ( post_password_required() ) {
    return; 
}
?>
<div id="comments">

<?php if ( comments_open() ) : ?>
    <div id="respond">
        <h4>Laisser un commentaire</h4>
        <?php comment_form(array(
            'title_reply' => '',
            'comment_notes_after' => '',
            'label_submit' => 'Envoyer'
        )); ?>
    </div>
<?php endif; ?>

<h3>Commentaires</h3>

<?php if ( have_comments() ) : ?>
    <dl class="comment-list">
        <?php
        $count = 0;
        wp_list_comments(array(
            'style'       => 'dl',
            'short_ping'  => true,
            'avatar_size' => 0,
            'callback'    => function($comment, $args, $depth) use (&$count) {
                $GLOBALS['comment'] = $comment;
                $count++;
                ?>
                <dt id="c<?php comment_ID(); ?>" class="<?php echo ($count % 2 == 1 ? 'odd' : 'even') . ($count == 1 ? ' first' : ''); ?>">
                    <a href="#c<?php comment_ID(); ?>" class="comment-number"><?php echo $count; ?>.</a>
                    <?php printf(
                        'Le %1$s, %2$s par %3$s',
                        get_comment_date('l j F Y'),
                        get_comment_time(),
                        get_comment_author()
                    ); ?>
                </dt>
                <dd class="<?php echo ($count % 2 == 1 ? 'odd' : 'even') . ($count == 1 ? ' first' : ''); ?>">
                    <?php comment_text(); ?>
                </dd>
                <?php
            },
        )); 
        ?>
    </dl>
<?php endif; ?>

</div>