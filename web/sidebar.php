<?php
/**
* The file for displaying the sidebars.
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<?php if ( is_singular() ) { ?>

<?php if(!is_page_template(array( 'template-full-width-page.php', 'template-full-width-post.php' ))) { ?>
<div class="gridmax-sidebar-one-wrapper gridmax-sidebar-widget-areas gridmax-clearfix" id="gridmax-sidebar-one-wrapper" itemscope="itemscope" itemtype="http://schema.org/WPSideBar" role="complementary">
<div class="theiaStickySidebar">
<div class="gridmax-sidebar-one-wrapper-inside gridmax-clearfix">

<?php gridmax_sidebar_one(); ?>

</div>
</div>
</div><!-- /#gridmax-sidebar-one-wrapper-->
<?php } ?>

<?php } ?>