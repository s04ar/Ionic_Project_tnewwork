<?php
/**
* Template part for displaying single posts.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<?php gridmax_before_single_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('gridmax-post-singular gridmax-box'); ?>>
<div class="gridmax-box-inside">

    <?php gridmax_before_single_post_title(); ?>

    <?php if ( !(gridmax_get_option('hide_post_title')) ) { ?>
    <header class="entry-header">
    <div class="entry-header-inside gridmax-clearfix">
        <?php if ( gridmax_get_option('remove_post_title_link') ) { ?>
            <?php the_title( '<h1 class="post-title entry-title">', '</h1>' ); ?>
        <?php } else { ?>
            <?php the_title( sprintf( '<h1 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
        <?php } ?>

        <?php gridmax_single_postmeta(); ?>
    </div>
    </header><!-- .entry-header -->
    <?php } ?>

    <?php gridmax_after_single_post_title(); ?>

    <div class="entry-content gridmax-clearfix">
            <?php
            gridmax_top_single_post_content();

            the_content( sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="gridmax-sr-only"> "%s"</span> <span class="meta-nav">&rarr;</span>', 'gridmax' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ) );

            wp_link_pages( array(
             'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'gridmax' ) . '</span>',
             'after'       => '</div>',
             'link_before' => '<span>',
             'link_after'  => '</span>',
             ) );

            gridmax_bottom_single_post_content();
            ?>
    </div><!-- .entry-content -->

    <?php gridmax_after_single_post_content(); ?>

    <?php if ( !(gridmax_get_option('hide_author_bio_box')) ) { echo wp_kses_post( force_balance_tags( gridmax_add_author_bio_box() ) ); } ?>

    <?php if ( !(gridmax_get_option('hide_post_tags')) ) { ?>
    <?php if ( has_tag() ) { ?>
    <footer class="entry-footer gridmax-entry-footer">
    <div class="gridmax-entry-footer-inside">
        <?php gridmax_post_tags(); ?>
    </div>
    </footer><!-- .entry-footer -->
    <?php } ?>
    <?php } ?>
</div>
</article>

<?php gridmax_after_single_post(); ?>