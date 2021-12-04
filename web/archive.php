<?php
/**
* The template for displaying archive pages.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

get_header(); ?>

<div class="gridmax-main-wrapper gridmax-clearfix" id="gridmax-main-wrapper" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
<div class="theiaStickySidebar">
<div class="gridmax-main-wrapper-inside gridmax-clearfix">

<?php gridmax_before_main_content(); ?>

<div class="gridmax-posts-wrapper" id="gridmax-posts-wrapper">

<div class="gridmax-page-header-outside">
<header class="gridmax-page-header">
<div class="gridmax-page-header-inside">
<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
</div>
</header>
</div>

<div class="gridmax-posts-content">

<?php if (have_posts()) : ?>

    <?php if ( !(gridmax_get_option('disable_posts_grid')) ) { ?>

    <div class="gridmax-posts gridmax-posts-grid">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'template-parts/content-grid' ); ?>
    <?php endwhile; ?>
    </div>

    <?php } else { ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'template-parts/content-nongrid' ); ?>
    <?php endwhile; ?>

    <?php } ?>
    <div class="clear"></div>

    <?php gridmax_posts_navigation(); ?>

<?php else : ?>

  <?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>

</div>

</div><!--/#gridmax-posts-wrapper -->

<?php gridmax_after_main_content(); ?>

</div>
</div>
</div><!-- /#gridmax-main-wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>