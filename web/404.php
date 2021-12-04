<?php
/**
* The template for displaying 404 pages (not found).
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

get_header(); ?>

<div class='gridmax-main-wrapper gridmax-clearfix' id='gridmax-main-wrapper' itemscope='itemscope' itemtype='http://schema.org/Blog' role='main'>
<div class='theiaStickySidebar'>
<div class="gridmax-main-wrapper-inside gridmax-clearfix">

<div class='gridmax-posts-wrapper' id='gridmax-posts-wrapper'>

<div class='gridmax-posts gridmax-box'>
<div class="gridmax-box-inside">

<div class="gridmax-page-header-outside">
<header class="gridmax-page-header">
<div class="gridmax-page-header-inside">
    <?php if ( gridmax_get_option('error_404_heading') ) : ?>
    <h1 class="page-title"><?php echo esc_html( gridmax_get_option('error_404_heading') ); ?></h1>
    <?php else : ?>
    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'gridmax' ); ?></h1>
    <?php endif; ?>
</div>
</header><!-- .gridmax-page-header -->
</div>

<div class='gridmax-posts-content'>

    <?php if ( gridmax_get_option('error_404_message') ) : ?>
    <p><?php echo wp_kses_post( force_balance_tags( gridmax_get_option('error_404_message') ) ); ?></p>
    <?php else : ?>
    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'gridmax' ); ?></p>
    <?php endif; ?>

    <?php if ( !(gridmax_get_option('hide_404_search')) ) { ?><?php get_search_form(); ?><?php } ?>

</div>

</div>
</div>

</div><!--/#gridmax-posts-wrapper -->

<?php gridmax_404_widgets(); ?>

</div>
</div>
</div><!-- /#gridmax-main-wrapper -->

<?php get_footer(); ?>