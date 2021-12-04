<?php
/**
* GridMax Theme Customizer.
*
* @package GridMax WordPress Theme
* @copyright Copyright (C) 2021 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

if ( ! class_exists( 'WP_Customize_Control' ) ) {return NULL;}

class GridMax_Customize_Static_Text_Control extends WP_Customize_Control {
    public $type = 'gridmax-static-text';

    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );
    }

    protected function render_content() {
        if ( ! empty( $this->label ) ) :
            ?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
        endif;

        if ( ! empty( $this->description ) ) :
            ?><div class="description customize-control-description"><?php

        echo wp_kses_post( $this->description );

            ?></div><?php
        endif;

    }
}

class GridMax_Customize_Button_Control extends WP_Customize_Control {
        public $type = 'gridmax-button';
        protected $button_tag = 'button';
        protected $button_class = 'button button-primary';
        protected $button_href = 'javascript:void(0)';
        protected $button_target = '';
        protected $button_onclick = '';
        protected $button_tag_id = '';

        public function render_content() {
        ?>
        <span class="center">
        <?php
        echo '<' . esc_html($this->button_tag);
        if (!empty($this->button_class)) {
            echo ' class="' . esc_attr($this->button_class) . '"';
        }
        if ('button' == $this->button_tag) {
            echo ' type="button"';
        }
        else {
            echo ' href="' . esc_url($this->button_href) . '"' . (empty($this->button_tag) ? '' : ' target="' . esc_attr($this->button_target) . '"');
        }
        if (!empty($this->button_onclick)) {
            echo ' onclick="' . esc_js($this->button_onclick) . '"';
        }
        if (!empty($this->button_tag_id)) {
            echo ' id="' . esc_attr($this->button_tag_id) . '"';
        }
        echo '>';
        echo esc_html($this->label);
        echo '</' . esc_html($this->button_tag) . '>';
        ?>
        </span>
        <?php
        }
}

class GridMax_Customize_Submit_Control extends WP_Customize_Control {
        public $type = 'gridmax-submit-button';
        protected $button_class = '';
        protected $button_id = '';
        protected $button_value = '';
        protected $button_onclick = '';

        public function render_content() {
        ?>
        <form action="customize.php" method="get">
        <label>
        <span style="font-weight:normal;margin-bottom:10px;" class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php
        echo '<input type="submit"';
        if (!empty($this->button_class)) {
            echo ' class="' . esc_attr($this->button_class) . '"';
        }
        if (!empty($this->button_id)) {
            echo ' name="' . esc_attr($this->button_id) . '"';
        }
        if (!empty($this->button_id)) {
            echo ' id="' . esc_attr($this->button_id) . '"';
        }
        if (!empty($this->button_value)) {
            echo ' value="' . esc_attr($this->button_value) . '"';
        }
        if (!empty($this->button_onclick)) {
            echo ' onclick="return confirm(\'' . esc_js($this->button_onclick) . '\');"';
        }
        echo '/>';
        ?>
        </label>
        </form>
        <?php
        }
}

/**
* Sanitize callback functions
*/

function gridmax_sanitize_checkbox( $input ) {
    return ( ( isset( $input ) && ( true == $input ) ) ? true : false );
}

