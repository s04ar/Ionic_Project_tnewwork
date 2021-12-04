<?php
/**
* Theme Functions
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

/**
 * This function return a value of given theme option name from database.
 *
 * @since 1.0.0
 *
 * @param string $option Theme option to return.
 * @return mixed The value of theme option.
 */
function gridmax_get_option($option) {
    $gridmax_options = get_option('gridmax_options');
    if ((is_array($gridmax_options)) && (array_key_exists($option, $gridmax_options))) {
        return $gridmax_options[$option];
    }
    else {
        return '';
    }
}

function gridmax_is_option_set($option) {
    $gridmax_options = get_option('gridmax_options');
    if ((is_array($gridmax_options)) && (array_key_exists($option, $gridmax_options))) {
        return true;
    } else {
        return false;
    }
}

if ( ! function_exists( 'gridmax_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function gridmax_setup() {
    
    global $wp_version;

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on GridMax, use a find and replace
     * to change 'gridmax' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'gridmax', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );

    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( 'gridmax-1250w-autoh-image', 1250, 9999, false );
        add_image_size( 'gridmax-900w-autoh-image', 900, 9999, false );
        add_image_size( 'gridmax-480w-360h-image', 480, 360, true );
    }

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
    'primary' => esc_html__('Primary Menu', 'gridmax')
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    $markup = array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' );
    add_theme_support( 'html5', $markup );

    add_theme_support( 'custom-logo', array(
        'height'      => 37,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

    // Support for Custom Header
    add_theme_support( 'custom-header', apply_filters( 'gridmax_custom_header_args', array(
    'default-image'          => '',
    'default-text-color'     => '000000',
    'width'                  => 1920,
    'height'                 => 400,
    'flex-width'            => true,
    'flex-height'            => true,
    'wp-head-callback'       => 'gridmax_header_style',
    'uploads'                => true,
    ) ) );

    // Set up the WordPress core custom background feature.
    $background_args = array(
            'default-color'          => 'ffffff',
            'default-image'          => '',
            'default-repeat'         => 'repeat',
            'default-position-x'     => 'left',
            'default-position-y'     => 'top',
            'default-size'     => 'auto',
            'default-attachment'     => 'fixed',
            'wp-head-callback'       => '_custom_background_cb',
            'admin-head-callback'    => 'admin_head_callback_func',
            'admin-preview-callback' => 'admin_preview_callback_func',
    );
    add_theme_support( 'custom-background', apply_filters( 'gridmax_custom_background_args', $background_args) );
    
    // Support for Custom Editor Style
    add_editor_style( 'css/editor-style.css' );

}
endif;
add_action( 'after_setup_theme', 'gridmax_setup' );

/**
* Layout Functions
*/

function gridmax_hide_footer_widgets() {
    $hide_footer_widgets = FALSE;
    if ( gridmax_get_option('hide_footer_widgets') ) {
        $hide_footer_widgets = TRUE;
    }
    return apply_filters( 'gridmax_hide_footer_widgets', $hide_footer_widgets );
}

function gridmax_is_header_content_active() {
    $header_content_active = TRUE;
    if ( gridmax_get_option('hide_header_content') ) {
        $header_content_active = FALSE;
    }
    return apply_filters( 'gridmax_is_header_content_active', $header_content_active );
}

function gridmax_is_primary_menu_active() {
    $primary_menu_active = TRUE;
    if ( gridmax_get_option('disable_primary_menu') ) {
        $primary_menu_active = FALSE;
    }
    return apply_filters( 'gridmax_is_primary_menu_active', $primary_menu_active );
}

function gridmax_is_footer_social_buttons_active() {
    $footer_social_buttons_active = TRUE;
    if ( gridmax_get_option('hide_footer_social_buttons') ) {
        $footer_social_buttons_active = FALSE;
    }
    return apply_filters( 'gridmax_is_footer_social_buttons_active', $footer_social_buttons_active );
}

function gridmax_is_fitvids_active() {
    $fitvids_active = TRUE;
    if ( gridmax_get_option('disable_fitvids') ) {
        $fitvids_active = FALSE;
    }
    return apply_filters( 'gridmax_is_fitvids_active', $fitvids_active );
}

function gridmax_is_backtotop_active() {
    $backtotop_active = TRUE;
    if ( gridmax_get_option('disable_backtotop') ) {
        $backtotop_active = FALSE;
    }
    return apply_filters( 'gridmax_is_backtotop_active', $backtotop_active );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gridmax_content_width() {
    $content_width = 900;

    if ( is_singular() ) {
        if ( is_page_template( array( 'template-full-width-page.php', 'template-full-width-post.php' ) ) ) {
           $content_width = 1250;
        } else {
            $content_width = 900;
        }
    } else {
        $content_width = 1250;
    }

    $GLOBALS['content_width'] = apply_filters( 'gridmax_content_width', $content_width ); /* phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound */
}
add_action( 'template_redirect', 'gridmax_content_width', 0 );


/**
* Register widget area.
*
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
*/

function gridmax_widgets_init() {

register_sidebar(array(
    'id' => 'gridmax-sidebar-one',
    'name' => esc_html__( 'Sidebar 1 Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located on the left-hand side of your web page.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-side-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-home-fullwidth-top-widgets',
    'name' => esc_html__( 'Top Full Width Widgets (Default HomePage)', 'gridmax' ),
    'description' => esc_html__( 'This full-width widget area is located after the header of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-fullwidth-top-widgets',
    'name' => esc_html__( 'Top Full Width Widgets (Everywhere)', 'gridmax' ),
    'description' => esc_html__( 'This full-width widget area is located after the header of your website. Widgets of this widget area are displayed on every page of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-home-left-top-widgets',
    'name' => esc_html__( 'Top Left Widgets (Default HomePage)', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the left top of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-left-top-widgets',
    'name' => esc_html__( 'Top Left Widgets (Everywhere)', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the left top of your website. Widgets of this widget area are displayed on every page of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-home-right-top-widgets',
    'name' => esc_html__( 'Top Right Widgets (Default HomePage)', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the right top of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-right-top-widgets',
    'name' => esc_html__( 'Top Right Widgets (Everywhere)', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the right top of your website. Widgets of this widget area are displayed on every page of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-home-top-widgets',
    'name' => esc_html__( 'Above Content Widgets (Default HomePage)', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the top of the main content (above posts) of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-top-widgets',
    'name' => esc_html__( 'Above Content Widgets (Everywhere)', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the top of the main content (above posts) of your website. Widgets of this widget area are displayed on every page of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-home-bottom-widgets',
    'name' => esc_html__( 'Below Content Widgets (Default HomePage)', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the bottom of the main content (below posts) of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-bottom-widgets',
    'name' => esc_html__( 'Below Content Widgets (Everywhere)', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the bottom of the main content (below posts) of your website. Widgets of this widget area are displayed on every page of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-home-fullwidth-bottom-widgets',
    'name' => esc_html__( 'Bottom Full Width Widgets (Default HomePage)', 'gridmax' ),
    'description' => esc_html__( 'This full-width widget area is located before the footer of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-fullwidth-bottom-widgets',
    'name' => esc_html__( 'Bottom Full Width Widgets (Everywhere)', 'gridmax' ),
    'description' => esc_html__( 'This full-width widget area is located before the footer of your website. Widgets of this widget area are displayed on every page of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-single-post-bottom-widgets',
    'name' => esc_html__( 'Single Post Bottom Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located at the bottom of single post of any post type (except attachments and pages).', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

register_sidebar(array(
    'id' => 'gridmax-top-footer',
    'name' => esc_html__( 'Footer Top Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located on the top of the footer of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridmax-footer-1',
    'name' => esc_html__( 'Footer 1 Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is the column 1 of the footer of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridmax-footer-2',
    'name' => esc_html__( 'Footer 2 Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is the column 2 of the footer of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridmax-footer-3',
    'name' => esc_html__( 'Footer 3 Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is the column 3 of the footer of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridmax-footer-4',
    'name' => esc_html__( 'Footer 4 Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is the column 4 of the footer of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridmax-bottom-footer',
    'name' => esc_html__( 'Footer Bottom Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located on the bottom of the footer of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridmax-404-widgets',
    'name' => esc_html__( '404 Page Widgets', 'gridmax' ),
    'description' => esc_html__( 'This widget area is located on the 404(not found) page of your website.', 'gridmax' ),
    'before_widget' => '<div id="%1$s" class="gridmax-main-widget widget gridmax-widget-box %2$s"><div class="gridmax-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridmax-widget-header"><h2 class="gridmax-widget-title"><span class="gridmax-widget-title-inside">',
    'after_title' => '</span></h2></div>'));

}
add_action( 'widgets_init', 'gridmax_widgets_init' );


function gridmax_sidebar_one_widgets() {
    dynamic_sidebar( 'gridmax-sidebar-one' );
}

function gridmax_top_wide_widgets() { ?>

<?php if ( is_active_sidebar( 'gridmax-home-fullwidth-top-widgets' ) || is_active_sidebar( 'gridmax-fullwidth-top-widgets' ) ) : ?>
<div class="gridmax-outer-wrapper">
<div class="gridmax-top-wrapper-outer gridmax-clearfix">
<div class="gridmax-featured-posts-area gridmax-top-wrapper gridmax-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridmax-home-fullwidth-top-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridmax-fullwidth-top-widgets' ); ?>
</div>
</div>
</div>
<?php endif; ?>

<?php }


function gridmax_top_left_right_widgets() { ?>

<div class="gridmax-outer-wrapper">
<div class="gridmax-left-right-wrapper gridmax-clearfix">

<?php if ( is_active_sidebar( 'gridmax-home-left-top-widgets' ) || is_active_sidebar( 'gridmax-left-top-widgets' ) ) : ?>
<div class="gridmax-left-top-wrapper">
<div class="gridmax-top-wrapper-outer gridmax-clearfix">
<div class="gridmax-featured-posts-area gridmax-top-wrapper gridmax-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridmax-home-left-top-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridmax-left-top-widgets' ); ?>
</div>
</div>
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'gridmax-home-right-top-widgets' ) || is_active_sidebar( 'gridmax-right-top-widgets' ) ) : ?>
<div class="gridmax-right-top-wrapper">
<div class="gridmax-top-wrapper-outer gridmax-clearfix">
<div class="gridmax-featured-posts-area gridmax-top-wrapper gridmax-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridmax-home-right-top-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridmax-right-top-widgets' ); ?>
</div>
</div>
</div>
<?php endif; ?>

</div>
</div>

<?php }


function gridmax_bottom_wide_widgets() { ?>

<?php if ( is_active_sidebar( 'gridmax-home-fullwidth-bottom-widgets' ) || is_active_sidebar( 'gridmax-fullwidth-bottom-widgets' ) ) : ?>
<div class="gridmax-outer-wrapper">
<div class="gridmax-bottom-wrapper-outer gridmax-clearfix">
<div class="gridmax-featured-posts-area gridmax-bottom-wrapper gridmax-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridmax-home-fullwidth-bottom-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridmax-fullwidth-bottom-widgets' ); ?>
</div>
</div>
</div>
<?php endif; ?>

<?php }


function gridmax_top_widgets() { ?>

<?php if ( is_active_sidebar( 'gridmax-home-top-widgets' ) || is_active_sidebar( 'gridmax-top-widgets' ) ) : ?>
<div class="gridmax-featured-posts-area gridmax-featured-posts-area-top gridmax-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridmax-home-top-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridmax-top-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function gridmax_bottom_widgets() { ?>

<?php if ( is_active_sidebar( 'gridmax-home-bottom-widgets' ) || is_active_sidebar( 'gridmax-bottom-widgets' ) ) : ?>
<div class='gridmax-featured-posts-area gridmax-featured-posts-area-bottom gridmax-clearfix'>
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridmax-home-bottom-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridmax-bottom-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function gridmax_404_widgets() { ?>

<?php if ( is_active_sidebar( 'gridmax-404-widgets' ) ) : ?>
<div class="gridmax-featured-posts-area gridmax-featured-posts-area-top gridmax-clearfix">
<?php dynamic_sidebar( 'gridmax-404-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function gridmax_post_bottom_widgets() {
    if ( is_singular() ) {
        if ( is_active_sidebar( 'gridmax-single-post-bottom-widgets' ) ) : ?>
            <div class="gridmax-featured-posts-area gridmax-clearfix">
            <?php dynamic_sidebar( 'gridmax-single-post-bottom-widgets' ); ?>
            </div>
        <?php endif;
    }
}


/**
* Social buttons
*/

function gridmax_footer_social_buttons() { ?>

<div class='gridmax-footer-social-icons'>
    <?php if ( gridmax_get_option('twitterlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('twitterlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-twitter" aria-label="<?php esc_attr_e('Twitter Button','gridmax'); ?>"><i class="fab fa-twitter" aria-hidden="true" title="<?php esc_attr_e('Twitter','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('facebooklink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('facebooklink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-facebook" aria-label="<?php esc_attr_e('Facebook Button','gridmax'); ?>"><i class="fab fa-facebook-f" aria-hidden="true" title="<?php esc_attr_e('Facebook','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('googlelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('googlelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-google-plus" aria-label="<?php esc_attr_e('Google Plus Button','gridmax'); ?>"><i class="fab fa-google-plus-g" aria-hidden="true" title="<?php esc_attr_e('Google Plus','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('pinterestlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('pinterestlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-pinterest" aria-label="<?php esc_attr_e('Pinterest Button','gridmax'); ?>"><i class="fab fa-pinterest" aria-hidden="true" title="<?php esc_attr_e('Pinterest','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('linkedinlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('linkedinlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-linkedin" aria-label="<?php esc_attr_e('Linkedin Button','gridmax'); ?>"><i class="fab fa-linkedin-in" aria-hidden="true" title="<?php esc_attr_e('Linkedin','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('instagramlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('instagramlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-instagram" aria-label="<?php esc_attr_e('Instagram Button','gridmax'); ?>"><i class="fab fa-instagram" aria-hidden="true" title="<?php esc_attr_e('Instagram','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('flickrlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('flickrlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-flickr" aria-label="<?php esc_attr_e('Flickr Button','gridmax'); ?>"><i class="fab fa-flickr" aria-hidden="true" title="<?php esc_attr_e('Flickr','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('youtubelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('youtubelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-youtube" aria-label="<?php esc_attr_e('Youtube Button','gridmax'); ?>"><i class="fab fa-youtube" aria-hidden="true" title="<?php esc_attr_e('Youtube','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('vimeolink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('vimeolink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-vimeo" aria-label="<?php esc_attr_e('Vimeo Button','gridmax'); ?>"><i class="fab fa-vimeo-v" aria-hidden="true" title="<?php esc_attr_e('Vimeo','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('soundcloudlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('soundcloudlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-soundcloud" aria-label="<?php esc_attr_e('SoundCloud Button','gridmax'); ?>"><i class="fab fa-soundcloud" aria-hidden="true" title="<?php esc_attr_e('SoundCloud','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('messengerlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('messengerlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-messenger" aria-label="<?php esc_attr_e('Messenger Button','gridmax'); ?>"><i class="fab fa-facebook-messenger" aria-hidden="true" title="<?php esc_attr_e('Messenger','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('whatsapplink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('whatsapplink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-whatsapp" aria-label="<?php esc_attr_e('WhatsApp Button','gridmax'); ?>"><i class="fab fa-whatsapp" aria-hidden="true" title="<?php esc_attr_e('WhatsApp','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('lastfmlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('lastfmlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-lastfm" aria-label="<?php esc_attr_e('Lastfm Button','gridmax'); ?>"><i class="fab fa-lastfm" aria-hidden="true" title="<?php esc_attr_e('Lastfm','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('mediumlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('mediumlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-medium" aria-label="<?php esc_attr_e('Medium Button','gridmax'); ?>"><i class="fab fa-medium-m" aria-hidden="true" title="<?php esc_attr_e('Medium','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('githublink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('githublink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-github" aria-label="<?php esc_attr_e('Github Button','gridmax'); ?>"><i class="fab fa-github" aria-hidden="true" title="<?php esc_attr_e('Github','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('bitbucketlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('bitbucketlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-bitbucket" aria-label="<?php esc_attr_e('Bitbucket Button','gridmax'); ?>"><i class="fab fa-bitbucket" aria-hidden="true" title="<?php esc_attr_e('Bitbucket','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('tumblrlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('tumblrlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-tumblr" aria-label="<?php esc_attr_e('Tumblr Button','gridmax'); ?>"><i class="fab fa-tumblr" aria-hidden="true" title="<?php esc_attr_e('Tumblr','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('digglink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('digglink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-digg" aria-label="<?php esc_attr_e('Digg Button','gridmax'); ?>"><i class="fab fa-digg" aria-hidden="true" title="<?php esc_attr_e('Digg','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('deliciouslink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('deliciouslink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-delicious" aria-label="<?php esc_attr_e('Delicious Button','gridmax'); ?>"><i class="fab fa-delicious" aria-hidden="true" title="<?php esc_attr_e('Delicious','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('stumblelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('stumblelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-stumbleupon" aria-label="<?php esc_attr_e('Stumbleupon Button','gridmax'); ?>"><i class="fab fa-stumbleupon" aria-hidden="true" title="<?php esc_attr_e('Stumbleupon','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('mixlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('mixlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-mix" aria-label="<?php esc_attr_e('Mix Button','gridmax'); ?>"><i class="fab fa-mix" aria-hidden="true" title="<?php esc_attr_e('Mix','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('redditlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('redditlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-reddit" aria-label="<?php esc_attr_e('Reddit Button','gridmax'); ?>"><i class="fab fa-reddit" aria-hidden="true" title="<?php esc_attr_e('Reddit','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('dribbblelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('dribbblelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-dribbble" aria-label="<?php esc_attr_e('Dribbble Button','gridmax'); ?>"><i class="fab fa-dribbble" aria-hidden="true" title="<?php esc_attr_e('Dribbble','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('flipboardlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('flipboardlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-flipboard" aria-label="<?php esc_attr_e('Flipboard Button','gridmax'); ?>"><i class="fab fa-flipboard" aria-hidden="true" title="<?php esc_attr_e('Flipboard','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('bloggerlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('bloggerlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-blogger" aria-label="<?php esc_attr_e('Blogger Button','gridmax'); ?>"><i class="fab fa-blogger" aria-hidden="true" title="<?php esc_attr_e('Blogger','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('etsylink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('etsylink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-etsy" aria-label="<?php esc_attr_e('Etsy Button','gridmax'); ?>"><i class="fab fa-etsy" aria-hidden="true" title="<?php esc_attr_e('Etsy','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('behancelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('behancelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-behance" aria-label="<?php esc_attr_e('Behance Button','gridmax'); ?>"><i class="fab fa-behance" aria-hidden="true" title="<?php esc_attr_e('Behance','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('amazonlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('amazonlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-amazon" aria-label="<?php esc_attr_e('Amazon Button','gridmax'); ?>"><i class="fab fa-amazon" aria-hidden="true" title="<?php esc_attr_e('Amazon','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('meetuplink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('meetuplink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-meetup" aria-label="<?php esc_attr_e('Meetup Button','gridmax'); ?>"><i class="fab fa-meetup" aria-hidden="true" title="<?php esc_attr_e('Meetup','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('mixcloudlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('mixcloudlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-mixcloud" aria-label="<?php esc_attr_e('Mixcloud Button','gridmax'); ?>"><i class="fab fa-mixcloud" aria-hidden="true" title="<?php esc_attr_e('Mixcloud','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('slacklink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('slacklink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-slack" aria-label="<?php esc_attr_e('Slack Button','gridmax'); ?>"><i class="fab fa-slack" aria-hidden="true" title="<?php esc_attr_e('Slack','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('snapchatlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('snapchatlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-snapchat" aria-label="<?php esc_attr_e('Snapchat Button','gridmax'); ?>"><i class="fab fa-snapchat" aria-hidden="true" title="<?php esc_attr_e('Snapchat','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('spotifylink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('spotifylink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-spotify" aria-label="<?php esc_attr_e('Spotify Button','gridmax'); ?>"><i class="fab fa-spotify" aria-hidden="true" title="<?php esc_attr_e('Spotify','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('yelplink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('yelplink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-yelp" aria-label="<?php esc_attr_e('Yelp Button','gridmax'); ?>"><i class="fab fa-yelp" aria-hidden="true" title="<?php esc_attr_e('Yelp','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('wordpresslink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('wordpresslink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-wordpress" aria-label="<?php esc_attr_e('WordPress Button','gridmax'); ?>"><i class="fab fa-wordpress" aria-hidden="true" title="<?php esc_attr_e('WordPress','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('twitchlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('twitchlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-twitch" aria-label="<?php esc_attr_e('Twitch Button','gridmax'); ?>"><i class="fab fa-twitch" aria-hidden="true" title="<?php esc_attr_e('Twitch','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('telegramlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('telegramlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-telegram" aria-label="<?php esc_attr_e('Telegram Button','gridmax'); ?>"><i class="fab fa-telegram" aria-hidden="true" title="<?php esc_attr_e('Telegram','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('bandcamplink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('bandcamplink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-bandcamp" aria-label="<?php esc_attr_e('Bandcamp Button','gridmax'); ?>"><i class="fab fa-bandcamp" aria-hidden="true" title="<?php esc_attr_e('Bandcamp','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('quoralink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('quoralink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-quora" aria-label="<?php esc_attr_e('Quora Button','gridmax'); ?>"><i class="fab fa-quora" aria-hidden="true" title="<?php esc_attr_e('Quora','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('foursquarelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('foursquarelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-foursquare" aria-label="<?php esc_attr_e('Foursquare Button','gridmax'); ?>"><i class="fab fa-foursquare" aria-hidden="true" title="<?php esc_attr_e('Foursquare','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('deviantartlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('deviantartlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-deviantart" aria-label="<?php esc_attr_e('DeviantArt Button','gridmax'); ?>"><i class="fab fa-deviantart" aria-hidden="true" title="<?php esc_attr_e('DeviantArt','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('imdblink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('imdblink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-imdb" aria-label="<?php esc_attr_e('IMDB Button','gridmax'); ?>"><i class="fab fa-imdb" aria-hidden="true" title="<?php esc_attr_e('IMDB','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('vklink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('vklink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-vk" aria-label="<?php esc_attr_e('VK Button','gridmax'); ?>"><i class="fab fa-vk" aria-hidden="true" title="<?php esc_attr_e('VK','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('codepenlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('codepenlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-codepen" aria-label="<?php esc_attr_e('Codepen Button','gridmax'); ?>"><i class="fab fa-codepen" aria-hidden="true" title="<?php esc_attr_e('Codepen','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('jsfiddlelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('jsfiddlelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-jsfiddle" aria-label="<?php esc_attr_e('JSFiddle Button','gridmax'); ?>"><i class="fab fa-jsfiddle" aria-hidden="true" title="<?php esc_attr_e('JSFiddle','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('stackoverflowlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('stackoverflowlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-stackoverflow" aria-label="<?php esc_attr_e('Stack Overflow Button','gridmax'); ?>"><i class="fab fa-stack-overflow" aria-hidden="true" title="<?php esc_attr_e('Stack Overflow','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('stackexchangelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('stackexchangelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-stackexchange" aria-label="<?php esc_attr_e('Stack Exchange Button','gridmax'); ?>"><i class="fab fa-stack-exchange" aria-hidden="true" title="<?php esc_attr_e('Stack Exchange','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('bsalink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('bsalink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-buysellads" aria-label="<?php esc_attr_e('BuySellAds Button','gridmax'); ?>"><i class="fab fa-buysellads" aria-hidden="true" title="<?php esc_attr_e('BuySellAds','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('web500pxlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('web500pxlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-web500px" aria-label="<?php esc_attr_e('500px Button','gridmax'); ?>"><i class="fab fa-500px" aria-hidden="true" title="<?php esc_attr_e('500px','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('ellolink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('ellolink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-ello" aria-label="<?php esc_attr_e('Ello Button','gridmax'); ?>"><i class="fab fa-ello" aria-hidden="true" title="<?php esc_attr_e('Ello','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('discordlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('discordlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-discord" aria-label="<?php esc_attr_e('Discord Button','gridmax'); ?>"><i class="fab fa-discord" aria-hidden="true" title="<?php esc_attr_e('Discord','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('goodreadslink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('goodreadslink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-goodreads" aria-label="<?php esc_attr_e('Goodreads Button','gridmax'); ?>"><i class="fab fa-goodreads" aria-hidden="true" title="<?php esc_attr_e('Goodreads','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('odnoklassnikilink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('odnoklassnikilink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-odnoklassniki" aria-label="<?php esc_attr_e('Odnoklassniki Button','gridmax'); ?>"><i class="fab fa-odnoklassniki" aria-hidden="true" title="<?php esc_attr_e('Odnoklassniki','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('houzzlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('houzzlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-houzz" aria-label="<?php esc_attr_e('Houzz Button','gridmax'); ?>"><i class="fab fa-houzz" aria-hidden="true" title="<?php esc_attr_e('Houzz','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('pocketlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('pocketlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-pocket" aria-label="<?php esc_attr_e('Pocket Button','gridmax'); ?>"><i class="fab fa-get-pocket" aria-hidden="true" title="<?php esc_attr_e('Pocket','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('xinglink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('xinglink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-xing" aria-label="<?php esc_attr_e('XING Button','gridmax'); ?>"><i class="fab fa-xing" aria-hidden="true" title="<?php esc_attr_e('XING','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('googleplaylink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('googleplaylink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-googleplay" aria-label="<?php esc_attr_e('Google Play Button','gridmax'); ?>"><i class="fab fa-google-play" aria-hidden="true" title="<?php esc_attr_e('Google Play','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('slidesharelink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('slidesharelink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-slideshare" aria-label="<?php esc_attr_e('SlideShare Button','gridmax'); ?>"><i class="fab fa-slideshare" aria-hidden="true" title="<?php esc_attr_e('SlideShare','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('dropboxlink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('dropboxlink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-dropbox" aria-label="<?php esc_attr_e('Dropbox Button','gridmax'); ?>"><i class="fab fa-dropbox" aria-hidden="true" title="<?php esc_attr_e('Dropbox','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('paypallink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('paypallink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-paypal" aria-label="<?php esc_attr_e('PayPal Button','gridmax'); ?>"><i class="fab fa-paypal" aria-hidden="true" title="<?php esc_attr_e('PayPal','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('viadeolink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('viadeolink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-viadeo" aria-label="<?php esc_attr_e('Viadeo Button','gridmax'); ?>"><i class="fab fa-viadeo" aria-hidden="true" title="<?php esc_attr_e('Viadeo','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('wikipedialink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('wikipedialink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-wikipedia" aria-label="<?php esc_attr_e('Wikipedia Button','gridmax'); ?>"><i class="fab fa-wikipedia-w" aria-hidden="true" title="<?php esc_attr_e('Wikipedia','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('skypeusername') ) : ?>
            <a href="skype:<?php echo esc_html( gridmax_get_option('skypeusername') ); ?>?chat" class="gridmax-footer-social-icon-skype" aria-label="<?php esc_attr_e('Skype Button','gridmax'); ?>"><i class="fab fa-skype" aria-hidden="true" title="<?php esc_attr_e('Skype','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('emailaddress') ) : ?>
            <a href="mailto:<?php echo esc_html( gridmax_get_option('emailaddress') ); ?>" class="gridmax-footer-social-icon-email" aria-label="<?php esc_attr_e('Email Us Button','gridmax'); ?>"><i class="far fa-envelope" aria-hidden="true" title="<?php esc_attr_e('Email Us','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('rsslink') ) : ?>
            <a href="<?php echo esc_url( gridmax_get_option('rsslink') ); ?>" target="_blank" rel="nofollow" class="gridmax-footer-social-icon-rss" aria-label="<?php esc_attr_e('RSS Button','gridmax'); ?>"><i class="fas fa-rss" aria-hidden="true" title="<?php esc_attr_e('RSS','gridmax'); ?>"></i></a><?php endif; ?>
    <?php if ( gridmax_get_option('show_footer_login_button') ) { ?><?php if (is_user_logged_in()) : ?><a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" aria-label="<?php esc_attr_e( 'Logout Button', 'gridmax' ); ?>" class="gridmax-footer-social-icon-login"><i class="fas fa-sign-out-alt" aria-hidden="true" title="<?php esc_attr_e('Logout','gridmax'); ?>"></i></a><?php else : ?><a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" aria-label="<?php esc_attr_e( 'Login / Register Button', 'gridmax' ); ?>" class="gridmax-footer-social-icon-login"><i class="fas fa-sign-in-alt" aria-hidden="true" title="<?php esc_attr_e('Login / Register','gridmax'); ?>"></i></a><?php endif;?><?php } ?>
</div>

<?php }


/**
* Author bio box
*/

function gridmax_add_author_bio_box() {
    $content='';
    if (is_single()) {
        $content .= '
            <div class="gridmax-author-bio">
            <div class="gridmax-author-bio-top">
            <span class="gridmax-author-bio-gravatar">
                '. get_avatar( get_the_author_meta('email') , 80 ) .'
            </span>
            <div class="gridmax-author-bio-text">
                <div class="gridmax-author-bio-name">'.esc_html__( 'Author: ', 'gridmax' ).'<span>'. get_the_author_link() .'</span></div><div class="gridmax-author-bio-text-description">'. wp_kses_post( get_the_author_meta('description',get_query_var('author') ) ) .'</div>
            </div>
            </div>
            </div>
        ';
    }
    return apply_filters( 'gridmax_add_author_bio_box', $content );
}


/**
* Post meta functions
*/

if ( ! function_exists( 'gridmax_post_tags' ) ) :
/**
 * Prints HTML with meta information for the tags.
 */
function gridmax_post_tags() {
    if ( 'post' == get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'gridmax' ) );
        if ( $tags_list ) {
            /* translators: 1: list of tags. */
            printf( '<span class="gridmax-tags-links"><i class="fas fa-tags" aria-hidden="true"></i> ' . esc_html__( 'Tagged %1$s', 'gridmax' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
endif;


if ( ! function_exists( 'gridmax_grid_cats' ) ) :
function gridmax_grid_cats() {
    if ( 'post' == get_post_type() ) {
        /* translators: used between list items, there is a space */
        $categories_list = get_the_category_list( esc_html__( '&nbsp;', 'gridmax' ) );
        if ( $categories_list ) {
            /* translators: 1: list of categories. */
            printf( '<div class="gridmax-grid-post-categories">' . __( '<span class="gridmax-sr-only">Posted in </span>%1$s', 'gridmax' ) . '</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
endif;


function gridmax_author_image_size() {
    $gravatar_size = 24;
    return apply_filters( 'gridmax_author_image_size', $gravatar_size );
}


if ( ! function_exists( 'gridmax_author_image' ) ) :
function gridmax_author_image( $size = '' ) {
    global $post;
    if ( $size ) {
        $gravatar_size = $size;
    } else {
        $gravatar_size = gridmax_author_image_size();
    }
    $author_email   = get_the_author_meta( 'user_email' );
    $gravatar_args  = apply_filters(
        'gridmax_gravatar_args',
        array(
            'size' => $gravatar_size,
        )
    );

    $avatar_url = '';
    if( get_the_author_meta('themesdna_userprofile_image',get_query_var('author') ) ) {
        $avatar_url = get_the_author_meta( 'themesdna_userprofile_image' );
    } else {
        $avatar_url = get_avatar_url( $author_email, $gravatar_args );
    }

    if ( gridmax_get_option('author_image_link') ) {
        $avatar_markup  = '<a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" title="'.esc_attr( get_the_author() ).'"><img class="gridmax-grid-post-author-image" alt="' . esc_attr( get_the_author() ) . '" src="' . esc_url( $avatar_url ) . '" /></a>';
    } else {
        $avatar_markup  = '<img class="gridmax-grid-post-author-image" alt="' . esc_attr( get_the_author() ) . '" src="' . esc_url( $avatar_url ) . '" />';
    }
    return apply_filters( 'gridmax_author_image', $avatar_markup );
}
endif;


if ( ! function_exists( 'gridmax_grid_postmeta' ) ) :
function gridmax_grid_postmeta() { ?>
    <?php global $post; ?>
    <?php if ( !(gridmax_get_option('hide_post_author_home')) || !(gridmax_get_option('hide_post_author_image_home')) || !(gridmax_get_option('hide_posted_date_home')) ) { ?>
    <div class="gridmax-grid-post-footer gridmax-grid-post-block">
    <?php if ( !(gridmax_get_option('hide_post_author_home')) || !(gridmax_get_option('hide_post_author_image_home')) ) { ?><span class="gridmax-grid-post-author gridmax-grid-post-meta"><?php if ( !(gridmax_get_option('hide_post_author_image_home')) ) { ?><?php echo wp_kses_post( gridmax_author_image() ); ?><?php } ?><?php if ( !(gridmax_get_option('hide_post_author_home')) ) { ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a><?php } ?></span><?php } ?>
    <?php if ( !(gridmax_get_option('hide_posted_date_home')) ) { ?><span class="gridmax-grid-post-date gridmax-grid-post-meta"><?php echo esc_html( get_the_date() ); ?></span><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'gridmax_grid_postmeta_header' ) ) :
function gridmax_grid_postmeta_header() { ?>
    <?php global $post; ?>
    <?php if ( !(gridmax_get_option('hide_comments_link_home')) ) { ?>
    <div class="gridmax-grid-post-header gridmax-clearfix">
    <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridmax-grid-post-comments gridmax-grid-post-header-meta"><?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( '0 Comment<span class="gridmax-sr-only"> on %s</span>', 'gridmax' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'gridmax_nongrid_postmeta' ) ) :
function gridmax_nongrid_postmeta() { ?>
    <?php global $post; ?>
    <?php if ( !(gridmax_get_option('hide_post_author_home')) || !(gridmax_get_option('hide_posted_date_home')) || !(gridmax_get_option('hide_comments_link_home')) || !(gridmax_get_option('hide_post_categories_home')) ) { ?>
    <div class="gridmax-entry-meta-single">
    <?php if ( !(gridmax_get_option('hide_post_author_home')) ) { ?><span class="gridmax-entry-meta-single-author"><i class="far fa-user-circle" aria-hidden="true"></i>&nbsp;<span class="author vcard" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span><?php } ?>
    <?php if ( !(gridmax_get_option('hide_posted_date_home')) ) { ?><span class="gridmax-entry-meta-single-date"><i class="far fa-clock" aria-hidden="true"></i>&nbsp;<?php echo esc_html( get_the_date() ); ?></span><?php } ?>
    <?php if ( !(gridmax_get_option('hide_comments_link_home')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridmax-entry-meta-single-comments"><i class="far fa-comments" aria-hidden="true"></i>&nbsp;<?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( 'Leave a Comment<span class="gridmax-sr-only"> on %s</span>', 'gridmax' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    <?php if ( !(gridmax_get_option('hide_post_categories_home')) ) { ?><?php gridmax_single_cats(); ?><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'gridmax_single_cats' ) ) :
function gridmax_single_cats() {
    if ( 'post' == get_post_type() ) {
        /* translators: used between list items, there is a space */
        $categories_list = get_the_category_list( esc_html__( ', ', 'gridmax' ) );
        if ( $categories_list ) {
            /* translators: 1: list of categories. */
            printf( '<span class="gridmax-entry-meta-single-cats"><i class="far fa-folder-open" aria-hidden="true"></i>&nbsp;' . __( '<span class="gridmax-sr-only">Posted in </span>%1$s', 'gridmax' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
endif;


if ( ! function_exists( 'gridmax_single_postmeta' ) ) :
function gridmax_single_postmeta() { ?>
    <?php global $post; ?>
    <?php if ( !(gridmax_get_option('hide_post_author')) || !(gridmax_get_option('hide_posted_date')) || !(gridmax_get_option('hide_comments_link')) || !(gridmax_get_option('hide_post_categories')) || !(gridmax_get_option('hide_post_edit')) ) { ?>
    <div class="gridmax-entry-meta-single">
    <?php if ( !(gridmax_get_option('hide_post_author')) ) { ?><span class="gridmax-entry-meta-single-author"><i class="far fa-user-circle" aria-hidden="true"></i>&nbsp;<span class="author vcard" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span><?php } ?>
    <?php if ( !(gridmax_get_option('hide_posted_date')) ) { ?><span class="gridmax-entry-meta-single-date"><i class="far fa-clock" aria-hidden="true"></i>&nbsp;<?php echo esc_html( get_the_date() ); ?></span><?php } ?>
    <?php if ( !(gridmax_get_option('hide_comments_link')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridmax-entry-meta-single-comments"><i class="far fa-comments" aria-hidden="true"></i>&nbsp;<?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( 'Leave a Comment<span class="gridmax-sr-only"> on %s</span>', 'gridmax' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    <?php if ( !(gridmax_get_option('hide_post_categories')) ) { ?><?php gridmax_single_cats(); ?><?php } ?>
    <?php if ( !(gridmax_get_option('hide_post_edit')) ) { ?><?php edit_post_link( sprintf( wp_kses( /* translators: %s: Name of current post. Only visible to screen readers */ __( 'Edit<span class="gridmax-sr-only"> %s</span>', 'gridmax' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ), '<span class="edit-link">&nbsp;&nbsp;<i class="far fa-edit" aria-hidden="true"></i> ', '</span>' ); ?><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'gridmax_page_postmeta' ) ) :
function gridmax_page_postmeta() { ?>
    <?php global $post; ?>
    <?php if ( !(gridmax_get_option('hide_page_author')) || !(gridmax_get_option('hide_page_date')) || (!(gridmax_get_option('hide_page_comments')) && ! post_password_required() && ( comments_open() || get_comments_number() )) ) { ?>
    <div class="gridmax-entry-meta-single">
    <?php if ( !(gridmax_get_option('hide_page_author')) ) { ?><span class="gridmax-entry-meta-single-author"><i class="far fa-user-circle" aria-hidden="true"></i>&nbsp;<span class="author vcard" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span><?php } ?>
    <?php if ( !(gridmax_get_option('hide_page_date')) ) { ?><span class="gridmax-entry-meta-single-date"><i class="far fa-clock" aria-hidden="true"></i>&nbsp;<?php echo esc_html( get_the_date() ); ?></span><?php } ?>
    <?php if ( !(gridmax_get_option('hide_page_comments')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridmax-entry-meta-single-comments"><i class="far fa-comments" aria-hidden="true"></i>&nbsp;<?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( 'Leave a Comment<span class="gridmax-sr-only"> on %s</span>', 'gridmax' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


/**
* Posts navigation functions
*/

if ( ! function_exists( 'gridmax_wp_pagenavi' ) ) :
function gridmax_wp_pagenavi() {
    ?>
    <nav class="navigation posts-navigation gridmax-clearfix" role="navigation">
        <?php wp_pagenavi(); ?>
    </nav><!-- .navigation -->
    <?php
}
endif;


if ( ! function_exists( 'gridmax_posts_navigation' ) ) :
function gridmax_posts_navigation() {
    if ( !(gridmax_get_option('hide_posts_navigation')) ) {
        if ( function_exists( 'wp_pagenavi' ) ) {
            gridmax_wp_pagenavi();
        } else {
            if ( gridmax_get_option('posts_navigation_type') === 'normalnavi' ) {
                the_posts_navigation(array('prev_text' => esc_html__( 'Older posts', 'gridmax' ), 'next_text' => esc_html__( 'Newer posts', 'gridmax' )));
            } else {
                the_posts_pagination(array('mid_size' => 2, 'prev_text' => esc_html__( '&larr; Newer posts', 'gridmax' ), 'next_text' => esc_html__( 'Older posts &rarr;', 'gridmax' )));
            }
        }
    }
}
endif;


if ( ! function_exists( 'gridmax_post_navigation' ) ) :
function gridmax_post_navigation() {
    global $post;
    if ( !(gridmax_get_option('hide_post_navigation')) ) {
            the_post_navigation(array('prev_text' => esc_html__( '%title &rarr;', 'gridmax' ), 'next_text' => esc_html__( '&larr; %title', 'gridmax' )));
    }
}
endif;


/**
* Menu Functions
*/

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a "Home" link as the first item
function gridmax_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'gridmax_page_menu_args' );

function gridmax_fallback_menu() {
   wp_page_menu( array(
        'sort_column'  => 'menu_order, post_title',
        'menu_id'      => 'gridmax-menu-primary-navigation',
        'menu_class'   => 'gridmax-primary-nav-menu gridmax-menu-primary',
        'container'    => 'ul',
        'echo'         => true,
        'link_before'  => '',
        'link_after'   => '',
        'before'       => '',
        'after'        => '',
        'item_spacing' => 'discard',
        'walker'       => '',
    ) );
}


/**
* Header Functions
*/

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function gridmax_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'gridmax_pingback_header' );

// Get custom-logo URL
function gridmax_custom_logo() {
    if ( ! has_custom_logo() ) {return;}
    $gridmax_custom_logo_id = get_theme_mod( 'custom_logo' );
    $gridmax_logo = wp_get_attachment_image_src( $gridmax_custom_logo_id , 'full' );
    $gridmax_logo_src = $gridmax_logo[0];
    return apply_filters( 'gridmax_custom_logo', $gridmax_logo_src );
}

// Site Title
function gridmax_site_title() {
    if ( is_front_page() && is_home() ) { ?>
            <h1 class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_home() ) { ?>
            <h1 class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_singular() ) { ?>
            <p class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_category() ) { ?>
            <p class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_tag() ) { ?>
            <p class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_author() ) { ?>
            <p class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_archive() && !is_category() && !is_tag() && !is_author() ) { ?>
            <p class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_search() ) { ?>
            <p class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_404() ) { ?>
            <p class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } else { ?>
            <h1 class="gridmax-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(gridmax_get_option('hide_tagline')) ) { ?><p class="gridmax-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php }
}

function gridmax_header_image_destination() {
    $url = home_url( '/' );
    if ( gridmax_get_option('header_image_destination') ) {
        $url = gridmax_get_option('header_image_destination');
    }
    return apply_filters( 'gridmax_header_image_destination', $url );
}

function gridmax_header_image_markup() {
    if ( get_header_image() ) {
        if ( gridmax_get_option('remove_header_image_link') ) {
            the_header_image_tag( array( 'class' => 'gridmax-header-img', 'alt' => '' ) );
        } else { ?>
            <a href="<?php echo esc_url( gridmax_header_image_destination() ); ?>" rel="home" class="gridmax-header-img-link"><?php the_header_image_tag( array( 'class' => 'gridmax-header-img', 'alt' => '' ) ); ?></a>
        <?php }
    }
}

function gridmax_header_image_details() {
    $header_image_custom_title = '';
    if ( gridmax_get_option('header_image_custom_title') ) {
        $header_image_custom_title = gridmax_get_option('header_image_custom_title');
    }

    $header_image_custom_description = '';
    if ( gridmax_get_option('header_image_custom_description') ) {
        $header_image_custom_description = gridmax_get_option('header_image_custom_description');
    }

    if ( !(gridmax_get_option('hide_header_image_details')) ) {
    if ( gridmax_get_option('header_image_custom_text') ) {
        if ( $header_image_custom_title || $header_image_custom_description ) { ?>
            <div class="gridmax-header-image-info">
            <div class="gridmax-header-image-info-inside">
                <?php if ( $header_image_custom_title ) { ?><p class="gridmax-header-image-site-title gridmax-header-image-block"><?php echo wp_kses_post( force_balance_tags( do_shortcode($header_image_custom_title) ) ); ?></p><?php } ?>
                <?php if ( !(gridmax_get_option('hide_header_image_description')) ) { ?><?php if ( $header_image_custom_description ) { ?><p class="gridmax-header-image-site-description gridmax-header-image-block"><?php echo wp_kses_post( force_balance_tags( do_shortcode($header_image_custom_description) ) ); ?></p><?php } ?><?php } ?>
            </div>
            </div>
        <?php }
    } else { ?>
        <div class="gridmax-header-image-info">
        <div class="gridmax-header-image-info-inside">
            <p class="gridmax-header-image-site-title gridmax-header-image-block"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridmax_get_option('hide_header_image_description')) ) { ?><p class="gridmax-header-image-site-description gridmax-header-image-block"><?php bloginfo( 'description' ); ?></p><?php } ?>
        </div>
        </div>
    <?php }
    }
}

function gridmax_header_image_wrapper() { ?>
    <div class="gridmax-header-image gridmax-clearfix">
    <?php gridmax_header_image_markup(); ?>
    <?php gridmax_header_image_details(); ?>
    </div>
    <?php
}

function gridmax_header_image() {
    if ( gridmax_get_option('hide_header_image') ) { return; }
    if ( get_header_image() ) {
        gridmax_header_image_wrapper();
    }
}


/**
* Css Classes Functions
*/

// Category ids in post class
function gridmax_category_id_class($classes) {
    global $post;
    foreach((get_the_category($post->ID)) as $category) {
        $classes[] = 'wpcat-' . $category->cat_ID . '-id';
    }
    return apply_filters( 'gridmax_category_id_class', $classes );
}
add_filter('post_class', 'gridmax_category_id_class');


// Adds custom classes to the array of body classes.
function gridmax_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'gridmax-group-blog';
    }

    $classes[] = 'gridmax-animated gridmax-fadein';

    $classes[] = 'gridmax-theme-is-active';

    if ( get_header_image() ) {
        $classes[] = 'gridmax-header-image-active';
    }

    if ( has_custom_logo() ) {
        $classes[] = 'gridmax-custom-logo-active';
    }

    $classes[] = 'gridmax-masonry-inactive';

    if ( !(is_singular()) ) {
        if ( gridmax_get_option('featured_nongrid_media_under_post_title') ) {
            $classes[] = 'gridmax-nongrid-media-under-title';
        }
    }

    if ( is_singular() ) {
        if( is_single() ) {
            if ( gridmax_get_option('featured_media_under_post_title') ) {
                $classes[] = 'gridmax-single-media-under-title';
            }
        }
        if( is_page() ) {
            if ( gridmax_get_option('featured_media_under_page_title') ) {
                $classes[] = 'gridmax-single-media-under-title';
            }
        }

        if ( is_page_template( array( 'template-full-width-page.php', 'template-full-width-post.php' ) ) ) {
           $classes[] = 'gridmax-layout-full-width';
        } else {
            $classes[] = 'gridmax-layout-c-s1';
        }
    } else {
        $classes[] = 'gridmax-layout-full-width';
    }

    $classes[] = 'gridmax-header-full-active';

    if ( gridmax_get_option('hide_tagline') ) {
        $classes[] = 'gridmax-tagline-inactive';
    }

    if ( gridmax_is_primary_menu_active() ) {
        $classes[] = 'gridmax-primary-menu-active';
    }
    $classes[] = 'gridmax-primary-mobile-menu-active';

    return apply_filters( 'gridmax_body_classes', $classes );
}
add_filter( 'body_class', 'gridmax_body_classes' );


/**
* More Custom Functions
*/

// Change excerpt length
function gridmax_excerpt_length($length) {
    if ( is_admin() ) {
        return $length;
    }
    $read_more_length = 17;
    if ( gridmax_get_option('read_more_length') ) {
        $read_more_length = gridmax_get_option('read_more_length');
    }
    return apply_filters( 'gridmax_excerpt_length', $read_more_length );
}
add_filter('excerpt_length', 'gridmax_excerpt_length');

// Change excerpt more word
function gridmax_excerpt_more($more) {
    if ( is_admin() ) {
        return $more;
    }
    return '...';
}
add_filter('excerpt_more', 'gridmax_excerpt_more');


if ( ! function_exists( 'wp_body_open' ) ) :
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     */
    function wp_body_open() { // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedFunctionFound
        /**
         * Triggered after the opening <body> tag.
         */
        do_action( 'wp_body_open' ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound
    }
endif;

function gridmax_add_menu_search_button( $items, $args ) {

    // Only used for the main menu
    if ( 'primary' != $args->theme_location ) {
        return $items;
    }

    $search_button = '';
    if ( !(gridmax_get_option('hide_header_search_button')) ) {
        $search_button = '<li class="gridmax-header-icon-search-item"><a href="' . esc_url( '#' ) . '" aria-label="'.esc_attr__('Search Button','gridmax').'" class="gridmax-header-icon-search"><i class="fas fa-search" aria-hidden="true" title="'.esc_attr__('Search','gridmax').'"></i></a></li>';
    }

    $items = $items . $search_button;
    return $items;

}
add_filter( 'wp_nav_menu_items', 'gridmax_add_menu_search_button', 10, 2 );


/**
* Custom Hooks
*/

function gridmax_before_header() {
    do_action('gridmax_before_header');
}

function gridmax_after_header() {
    do_action('gridmax_after_header');
}

function gridmax_before_main_content() {
    do_action('gridmax_before_main_content');
}
add_action('gridmax_before_main_content', 'gridmax_top_widgets', 20 );

function gridmax_after_main_content() {
    do_action('gridmax_after_main_content');
}
add_action('gridmax_after_main_content', 'gridmax_bottom_widgets', 10 );

function gridmax_sidebar_one() {
    do_action('gridmax_sidebar_one');
}
add_action('gridmax_sidebar_one', 'gridmax_sidebar_one_widgets', 10 );

function gridmax_sidebar_two() {
    do_action('gridmax_sidebar_two');
}

function gridmax_before_single_post() {
    do_action('gridmax_before_single_post');
}

function gridmax_before_single_post_title() {
    do_action('gridmax_before_single_post_title');
}

function gridmax_after_single_post_title() {
    do_action('gridmax_after_single_post_title');
}

function gridmax_top_single_post_content() {
    do_action('gridmax_top_single_post_content');
}

function gridmax_bottom_single_post_content() {
    do_action('gridmax_bottom_single_post_content');
}

function gridmax_after_single_post_content() {
    do_action('gridmax_after_single_post_content');
}

function gridmax_after_single_post() {
    do_action('gridmax_after_single_post');
}

function gridmax_before_single_page() {
    do_action('gridmax_before_single_page');
}

function gridmax_before_single_page_title() {
    do_action('gridmax_before_single_page_title');
}

function gridmax_after_single_page_title() {
    do_action('gridmax_after_single_page_title');
}

function gridmax_after_single_page_content() {
    do_action('gridmax_after_single_page_content');
}

function gridmax_after_single_page() {
    do_action('gridmax_after_single_page');
}

function gridmax_before_comments() {
    do_action('gridmax_before_comments');
}

function gridmax_after_comments() {
    do_action('gridmax_after_comments');
}

function gridmax_before_footer() {
    do_action('gridmax_before_footer');
}

function gridmax_after_footer() {
    do_action('gridmax_after_footer');
}

function gridmax_before_nongrid_post_title() {
    do_action('gridmax_before_nongrid_post_title');
}

function gridmax_after_nongrid_post_title() {
    do_action('gridmax_after_nongrid_post_title');
}


/**
* Media functions
*/

function gridmax_media_content_grid() {
    global $post; ?>
    <?php if ( !(gridmax_get_option('hide_thumbnail_home')) ) { ?>
    <?php if ( has_post_thumbnail($post->ID) ) { ?>
    <div class="gridmax-grid-post-thumbnail gridmax-grid-post-block">
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="gridmax-grid-post-thumbnail-link" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridmax' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail('gridmax-480w-360h-image', array('class' => 'gridmax-grid-post-thumbnail-img', 'title' => the_title_attribute('echo=0'))); ?></a>
        <?php gridmax_grid_postmeta_header(); ?>
    </div>
    <?php } else { ?>
    <?php if ( !(gridmax_get_option('hide_default_thumbnail')) ) { ?>
    <div class="gridmax-grid-post-thumbnail gridmax-grid-post-thumbnail-default gridmax-grid-post-block">
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="gridmax-grid-post-thumbnail-link" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridmax' ), the_title_attribute( 'echo=0' ) ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/no-image-480-360.jpg' ); ?>" class="gridmax-grid-post-thumbnail-img"/></a>
        <?php gridmax_grid_postmeta_header(); ?>
    </div>
    <?php } ?>
    <?php } ?>
    <?php } ?>
<?php }


function gridmax_media_content_single() {
    global $post;
    if ( has_post_thumbnail() ) {
        if ( !(gridmax_get_option('hide_thumbnail')) ) {
            if ( gridmax_get_option('thumbnail_link') == 'no' ) { ?>
                <div class="gridmax-post-thumbnail-single">
                <?php
                if ( is_page_template( array( 'template-full-width-post.php' ) ) ) {
                    the_post_thumbnail('gridmax-1250w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0')));
                } else {
                    the_post_thumbnail('gridmax-900w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0')));
                }
                ?>
                </div>
            <?php } else { ?>
                <div class="gridmax-post-thumbnail-single">
                <?php if ( is_page_template( array( 'template-full-width-post.php' ) ) ) { ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridmax' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridmax-post-thumbnail-single-link"><?php the_post_thumbnail('gridmax-1250w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                <?php } else { ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridmax' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridmax-post-thumbnail-single-link"><?php the_post_thumbnail('gridmax-900w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                <?php } ?>
                </div>
    <?php   }
        }
    }
}


function gridmax_media_content_single_location() {
    if( gridmax_get_option('featured_media_under_post_title') ) {
        add_action('gridmax_after_single_post_title', 'gridmax_media_content_single', 10 );
    } else {
        add_action('gridmax_before_single_post_title', 'gridmax_media_content_single', 10 );
    }
}
add_action('template_redirect', 'gridmax_media_content_single_location', 100 );


function gridmax_media_content_page() {
    global $post; ?>
    <?php
    if ( has_post_thumbnail() ) {
        if ( !(gridmax_get_option('hide_page_thumbnail')) ) {
            if ( gridmax_get_option('thumbnail_link_page') == 'no' ) { ?>
                <div class="gridmax-post-thumbnail-single">
                <?php
                if ( is_page_template( array( 'template-full-width-page.php' ) ) ) {
                    the_post_thumbnail('gridmax-1250w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0')));
                } else {
                    the_post_thumbnail('gridmax-900w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0')));
                }
                ?>
                </div>
            <?php } else { ?>
                <div class="gridmax-post-thumbnail-single">
                <?php if ( is_page_template( array( 'template-full-width-page.php' ) ) ) { ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridmax' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridmax-post-thumbnail-single-link"><?php the_post_thumbnail('gridmax-1250w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                <?php } else { ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridmax' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridmax-post-thumbnail-single-link"><?php the_post_thumbnail('gridmax-900w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                <?php } ?>
                </div>
    <?php   }
        }
    }
    ?>
<?php }

function gridmax_media_content_page_location() {
    if( gridmax_get_option('featured_media_under_page_title') ) {
        add_action('gridmax_after_single_page_title', 'gridmax_media_content_page', 10 );
    } else {
        add_action('gridmax_before_single_page_title', 'gridmax_media_content_page', 10 );
    }
}
add_action('template_redirect', 'gridmax_media_content_page_location', 110 );


function gridmax_media_content_nongrid() {
    global $post;
    if ( has_post_thumbnail() ) {
        if ( !(gridmax_get_option('hide_thumbnail')) ) {
            if ( gridmax_get_option('thumbnail_link') == 'no' ) { ?>
                <div class="gridmax-post-thumbnail-single">
                <?php
                if ( is_page_template( array( 'template-full-width-post.php' ) ) ) {
                    the_post_thumbnail('gridmax-1250w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0')));
                } else {
                    the_post_thumbnail('gridmax-900w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0')));
                }
                ?>
                </div>
            <?php } else { ?>
                <div class="gridmax-post-thumbnail-single">
                <?php if ( is_page_template( array( 'template-full-width-post.php' ) ) ) { ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridmax' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridmax-post-thumbnail-single-link"><?php the_post_thumbnail('gridmax-1250w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                <?php } else { ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridmax' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridmax-post-thumbnail-single-link"><?php the_post_thumbnail('gridmax-900w-autoh-image', array('class' => 'gridmax-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                <?php } ?>
                </div>
    <?php   }
        }
    }
}

function gridmax_media_content_nongrid_location() {
    if( gridmax_get_option('featured_nongrid_media_under_post_title') ) {
        add_action('gridmax_after_nongrid_post_title', 'gridmax_media_content_nongrid', 10 );
    } else {
        add_action('gridmax_before_nongrid_post_title', 'gridmax_media_content_nongrid', 10 );
    }
}
add_action('template_redirect', 'gridmax_media_content_nongrid_location', 120 );



/**
* Enqueue scripts and styles
*/

function gridmax_scripts() {
    wp_enqueue_style('gridmax-maincss', get_stylesheet_uri(), array(), NULL);
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/all.min.css', array(), NULL );
    wp_enqueue_style('gridmax-webfont', '//fonts.googleapis.com/css?family=Encode+Sans+Condensed:400,700|Maitree:400,700|Lora:400,400i,700,700i|DM+Serif+Text:400,400i&amp;display=swap', array(), NULL);

    $gridmax_fitvids_active = FALSE;
    if ( gridmax_is_fitvids_active() ) {
        $gridmax_fitvids_active = TRUE;
    }
    if ( $gridmax_fitvids_active ) {
        wp_enqueue_script('fitvids', get_template_directory_uri() .'/assets/js/jquery.fitvids.min.js', array( 'jquery' ), NULL, true);
    }

    $gridmax_backtotop_active = FALSE;
    if ( gridmax_is_backtotop_active() ) {
        $gridmax_backtotop_active = TRUE;
    }

    $gridmax_primary_menu_active = FALSE;
    if ( gridmax_is_primary_menu_active() ) {
        $gridmax_primary_menu_active = TRUE;
    }

    $gridmax_sticky_header_active = TRUE;
    $gridmax_sticky_header_mobile_active = FALSE;

    $gridmax_sticky_sidebar_active = TRUE;
    if ( is_singular() ) {
        if ( is_page_template( array( 'template-full-width-page.php', 'template-full-width-post.php' ) ) ) {
           $gridmax_sticky_sidebar_active = FALSE;
        }
    } else {
        $gridmax_sticky_sidebar_active = FALSE;
    }
    if ( $gridmax_sticky_sidebar_active ) {
        wp_enqueue_script('ResizeSensor', get_template_directory_uri() .'/assets/js/ResizeSensor.min.js', array( 'jquery' ), NULL, true);
        wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() .'/assets/js/theia-sticky-sidebar.min.js', array( 'jquery' ), NULL, true);
    }

    wp_enqueue_script('gridmax-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), NULL, true );
    wp_enqueue_script('gridmax-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), NULL, true );
    wp_enqueue_script('gridmax-customjs', get_template_directory_uri() .'/assets/js/custom.js', array( 'jquery' ), NULL, true);

    wp_localize_script( 'gridmax-customjs', 'gridmax_ajax_object',
        array(
            'ajaxurl' => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
            'primary_menu_active' => $gridmax_primary_menu_active,
            'sticky_header_active' => $gridmax_sticky_header_active,
            'sticky_header_mobile_active' => $gridmax_sticky_header_mobile_active,
            'sticky_sidebar_active' => $gridmax_sticky_sidebar_active,
            'fitvids_active' => $gridmax_fitvids_active,
            'backtotop_active' => $gridmax_backtotop_active,
        )
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_script('gridmax-html5shiv-js', get_template_directory_uri() .'/assets/js/html5shiv.js', array('jquery'), NULL, true);

    wp_localize_script('gridmax-html5shiv-js','gridmax_custom_script_vars',array(
        'elements_name' => esc_html__('abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video', 'gridmax'),
    ));
}
add_action( 'wp_enqueue_scripts', 'gridmax_scripts' );

/**
 * Enqueue IE compatible scripts and styles.
 */
function gridmax_ie_scripts() {
    wp_enqueue_script( 'respond', get_template_directory_uri(). '/assets/js/respond.min.js', array(), NULL, false );
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'gridmax_ie_scripts' );

/**
 * Enqueue customizer styles.
 */
function gridmax_enqueue_customizer_styles() {
    wp_enqueue_style( 'gridmax-customizer-styles', get_template_directory_uri() . '/assets/css/customizer-style.css', array(), NULL );
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/all.min.css', array(), NULL );
}
add_action( 'customize_controls_enqueue_scripts', 'gridmax_enqueue_customizer_styles' );


// Header styles
if ( ! function_exists( 'gridmax_header_style' ) ) :
function gridmax_header_style() {
    $header_text_color = get_header_textcolor();
    //if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) { return; }
    ?>
    <style type="text/css">
    <?php if ( ! display_header_text() ) : ?>
        .gridmax-site-title, .gridmax-site-description {position: absolute;clip: rect(1px, 1px, 1px, 1px);}
    <?php else : ?>
        .gridmax-site-title, .gridmax-site-title a, .gridmax-site-description {color: #<?php echo esc_attr( $header_text_color ); ?>;}
    <?php endif; ?>
    </style>
    <?php
}
endif;