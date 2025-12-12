<?php
/**
 * The template for displaying comments
 *
 * @package CozyRecipes
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            printf(
                _n( '%s Comment', '%s Comments', $comment_count, 'cozyrecipes' ),
                number_format_i18n( $comment_count )
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if ( ! comments_open() ) :
        ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'cozyrecipes' ); ?></p>
        <?php
        endif;

    endif;

    comment_form();
    ?>

</div>
