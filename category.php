<?php
/**
 * The template for displaying category archives
 *
 * @package CozyRecipes
 */

get_header();
?>

<div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
    <div class="content-wrapper <?php echo cozyrecipes_show_sidebar() ? '' : 'no-sidebar'; ?>">
        <main id="primary" class="main-content">

            <?php if ( have_posts() ) : ?>

                <header class="archive-header">
                    <?php
                    $category = get_queried_object();
                    ?>
                    <div class="category-icon" style="font-size: 4rem; margin-bottom: 1rem;">
                        <?php echo esc_html( cozyrecipes_get_category_icon( $category->name ) ); ?>
                    </div>
                    <h1 class="archive-title"><?php single_cat_title(); ?></h1>
                    <?php
                    $category_description = category_description();
                    if ( $category_description ) :
                    ?>
                        <div class="archive-description"><?php echo $category_description; ?></div>
                    <?php endif; ?>
                </header>

                <div class="posts-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile;
                    ?>
                </div>

                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( '← Previous', 'cozyrecipes' ),
                    'next_text' => __( 'Next →', 'cozyrecipes' ),
                ) );

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif;
            ?>

        </main>

        <?php
        if ( cozyrecipes_show_sidebar() ) {
            get_sidebar();
        }
        ?>
    </div>
</div>

<?php
get_footer();
