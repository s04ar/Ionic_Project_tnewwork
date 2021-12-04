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

<?php $gridmax_grid_post_content = get_the_content(); ?>
<div id="post-<?php the_ID(); ?>" class="gridmax-grid-post gridmax-4-col">
<div class="gridmax-grid-post-inside">

    <?php gridmax_media_content_grid(); ?>

    <?php if ( !(gridmax_get_option('hide_post_categories_home')) ) { gridmax_grid_cats(); } ?>

    <?php if ( !(gridmax_get_option('hide_post_title_home')) || !(gridmax_get_option('hide_post_snippet')) ) { ?>
    <div class="gridmax-grid-post-details gridmax-grid-post-block">
    <?php if ( !(gridmax_get_option('hide_post_title_home')) ) { ?><?php the_title( sprintf( '<h3 class="gridmax-grid-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?><?php } ?>

    <?php if ( !(gridmax_get_option('hide_post_snippet')) ) { ?><?php if ( !empty( $gridmax_grid_post_content ) ) { ?><div class="gridmax-grid-post-snippet"><div class="gridmax-grid-post-snippet-inside"><?php the_excerpt(); ?></div></div><?php } ?><?php } ?>
    </div>
    <?php } ?>

    <?php gridmax_grid_postmeta(); ?>

</div>
</div>