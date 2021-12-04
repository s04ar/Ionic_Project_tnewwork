<?php
/**
* The main template file.
*
* This is the most generic template file in a WordPress theme
* and one of the two required files for a theme (the other being style.css).
* It is used to display a page when nothing more specific matches a query.
* E.g., it puts together the home page when no home.php file exists.
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

<?php if ( !(gridmax_get_option('hide_posts_heading')) ) { ?>
<?php if(is_home() && !is_paged()) { ?>
<?php if ( gridmax_get_option('posts_heading') ) : ?>
<div class="gridmax-posts-header"><h2 class="gridmax-posts-heading"><span class="gridmax-posts-heading-inside"><?php echo esc_html( gridmax_get_option('posts_heading') ); ?></span></h2></div>
<?php else : ?>
<div class="gridmax-posts-header"><h2 class="gridmax-posts-heading"><span class="gridmax-posts-heading-inside"><?php esc_html_e( 'Recent Posts', 'gridmax' ); ?></span></h2></div>
<?php endif; ?>
<?php } ?>
<?php } ?>

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