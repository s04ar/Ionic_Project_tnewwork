<?php
/**
* The header for GridMax theme.
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="gridmax-body" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#gridmax-content-wrapper"><?php esc_html_e( 'Skip to content', 'gridmax' ); ?></a>

<?php gridmax_before_header(); ?>

<?php gridmax_header_image(); ?>

<div class="gridmax-site-header gridmax-container" id="gridmax-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
<div class="gridmax-head-content gridmax-clearfix" id="gridmax-head-content">

<?php if ( gridmax_is_header_content_active() ) { ?>
<div class="gridmax-header-inside gridmax-clearfix">
<div class="gridmax-header-inside-content gridmax-clearfix">
<div class="gridmax-outer-wrapper">
<div class="gridmax-header-inside-container">

<div class="gridmax-logo">
<?php if ( has_custom_logo() ) : ?>
    <div class="site-branding">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="gridmax-logo-img-link">
        <img src="<?php echo esc_url( gridmax_custom_logo() ); ?>" alt="" class="gridmax-logo-img"/>
    </a>
    <div class="gridmax-custom-logo-info"><?php gridmax_site_title(); ?></div>
    </div>
<?php else: ?>
    <div class="site-branding">
      <?php gridmax_site_title(); ?>
    </div>
<?php endif; ?>
</div>

<?php if ( gridmax_is_primary_menu_active() ) { ?>
<div class="gridmax-header-menu">
<div class="gridmax-container gridmax-primary-menu-container gridmax-clearfix">
<div class="gridmax-primary-menu-container-inside gridmax-clearfix">
<nav class="gridmax-nav-primary" id="gridmax-primary-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'gridmax' ); ?>">
<button class="gridmax-primary-responsive-menu-icon" aria-controls="gridmax-menu-primary-navigation" aria-expanded="false"><?php esc_html_e( 'Menu', 'gridmax' ); ?></button>
<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'gridmax-menu-primary-navigation', 'menu_class' => 'gridmax-primary-nav-menu gridmax-menu-primary', 'fallback_cb' => 'gridmax_fallback_menu', 'container' => '', ) ); ?>
</nav>
</div>
</div>
</div>
<?php } ?>

</div>
</div>
</div>
</div>
<?php } else { ?>
<div class="gridmax-no-header-content">
  <?php gridmax_site_title(); ?>
</div>
<?php } ?>

</div><!--/#gridmax-head-content -->
</div><!--/#gridmax-header -->

<?php if ( !(gridmax_get_option('hide_header_search_button')) ) { ?>
<div id="gridmax-search-overlay-wrap" class="gridmax-search-overlay">
  <div class="gridmax-search-overlay-content">
    <?php get_search_form(); ?>
  </div>
  <button class="gridmax-search-closebtn" aria-label="<?php esc_attr_e( 'Close Search', 'gridmax' ); ?>" title="<?php esc_attr_e('Close Search','gridmax'); ?>">&#xD7;</button>
</div>
<?php } ?>

<?php gridmax_after_header(); ?>

<div id="gridmax-header-end"></div>

<?php gridmax_top_wide_widgets(); ?>

<?php gridmax_top_left_right_widgets(); ?>

<div class="gridmax-outer-wrapper" id="gridmax-wrapper-outside">

<div class="gridmax-container gridmax-clearfix" id="gridmax-wrapper">
<div class="gridmax-content-wrapper gridmax-clearfix" id="gridmax-content-wrapper">