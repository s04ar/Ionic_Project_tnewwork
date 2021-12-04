<?php
/**
* GridMax functions and definitions.
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

define( 'GRIDMAX_PROURL', 'https://themesdna.com/gridmax-pro-wordpress-theme/' );
define( 'GRIDMAX_CONTACTURL', 'https://themesdna.com/contact/' );
define( 'GRIDMAX_THEMEOPTIONSDIR', trailingslashit( get_template_directory() ) . 'theme-setup' );

require_once( trailingslashit( GRIDMAX_THEMEOPTIONSDIR ) . 'theme-options.php' );
require_once( trailingslashit( GRIDMAX_THEMEOPTIONSDIR ) . 'theme-functions.php' );