<?php
/**
* The template for displaying full-width page.
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*
* Template Name: Full Width, no sidebar
* Template Post Type: page
*/

get_header(); ?>

<div class="gridmax-main-wrapper gridmax-clearfix" id="gridmax-main-wrapper" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
<div class="theiaStickySidebar">
<div class="gridmax-main-wrapper-inside gridmax-clearfix">

<?php gridmax_before_main_content(); ?>

<div class='gridmax-posts-wrapper' id='gridmax-posts-wrapper'>

<?php while (have_posts()) : the_post();

    get_template_part( 'template-parts/content', 'page' );

    // If comments are open or we have at least one comment, load up the comment template
    if ( comments_open() || get_comments_number() ) :
            comments_template();
    endif;

endwhile; ?>

<div class="clear"></div>
</div><!--/#gridmax-posts-wrapper -->

<?php gridmax_after_main_content(); ?>

</div>
</div>
</div><!-- /#gridmax-main-wrapper -->

<?php get_footer(); ?>