function gridmax_sanitize_html( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function gridmax_sanitize_thumbnail_link( $input, $setting ) {
    $valid = array('yes','no');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function gridmax_sanitize_posts_navigation_type( $input, $setting ) {
    $valid = array('normalnavi','numberednavi');
    if ( in_array( $input, $valid ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function gridmax_sanitize_email( $input, $setting ) {
    if ( '' != $input && is_email( $input ) ) {
        $input = sanitize_email( $input );
        return $input;
    } else {
        return $setting->default;
    }
}

function gridmax_sanitize_read_more_length( $input, $setting ) {
    $input = absint( $input ); // Force the value into non-negative integer.
    return ( 0 < $input ) ? $input : $setting->default;
}

function gridmax_sanitize_positive_integer( $input, $setting ) {
    $input = absint( $input ); // Force the value into non-negative integer.
    return ( 0 < $input ) ? $input : $setting->default;
}

function gridmax_sanitize_positive_float( $input, $setting ) {
    $input = (float) $input;
    return ( 0 < $input ) ? $input : $setting->default;
}


function gridmax_register_theme_customizer( $wp_customize ) {

    if(method_exists('WP_Customize_Manager', 'add_panel')):
    $wp_customize->add_panel('gridmax_main_options_panel', array( 'title' => esc_html__('Theme Options', 'gridmax'), 'priority' => 10, ));
    endif;

    $wp_customize->get_section( 'title_tagline' )->panel = 'gridmax_main_options_panel';
    $wp_customize->get_section( 'title_tagline' )->priority = 20;
    $wp_customize->get_section( 'header_image' )->panel = 'gridmax_main_options_panel';
    $wp_customize->get_section( 'header_image' )->priority = 26;
    $wp_customize->get_section( 'background_image' )->panel = 'gridmax_main_options_panel';
    $wp_customize->get_section( 'background_image' )->priority = 27;
    $wp_customize->get_section( 'colors' )->panel = 'gridmax_main_options_panel';
    $wp_customize->get_section( 'colors' )->priority = 40;
      
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
    $wp_customize->get_control( 'background_color' )->description = esc_html__('To change Background Color, need to remove background image first:- go to Appearance : Customize : Theme Options : Background Image', 'gridmax');

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.gridmax-site-title a',
            'render_callback' => 'gridmax_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.gridmax-site-description',
            'render_callback' => 'gridmax_customize_partial_blogdescription',
        ) );
    }

    /* Getting started options */
    $wp_customize->add_section( 'gridmax_section_getting_started', array( 'title' => esc_html__( 'Getting Started', 'gridmax' ), 'description' => esc_html__( 'Thanks for your interest in GridMax! If you have any questions or run into any trouble, please visit us the following links. We will get you fixed up!', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 5, ) );

    $wp_customize->add_setting( 'gridmax_options[documentation]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );

    $wp_customize->add_control( new GridMax_Customize_Button_Control( $wp_customize, 'gridmax_documentation_control', array( 'label' => esc_html__( 'Documentation', 'gridmax' ), 'section' => 'gridmax_section_getting_started', 'settings' => 'gridmax_options[documentation]', 'type' => 'button', 'button_tag' => 'a', 'button_class' => 'button button-primary', 'button_href' => esc_url( 'https://themesdna.com/gridmax-wordpress-theme/' ), 'button_target' => '_blank', ) ) );

    $wp_customize->add_setting( 'gridmax_options[contact]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );

    $wp_customize->add_control( new GridMax_Customize_Button_Control( $wp_customize, 'gridmax_contact_control', array( 'label' => esc_html__( 'Contact Us', 'gridmax' ), 'section' => 'gridmax_section_getting_started', 'settings' => 'gridmax_options[contact]', 'type' => 'button', 'button_tag' => 'a', 'button_class' => 'button button-primary', 'button_href' => esc_url( 'https://themesdna.com/contact/' ), 'button_target' => '_blank', ) ) );


    /* Menu options */
    $wp_customize->add_section( 'gridmax_section_menu_options', array( 'title' => esc_html__( 'Menu Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 120 ) );

    $wp_customize->add_setting( 'gridmax_options[disable_primary_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_disable_primary_menu_control', array( 'label' => esc_html__( 'Disable Primary Menu', 'gridmax' ), 'section' => 'gridmax_section_menu_options', 'settings' => 'gridmax_options[disable_primary_menu]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_header_search_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_header_search_button_control', array( 'label' => esc_html__( 'Hide Header Search Button', 'gridmax' ), 'description' => esc_html__('This option has no effect if you checked the option: "Disable Primary Menu"', 'gridmax'), 'section' => 'gridmax_section_menu_options', 'settings' => 'gridmax_options[hide_header_search_button]', 'type' => 'checkbox', ) );


    /* Header options */
    $wp_customize->add_section( 'gridmax_section_header', array( 'title' => esc_html__( 'Header Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 100 ) );

    $wp_customize->add_setting( 'gridmax_options[hide_tagline]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_tagline_control', array( 'label' => esc_html__( 'Hide Tagline', 'gridmax' ), 'section' => 'gridmax_section_header', 'settings' => 'gridmax_options[hide_tagline]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_header_content]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_header_content_control', array( 'label' => esc_html__( 'Hide Header Content', 'gridmax' ), 'section' => 'gridmax_section_header', 'settings' => 'gridmax_options[hide_header_content]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_header_image]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_header_image_control', array( 'label' => esc_html__( 'Hide Header Image from Everywhere', 'gridmax' ), 'section' => 'header_image', 'settings' => 'gridmax_options[hide_header_image]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[remove_header_image_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_remove_header_image_link_control', array( 'label' => esc_html__( 'Remove Link from Header Image', 'gridmax' ), 'section' => 'header_image', 'settings' => 'gridmax_options[remove_header_image_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_header_image_details]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_header_image_details_control', array( 'label' => esc_html__( 'Hide both Title and Description from Header Image', 'gridmax' ), 'section' => 'header_image', 'settings' => 'gridmax_options[hide_header_image_details]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_header_image_description]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_header_image_description_control', array( 'label' => esc_html__( 'Hide Description from Header Image', 'gridmax' ), 'section' => 'header_image', 'settings' => 'gridmax_options[hide_header_image_description]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[header_image_custom_text]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_header_image_custom_text_control', array( 'label' => esc_html__( 'Add Custom Title/Custom Description to Header Image', 'gridmax' ), 'section' => 'header_image', 'settings' => 'gridmax_options[header_image_custom_text]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[header_image_custom_title]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_html', ) );

    $wp_customize->add_control( 'gridmax_header_image_custom_title_control', array( 'label' => esc_html__( 'Header Image Custom Title', 'gridmax' ), 'section' => 'header_image', 'settings' => 'gridmax_options[header_image_custom_title]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'gridmax_options[header_image_custom_description]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_html', ) );

    $wp_customize->add_control( 'gridmax_header_image_custom_description_control', array( 'label' => esc_html__( 'Header Image Custom Description', 'gridmax' ), 'section' => 'header_image', 'settings' => 'gridmax_options[header_image_custom_description]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'gridmax_options[header_image_destination]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_header_image_destination_control', array( 'label' => esc_html__( 'Header Image Destination URL', 'gridmax' ), 'description' => esc_html__( 'Enter the URL a visitor should go when he/she click on the header image. If you did not enter a URL below, header image will be linked to the homepage of your website.', 'gridmax' ), 'section' => 'header_image', 'settings' => 'gridmax_options[header_image_destination]', 'type' => 'text' ) );


    /* Posts Grid options */
    $wp_customize->add_section( 'gridmax_section_posts_grid', array( 'title' => esc_html__( 'Posts Grid Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 160 ) );

    $wp_customize->add_setting( 'gridmax_options[hide_posts_heading]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_posts_heading_control', array( 'label' => esc_html__( 'Hide HomePage Posts Heading', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_posts_heading]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[posts_heading]', array( 'default' => esc_html__( 'Recent Posts', 'gridmax' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field', ) );

    $wp_customize->add_control( 'gridmax_posts_heading_control', array( 'label' => esc_html__( 'HomePage Posts Heading', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[posts_heading]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'gridmax_options[read_more_length]', array( 'default' => 17, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_read_more_length' ) );

    $wp_customize->add_control( 'gridmax_read_more_length_control', array( 'label' => esc_html__( 'Auto Post Summary Length', 'gridmax' ), 'description' => esc_html__('Enter the number of words need to display in the post summary. Default is 20 words.', 'gridmax'), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[read_more_length]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_author_image_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_author_image_home_control', array( 'label' => esc_html__( 'Hide Post Author Images from Posts Grid', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_post_author_image_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[author_image_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_author_image_link_control', array( 'label' => esc_html__( 'Link Author Image to Author Posts URL', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[author_image_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_title_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_title_home_control', array( 'label' => esc_html__( 'Hide Post Titles from Posts Grid', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_post_title_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_posted_date_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_posted_date_home_control', array( 'label' => esc_html__( 'Hide Posted Dates from Posts Grid', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_posted_date_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_author_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_author_home_control', array( 'label' => esc_html__( 'Hide Post Authors from Posts Grid', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_post_author_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_categories_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_categories_home_control', array( 'label' => esc_html__( 'Hide Post Categories from Posts Grid', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_post_categories_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_comments_link_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_comments_link_home_control', array( 'label' => esc_html__( 'Hide Comment Links from Posts Grid', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_comments_link_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_thumbnail_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_thumbnail_home_control', array( 'label' => esc_html__( 'Hide Featured Images from Posts Grid', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_thumbnail_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_default_thumbnail]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_default_thumbnail_control', array( 'label' => esc_html__( 'Hide Default Image', 'gridmax' ), 'description' => esc_html__( 'The default image is shown when there is no featured image.', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_default_thumbnail]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_snippet]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_snippet_control', array( 'label' => esc_html__( 'Hide Post Snippets from Posts Grid', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[hide_post_snippet]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[disable_posts_grid]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_disable_posts_grid_control', array( 'label' => esc_html__( 'Activate Non-Grid Posts', 'gridmax' ), 'description' => __( 'Check this option if you want to disable posts grid and display posts in normal way.', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[disable_posts_grid]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[featured_nongrid_media_under_post_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_featured_nongrid_media_under_post_title_control', array( 'label' => esc_html__( 'Move Featured Image to Bottom of Non-Grid Post Title', 'gridmax' ), 'section' => 'gridmax_section_posts_grid', 'settings' => 'gridmax_options[featured_nongrid_media_under_post_title]', 'type' => 'checkbox', ) );


    /* Post options */
    $wp_customize->add_section( 'gridmax_section_post', array( 'title' => esc_html__( 'Singular Post Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 180 ) );

    $wp_customize->add_setting( 'gridmax_options[thumbnail_link]', array( 'default' => 'yes', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_thumbnail_link' ) );

    $wp_customize->add_control( 'gridmax_thumbnail_link_control', array( 'label' => esc_html__( 'Featured Image Link', 'gridmax' ), 'description' => esc_html__('Do you want the featured image in a single post to be linked to its post?', 'gridmax'), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[thumbnail_link]', 'type' => 'select', 'choices' => array( 'yes' => esc_html__('Yes', 'gridmax'), 'no' => esc_html__('No', 'gridmax') ) ) );

    $wp_customize->add_setting( 'gridmax_options[hide_thumbnail]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_thumbnail_control', array( 'label' => esc_html__( 'Hide Featured Image from Full Post', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_thumbnail]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[featured_media_under_post_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_featured_media_under_post_title_control', array( 'label' => esc_html__( 'Move Featured Image to Bottom of Full Post Title', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[featured_media_under_post_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_title_control', array( 'label' => esc_html__( 'Hide Post Header from Full Post', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_post_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[remove_post_title_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_remove_post_title_link_control', array( 'label' => esc_html__( 'Remove Link from Full Post Title', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[remove_post_title_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_categories]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_categories_control', array( 'label' => esc_html__( 'Hide Post Categories from Full Post', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_post_categories]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_author]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_author_control', array( 'label' => esc_html__( 'Hide Post Author from Full Post', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_post_author]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_posted_date]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_posted_date_control', array( 'label' => esc_html__( 'Hide Posted Date from Full Post', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_posted_date]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_comments_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_comments_link_control', array( 'label' => esc_html__( 'Hide Comment Link from Full Post', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_comments_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_edit]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_edit_control', array( 'label' => esc_html__( 'Hide Post Edit Link', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_post_edit]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_tags]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_tags_control', array( 'label' => esc_html__( 'Hide Post Tags from Full Post', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_post_tags]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_author_bio_box]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_author_bio_box_control', array( 'label' => esc_html__( 'Hide Author Bio Box', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[hide_author_bio_box]', 'type' => 'checkbox', ) );


    /* Navigation options */
    $wp_customize->add_section( 'gridmax_section_navigation', array( 'title' => esc_html__( 'Posts Navigation Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 190 ) );

    $wp_customize->add_setting( 'gridmax_options[hide_post_navigation]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_post_navigation_control', array( 'label' => esc_html__( 'Hide Post Navigation from Full Posts', 'gridmax' ), 'section' => 'gridmax_section_navigation', 'settings' => 'gridmax_options[hide_post_navigation]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_posts_navigation]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_posts_navigation_control', array( 'label' => esc_html__( 'Hide Posts Navigation from Home/Archive/Search Pages', 'gridmax' ), 'section' => 'gridmax_section_navigation', 'settings' => 'gridmax_options[hide_posts_navigation]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[posts_navigation_type]', array( 'default' => 'numberednavi', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_posts_navigation_type' ) );

    $wp_customize->add_control( 'gridmax_posts_navigation_type_control', array( 'label' => esc_html__( 'Posts Navigation Type', 'gridmax' ), 'description' => esc_html__('Select posts navigation type you need. If you activate WP-PageNavi plugin, this navigation will be replaced by WP-PageNavi navigation.', 'gridmax'), 'section' => 'gridmax_section_navigation', 'settings' => 'gridmax_options[posts_navigation_type]', 'type' => 'select', 'choices' => array( 'normalnavi' => esc_html__('Normal Navigation', 'gridmax'), 'numberednavi' => esc_html__('Numbered Navigation', 'gridmax') ) ) );


    /* Page options */
    $wp_customize->add_section( 'gridmax_section_page', array( 'title' => esc_html__( 'Singular Page Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 185 ) );

    $wp_customize->add_setting( 'gridmax_options[thumbnail_link_page]', array( 'default' => 'yes', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_thumbnail_link' ) );

    $wp_customize->add_control( 'gridmax_thumbnail_link_page_control', array( 'label' => esc_html__( 'Featured Image Link', 'gridmax' ), 'description' => esc_html__('Do you want the featured image in a page to be linked to its page?', 'gridmax'), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[thumbnail_link_page]', 'type' => 'select', 'choices' => array( 'yes' => esc_html__('Yes', 'gridmax'), 'no' => esc_html__('No', 'gridmax') ) ) );

    $wp_customize->add_setting( 'gridmax_options[hide_page_thumbnail]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_page_thumbnail_control', array( 'label' => esc_html__( 'Hide Featured Image from Single Page', 'gridmax' ), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[hide_page_thumbnail]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[featured_media_under_page_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_featured_media_under_page_title_control', array( 'label' => esc_html__( 'Move Featured Image to Bottom of Page Title', 'gridmax' ), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[featured_media_under_page_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_page_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_page_title_control', array( 'label' => esc_html__( 'Hide Page Header from Single Page', 'gridmax' ), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[hide_page_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[remove_page_title_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_remove_page_title_link_control', array( 'label' => esc_html__( 'Remove Link from Single Page Title', 'gridmax' ), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[remove_page_title_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_page_date]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_page_date_control', array( 'label' => esc_html__( 'Hide Posted Date from Single Page', 'gridmax' ), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[hide_page_date]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_page_author]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_page_author_control', array( 'label' => esc_html__( 'Hide Page Author from Single Page', 'gridmax' ), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[hide_page_author]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_page_comments]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_page_comments_control', array( 'label' => esc_html__( 'Hide Comment Link from Single Page', 'gridmax' ), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[hide_page_comments]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_page_edit]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_page_edit_control', array( 'label' => esc_html__( 'Hide Edit Link from Single Page', 'gridmax' ), 'section' => 'gridmax_section_page', 'settings' => 'gridmax_options[hide_page_edit]', 'type' => 'checkbox', ) );


    /* Social profiles options */
    $wp_customize->add_section( 'gridmax_section_social', array( 'title' => esc_html__( 'Social Buttons Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 240, ));

    $wp_customize->add_setting( 'gridmax_options[hide_footer_social_buttons]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_footer_social_buttons_control', array( 'label' => esc_html__( 'Hide Footer Social + Random + Login/Logout Buttons', 'gridmax' ), 'description' => esc_html__('If you checked this option, all buttons will disappear from footer. There is no any effect from these option: "Show Login/Logout Button in Footer".', 'gridmax'), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[hide_footer_social_buttons]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[show_footer_login_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_show_footer_login_button_control', array( 'label' => esc_html__( 'Show Login/Logout Button in Footer', 'gridmax' ), 'description' => esc_html__('This option has no effect if you checked the option: "Hide Footer Social + Random + Login/Logout Buttons"', 'gridmax'), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[show_footer_login_button]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[twitterlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_twitterlink_control', array( 'label' => esc_html__( 'Twitter URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[twitterlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[facebooklink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_facebooklink_control', array( 'label' => esc_html__( 'Facebook URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[facebooklink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[googlelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) ); 

    $wp_customize->add_control( 'gridmax_googlelink_control', array( 'label' => esc_html__( 'Google Plus URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[googlelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[pinterestlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_pinterestlink_control', array( 'label' => esc_html__( 'Pinterest URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[pinterestlink]', 'type' => 'text' ) );
    
    $wp_customize->add_setting( 'gridmax_options[linkedinlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_linkedinlink_control', array( 'label' => esc_html__( 'Linkedin Link', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[linkedinlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[instagramlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_instagramlink_control', array( 'label' => esc_html__( 'Instagram Link', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[instagramlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[vklink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_vklink_control', array( 'label' => esc_html__( 'VK Link', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[vklink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[flickrlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_flickrlink_control', array( 'label' => esc_html__( 'Flickr Link', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[flickrlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[youtubelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_youtubelink_control', array( 'label' => esc_html__( 'Youtube URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[youtubelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[vimeolink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_vimeolink_control', array( 'label' => esc_html__( 'Vimeo URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[vimeolink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[soundcloudlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_soundcloudlink_control', array( 'label' => esc_html__( 'Soundcloud URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[soundcloudlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[messengerlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_messengerlink_control', array( 'label' => esc_html__( 'Messenger URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[messengerlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[whatsapplink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_whatsapplink_control', array( 'label' => esc_html__( 'WhatsApp URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[whatsapplink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[lastfmlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_lastfmlink_control', array( 'label' => esc_html__( 'Lastfm URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[lastfmlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[mediumlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_mediumlink_control', array( 'label' => esc_html__( 'Medium URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[mediumlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[githublink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_githublink_control', array( 'label' => esc_html__( 'Github URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[githublink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[bitbucketlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_bitbucketlink_control', array( 'label' => esc_html__( 'Bitbucket URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[bitbucketlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[tumblrlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_tumblrlink_control', array( 'label' => esc_html__( 'Tumblr URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[tumblrlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[digglink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_digglink_control', array( 'label' => esc_html__( 'Digg URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[digglink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[deliciouslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_deliciouslink_control', array( 'label' => esc_html__( 'Delicious URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[deliciouslink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[stumblelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_stumblelink_control', array( 'label' => esc_html__( 'Stumbleupon URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[stumblelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[mixlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_mixlink_control', array( 'label' => esc_html__( 'Mix URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[mixlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[redditlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_redditlink_control', array( 'label' => esc_html__( 'Reddit URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[redditlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[dribbblelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_dribbblelink_control', array( 'label' => esc_html__( 'Dribbble URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[dribbblelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[flipboardlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_flipboardlink_control', array( 'label' => esc_html__( 'Flipboard URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[flipboardlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[bloggerlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_bloggerlink_control', array( 'label' => esc_html__( 'Blogger URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[bloggerlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[etsylink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_etsylink_control', array( 'label' => esc_html__( 'Etsy URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[etsylink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[behancelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_behancelink_control', array( 'label' => esc_html__( 'Behance URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[behancelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[amazonlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_amazonlink_control', array( 'label' => esc_html__( 'Amazon URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[amazonlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[meetuplink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_meetuplink_control', array( 'label' => esc_html__( 'Meetup URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[meetuplink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[mixcloudlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_mixcloudlink_control', array( 'label' => esc_html__( 'Mixcloud URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[mixcloudlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[slacklink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_slacklink_control', array( 'label' => esc_html__( 'Slack URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[slacklink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[snapchatlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_snapchatlink_control', array( 'label' => esc_html__( 'Snapchat URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[snapchatlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[spotifylink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_spotifylink_control', array( 'label' => esc_html__( 'Spotify URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[spotifylink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[yelplink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_yelplink_control', array( 'label' => esc_html__( 'Yelp URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[yelplink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[wordpresslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_wordpresslink_control', array( 'label' => esc_html__( 'WordPress URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[wordpresslink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[twitchlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_twitchlink_control', array( 'label' => esc_html__( 'Twitch URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[twitchlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[telegramlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_telegramlink_control', array( 'label' => esc_html__( 'Telegram URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[telegramlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[bandcamplink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_bandcamplink_control', array( 'label' => esc_html__( 'Bandcamp URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[bandcamplink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[quoralink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_quoralink_control', array( 'label' => esc_html__( 'Quora URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[quoralink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[foursquarelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_foursquarelink_control', array( 'label' => esc_html__( 'Foursquare URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[foursquarelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[deviantartlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_deviantartlink_control', array( 'label' => esc_html__( 'DeviantArt URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[deviantartlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[imdblink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_imdblink_control', array( 'label' => esc_html__( 'IMDB URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[imdblink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[codepenlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_codepenlink_control', array( 'label' => esc_html__( 'Codepen URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[codepenlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[jsfiddlelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_jsfiddlelink_control', array( 'label' => esc_html__( 'JSFiddle URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[jsfiddlelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[stackoverflowlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_stackoverflowlink_control', array( 'label' => esc_html__( 'Stack Overflow URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[stackoverflowlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[stackexchangelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_stackexchangelink_control', array( 'label' => esc_html__( 'Stack Exchange URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[stackexchangelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[bsalink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_bsalink_control', array( 'label' => esc_html__( 'BuySellAds URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[bsalink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[web500pxlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_web500pxlink_control', array( 'label' => esc_html__( '500px URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[web500pxlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[ellolink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_ellolink_control', array( 'label' => esc_html__( 'Ello URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[ellolink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[discordlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_discordlink_control', array( 'label' => esc_html__( 'Discord URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[discordlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[goodreadslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_goodreadslink_control', array( 'label' => esc_html__( 'Goodreads URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[goodreadslink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[odnoklassnikilink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_odnoklassnikilink_control', array( 'label' => esc_html__( 'Odnoklassniki URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[odnoklassnikilink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[houzzlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_houzzlink_control', array( 'label' => esc_html__( 'Houzz URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[houzzlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[pocketlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_pocketlink_control', array( 'label' => esc_html__( 'Pocket URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[pocketlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[xinglink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_xinglink_control', array( 'label' => esc_html__( 'XING URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[xinglink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[googleplaylink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_googleplaylink_control', array( 'label' => esc_html__( 'Google Play URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[googleplaylink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[slidesharelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_slidesharelink_control', array( 'label' => esc_html__( 'SlideShare URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[slidesharelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[dropboxlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_dropboxlink_control', array( 'label' => esc_html__( 'Dropbox URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[dropboxlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[paypallink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_paypallink_control', array( 'label' => esc_html__( 'PayPal URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[paypallink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[viadeolink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_viadeolink_control', array( 'label' => esc_html__( 'Viadeo URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[viadeolink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[wikipedialink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_wikipedialink_control', array( 'label' => esc_html__( 'Wikipedia URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[wikipedialink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[skypeusername]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field' ) );

    $wp_customize->add_control( 'gridmax_skypeusername_control', array( 'label' => esc_html__( 'Skype Username', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[skypeusername]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[emailaddress]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_email' ) );

    $wp_customize->add_control( 'gridmax_emailaddress_control', array( 'label' => esc_html__( 'Email Address', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[emailaddress]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[rsslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridmax_rsslink_control', array( 'label' => esc_html__( 'RSS Feed URL', 'gridmax' ), 'section' => 'gridmax_section_social', 'settings' => 'gridmax_options[rsslink]', 'type' => 'text' ) );


    /* Footer options */
    $wp_customize->add_section( 'gridmax_section_footer', array( 'title' => esc_html__( 'Footer Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 280 ) );

    $wp_customize->add_setting( 'gridmax_options[footer_text]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_html', ) );

    $wp_customize->add_control( 'gridmax_footer_text_control', array( 'label' => esc_html__( 'Footer copyright notice', 'gridmax' ), 'section' => 'gridmax_section_footer', 'settings' => 'gridmax_options[footer_text]', 'type' => 'textarea', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_footer_widgets]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_footer_widgets_control', array( 'label' => esc_html__( 'Hide Footer Widgets', 'gridmax' ), 'section' => 'gridmax_section_footer', 'settings' => 'gridmax_options[hide_footer_widgets]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridmax_options[disable_backtotop]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_disable_backtotop_control', array( 'label' => esc_html__( 'Disable Back to Top Button', 'gridmax' ), 'section' => 'gridmax_section_footer', 'settings' => 'gridmax_options[disable_backtotop]', 'type' => 'checkbox', ) );


    /* Search and 404 options */
    $wp_customize->add_section( 'gridmax_section_search_404', array( 'title' => esc_html__( 'Search and 404 Pages Options', 'gridmax' ), 'panel' => 'gridmax_main_options_panel', 'priority' => 340 ) );

    $wp_customize->add_setting( 'gridmax_options[no_search_heading]', array( 'default' => esc_html__( 'Nothing Found', 'gridmax' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_html', ) );

    $wp_customize->add_control( 'gridmax_no_search_heading_control', array( 'label' => esc_html__( 'No Search Results Heading', 'gridmax' ), 'description' => esc_html__( 'Enter a heading to display when no search results are found.', 'gridmax' ), 'section' => 'gridmax_section_search_404', 'settings' => 'gridmax_options[no_search_heading]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[no_search_results]', array( 'default' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'gridmax' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_html', ) );

    $wp_customize->add_control( 'gridmax_no_search_results_control', array( 'label' => esc_html__( 'No Search Results Message', 'gridmax' ), 'description' => esc_html__( 'Enter a message to display when no search results are found.', 'gridmax' ), 'section' => 'gridmax_section_search_404', 'settings' => 'gridmax_options[no_search_results]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[error_404_heading]', array( 'default' => esc_html__( 'Oops! That page can not be found.', 'gridmax' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_html', ) );

    $wp_customize->add_control( 'gridmax_error_404_heading_control', array( 'label' => esc_html__( '404 Error Page Heading', 'gridmax' ), 'description' => esc_html__( 'Enter the heading for the 404 error page.', 'gridmax' ), 'section' => 'gridmax_section_search_404', 'settings' => 'gridmax_options[error_404_heading]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridmax_options[error_404_message]', array( 'default' => esc_html__( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'gridmax' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_html', ) );

    $wp_customize->add_control( 'gridmax_error_404_message_control', array( 'label' => esc_html__( 'Error 404 Message', 'gridmax' ), 'description' => esc_html__( 'Enter a message to display on the 404 error page.', 'gridmax' ), 'section' => 'gridmax_section_search_404', 'settings' => 'gridmax_options[error_404_message]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'gridmax_options[hide_404_search]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_hide_404_search_control', array( 'label' => esc_html__( 'Hide Search Box from 404 Page', 'gridmax' ), 'section' => 'gridmax_section_search_404', 'settings' => 'gridmax_options[hide_404_search]', 'type' => 'checkbox', ) );


    /* Other options */
    $wp_customize->add_setting( 'gridmax_options[disable_fitvids]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridmax_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridmax_disable_fitvids_control', array( 'label' => esc_html__( 'Disable FitVids.JS', 'gridmax' ), 'description' => esc_html__( 'You can disable fitvids.js script if you are not using videos on your website or if you do not want fluid width videos in your post content.', 'gridmax' ), 'section' => 'gridmax_section_post', 'settings' => 'gridmax_options[disable_fitvids]', 'type' => 'checkbox', ) );


    /* Upgrade to pro options */
    $wp_customize->add_section( 'gridmax_section_upgrade', array( 'title' => esc_html__( 'Upgrade to Pro Version', 'gridmax' ), 'priority' => 400 ) );
    
    $wp_customize->add_setting( 'gridmax_options[upgrade_text]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );
    
    $wp_customize->add_control( new GridMax_Customize_Static_Text_Control( $wp_customize, 'gridmax_upgrade_text_control', array(
        'label'       => esc_html__( 'GridMax Pro', 'gridmax' ),
        'section'     => 'gridmax_section_upgrade',
        'settings' => 'gridmax_options[upgrade_text]',
        'description' => esc_html__( 'Do you enjoy GridMax? Upgrade to GridMax Pro now and get:', 'gridmax' ).
            '<ul class="gridmax-customizer-pro-features">' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Color Options', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Font Options', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '1/2/3/4/5/6/7/8/9/10 Columns Options for Posts Grids', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '10+ Thumbnail Sizes Options for Posts Grids', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Switch between Masonry Grid (JavaScript based) and CSS only Grid', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Display Ads/Custom Contents between Posts in the Grid', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '10+ Layout Styles for Posts/Pages', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '10+ Layout Styles for Non-Singular Pages', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Width Change Options for Full Website/Main Content/Left Sidebar/Right Sidebar', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '10+ Custom Page Templates', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '10+ Custom Post Templates', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '3 Header Layouts with Width options - (Logo + Primary Menu) / (Logo + Header Banner) / (Full Width Header)', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Footer with Layout Options (1/2/3/4/5/6 columns)', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Change Website Width/Layout Style/Header Style/Footer Style of any Post/Page', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Capability to Add Different Header Images for Each Post/Page with Unique Link, Title and Description', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Grid Featured Posts Widget (Recent/Categories/Tags/PostIDs based) - 1 to 10 columns are supported- with capability to display posts according to Likes/Views/Comments/Dates/... and there are many options', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'List Featured Posts Widget (Recent/Categories/Tags/PostIDs based) - with capability to display posts according to Likes/Views/Comments/Dates/... and there are many options', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Tabbed Widget (Recent/Categories/Tags/PostIDs based) - with capability to display posts according to Likes/Views/Comments/Dates/... and there are many options.', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'About and Social Widget - 60+ Social Buttons', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'News Ticker (Recent/Categories/Tags/PostIDs based) - It can display posts according to Likes/Views/Comments/Dates/... and there are many options.', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Settings Panel to Control Options in Each Post', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Settings Panel to Control Options in Each Page', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Posts Views Counter', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Posts Likes System', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Infinite Scroll and Load More Button', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Post Share Buttons with Options - 25+ Social Networks are Supported', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Related Posts (Categories/Tags/Author/PostIDs based) with Many Options - For both single posts and post summaries', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Sticky Menu/Sticky Sidebars with enable/disable capability', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Author Bio Box with Social Buttons - 60+ Social Buttons', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Secondary Navigation Menu in Footer', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Enable/Disable Mobile View from Primary and Secondary Menus', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Post Navigation with Thumbnails', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to add Ads under Post Title and under Post Content', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Disable Google Fonts - for faster loading', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'More Widget Areas', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Contact Form', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'WooCommerce Compatible', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Yoast SEO Breadcrumbs Support', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Full RTL Language Support', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Search Engine Optimized', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Random Posts Button in Footer', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Many Useful Customizer Theme options', 'gridmax' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'More Features...', 'gridmax' ) . '</li>' .
            '</ul>'.
            '<strong><a href="'.GRIDMAX_PROURL.'" class="button button-primary" target="_blank"><i class="fas fa-shopping-cart" aria-hidden="true"></i> ' . esc_html__( 'Upgrade To GridMax PRO', 'gridmax' ) . '</a></strong>'
    ) ) );

}

add_action( 'customize_register', 'gridmax_register_theme_customizer' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function gridmax_customize_partial_blogname() {
    bloginfo( 'name' );
}
/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function gridmax_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

function gridmax_customizer_js_scripts() {
    wp_enqueue_script('gridmax-theme-customizer-js', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery', 'customize-preview' ), NULL, true);
}
add_action( 'customize_preview_init', 'gridmax_customizer_js_scripts' );