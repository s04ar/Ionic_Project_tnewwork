<?php
/**
* The template for displaying the footer
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

</div>

</div><!--/#gridmax-content-wrapper -->
</div><!--/#gridmax-wrapper -->

<?php gridmax_bottom_wide_widgets(); ?>

<?php gridmax_before_footer(); ?>

<?php if ( !(gridmax_hide_footer_widgets()) ) { ?>
<?php if ( is_active_sidebar( 'gridmax-footer-1' ) || is_active_sidebar( 'gridmax-footer-2' ) || is_active_sidebar( 'gridmax-footer-3' ) || is_active_sidebar( 'gridmax-footer-4' ) || is_active_sidebar( 'gridmax-top-footer' ) || is_active_sidebar( 'gridmax-bottom-footer' ) ) : ?>
<div class='gridmax-clearfix' id='gridmax-footer-blocks' itemscope='itemscope' itemtype='http://schema.org/WPFooter' role='contentinfo'>
<div class='gridmax-container gridmax-clearfix'>
<div class="gridmax-outer-wrapper">

<?php if ( is_active_sidebar( 'gridmax-top-footer' ) ) : ?>
<div class='gridmax-clearfix'>
<div class='gridmax-top-footer-block'>
<?php dynamic_sidebar( 'gridmax-top-footer' ); ?>
</div>
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'gridmax-footer-1' ) || is_active_sidebar( 'gridmax-footer-2' ) || is_active_sidebar( 'gridmax-footer-3' ) || is_active_sidebar( 'gridmax-footer-4' ) ) : ?>
<div class='gridmax-footer-block-cols gridmax-clearfix'>

<div class="gridmax-footer-block-col gridmax-footer-4-col" id="gridmax-footer-block-1">
<?php dynamic_sidebar( 'gridmax-footer-1' ); ?>
</div>

<div class="gridmax-footer-block-col gridmax-footer-4-col" id="gridmax-footer-block-2">
<?php dynamic_sidebar( 'gridmax-footer-2' ); ?>
</div>

<div class="gridmax-footer-block-col gridmax-footer-4-col" id="gridmax-footer-block-3">
<?php dynamic_sidebar( 'gridmax-footer-3' ); ?>
</div>

<div class="gridmax-footer-block-col gridmax-footer-4-col" id="gridmax-footer-block-4">
<?php dynamic_sidebar( 'gridmax-footer-4' ); ?>
</div>

</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'gridmax-bottom-footer' ) ) : ?>
<div class='gridmax-clearfix'>
<div class='gridmax-bottom-footer-block'>
<?php dynamic_sidebar( 'gridmax-bottom-footer' ); ?>
</div>
</div>
<?php endif; ?>

</div>
</div>
</div><!--/#gridmax-footer-blocks-->
<?php endif; ?>
<?php } ?>

<div class='gridmax-clearfix' id='gridmax-copyrights'>
<div class='gridmax-copyrights-inside gridmax-container'>
<div class="gridmax-outer-wrapper">
<div class='gridmax-copyrights-inside-content gridmax-clearfix'>

<?php if ( gridmax_is_footer_social_buttons_active() ) { ?>
<div class='gridmax-copyrights-social'>
<?php gridmax_footer_social_buttons(); ?>
</div>
<?php } ?>

<div class='gridmax-copyrights-info'>
<?php if ( gridmax_get_option('footer_text') ) : ?>
  <p class='gridmax-copyright'><?php echo esc_html(gridmax_get_option('footer_text')); ?></p>
<?php else : ?>
  <p class='gridmax-copyright'><?php /* translators: %s: Year and site name. */ printf( esc_html__( 'Copyright &copy; %s', 'gridmax' ), esc_html(date_i18n(__('Y','gridmax'))) . ' ' . esc_html(get_bloginfo( 'name' ))  ); ?></p>
<?php endif; ?>
<p class='gridmax-credit'><a href="<?php echo esc_url( 'https://themesdna.com/' ); ?>"><?php /* translators: %s: Theme author. */ printf( esc_html__( 'Design by %s', 'gridmax' ), 'ThemesDNA.com' ); ?></a></p>
</div>

</div>
</div>
</div>
</div><!--/#gridmax-copyrights -->

<?php gridmax_after_footer(); ?>

<?php if ( gridmax_is_backtotop_active() ) { ?><button class="gridmax-scroll-top" title="<?php esc_attr_e('Scroll to Top','gridmax'); ?>"><i class="fas fa-arrow-up" aria-hidden="true"></i><span class="gridmax-sr-only"><?php esc_html_e('Scroll to Top', 'gridmax'); ?></span></button><?php } ?>

<?php wp_footer(); ?>
</body>
</html>