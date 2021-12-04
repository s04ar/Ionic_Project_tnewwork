<?php
/**
* Template part for displaying posts.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('gridmax-post-singular gridmax-post-nongrid gridmax-box'); ?>>
<div class="gridmax-box-inside">

    <?php gridmax_before_nongrid_post_title(); ?>

    <header class="entry-header">
    <div class="entry-header-inside gridmax-clearfix">
        <?php the_title( sprintf( '<h1 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

        <?php gridmax_nongrid_postmeta(); ?>
    </div>
    </header><!-- .entry-header -->

    <?php gridmax_after_nongrid_post_title(); ?>

    <div class="entry-content gridmax-clearfix">
            <?php
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
            ?>
    </div><!-- .entry-content -->

</div>
</article>