<?php
/**
 * Readly Theme Customizer
 *
 * @package Readly
 * @since Readly 1.2
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 *
 * @since Readly 1.2
 */
function readly_customize_register($wp_customize) {
	// Colors
	$wp_customize->add_section('readly_colors', array(
		'title' => __('Colors', 'readly'),
		'priority' => 35,
		'capability' => 'edit_theme_options',
		'description' => __('Allows you to customize some colors.', 'readly')
	));
	$wp_customize->add_setting('readly_background_color', array(
		'default' => wpShower::$background,
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));
	$wp_customize->add_setting('readly_color', array(
		'default' => wpShower::$color,
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Color_Control(
		$wp_customize,
		'readly_background_color',
		array(
			'label' => __('Background Color', 'readly'),
			'section' => 'readly_colors',
			'settings' => 'readly_background_color',
			'priority' => 10,
		)
	));
	$wp_customize->add_control(new WP_Customize_Color_Control(
		$wp_customize,
		'readly_color',
		array(
			'label' => __('Color', 'readly'),
			'section' => 'readly_colors',
			'settings' => 'readly_color',
			'priority' => 10,
		)
	));

	// Social networks
	$wp_customize->add_section('readly_social', array(
		'title' => __('Social networks', 'readly'),
		'priority' => 95,
		'capability' => 'edit_theme_options',
		'description' => __('Allows you to customize social network links.', 'readly')
	));
	$array = array(
		'twitter' => 'Twitter',
		'facebook' => 'Facebook',
		'instagram' => 'Instagram',
		'pinterest' => 'Pinterest',
		'dribbble' => 'Dribbble',
		'google' => 'Google+',
		'vimeo' => 'Vimeo',
		'flickr' => 'Flickr',
		'rss' => 'RSS'
	);
	$i = 0;
	foreach ($array as $key => $value) {
		$i++;
		$wp_customize->add_setting('readly_social['.$key.']', array(
			'default' => '',
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage'
		));
		$wp_customize->add_control('readly_social['.$key.']', array(
			'label' => __($value, 'readly'),
			'section' => 'readly_social',
			'type' => 'text',
			'priority' => $i
		));
	}

	// Page navigation
	$wp_customize->add_section('page_navigation', array(
		'title' => __('Page Navigation', 'readly'),
		'priority' => 100,
	));
	$wp_customize->add_setting('page_navigation', array(
		'default' => 'standard',
		'sanitize_callback' => 'sanitize_key',
	));
	$wp_customize->add_control('page_navigation', array(
		'section' => 'page_navigation',
		'type' => 'select',
		'choices' => array(
			'standard' => __('Standard', 'readly'),
			'ajax-fetch' => __('Load More Button', 'readly'),
			'infinite-scroll' => __('Infinite Scroll', 'readly'),
		),
	));

	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	$wp_customize->get_setting('readly_background_color')->transport = 'postMessage';
	$wp_customize->get_setting('readly_color')->transport = 'postMessage';
}

add_action('customize_register', 'readly_customize_register');

function readly_header_output() {
	$background_color = get_option('readly_background_color', wpShower::$background);
	$color = get_option('readly_color', wpShower::$color);

	echo '<style type="text/css" id="custom-background-css">
body, button, input, select, textarea, #page, #masthead, #colophon {
	background: '.$background_color.';
}
.entry-content a {
	border-bottom: 1px solid '.$background_color.';
}
a {
	color: '.$color.';
}
.entry-content a {
	-webkit-transition: border-bottom-color 0.2s linear;
	-moz-transition: border-bottom-color 0.2s linear;
	-o-transition: border-bottom-color 0.2s linear;
	transition: border-bottom-color 0.2s linear;
}
.entry-content a:hover {
	border-bottom-color: '.$color.';
}
.entry-content a.image_link:hover {
	border-bottom-color: '.$background_color.';
}
#masthead .site-title a, #site-navigation a, .sub-menu a, #nav-below a, .entry-title a, #image-navigation a {
	-webkit-transition: color 0.2s linear;
	-moz-transition: color 0.2s linear;
	-o-transition: color 0.2s linear;
	transition: color 0.2s linear;
}
#masthead .site-title a:hover, #nav-below a:hover, .entry-title a:hover, #image-navigation a:hover {
	color: '.$color.';
}
#s, #commentform input[type="text"], #commentform textarea, .password_protected, #social a, a.more-link {
	-webkit-transition: background-color 0.2s linear;
	-moz-transition: background-color 0.2s linear;
	-o-transition: background-color 0.2s linear;
	transition: background-color 0.2s linear;
}
a.more-link span {
	-webkit-transition: border-left-color 0.2s linear;
	-moz-transition: border-left-color 0.2s linear;
	-o-transition: border-left-color 0.2s linear;
	transition: border-left-color 0.2s linear;
}
#s:focus, #commentform input[type="text"]:focus, #commentform textarea:focus, .password_protected:focus {
	background-color: #fff;
}
#social a:hover {
	background-color: '.$color.';
}
.load-more a span.img {
	background-color: '.$background_color.';
}
a.more-link:hover {
	background-color: '.$color.';
	border-bottom-color: '.$background_color.';
}
a.more-link:hover span {
	border-left-color: '.$color.';
}
.entry-meta a, footer .site-info a, #comments a, .link_post_p a {
	-webkit-transition: color 0.2s linear, border-bottom-color 0.2s linear;
	-moz-transition: color 0.2s linear, border-bottom-color 0.2s linear;
	-o-transition: color 0.2s linear, border-bottom-color 0.2s linear;
	transition: color 0.2s linear, border-bottom-color 0.2s linear;
}
.entry-meta a:hover, footer .site-info a:hover, #comments a:hover, #comments a#cancel-comment-reply-link:hover, .link_post_p a:hover {
	color: '.$color.';
	border-bottom-color: '.$color.';
}
@media only screen and (min-width : 641px) {
	.sub-menu {
		background: '.$background_color.';
	}
	.sub-menu:before {
		border-bottom: 6px solid '.$background_color.';
	}
	#site-navigation a:hover, .sub-menu a:hover {
		color: '.$color.';
	}
}
html {
	position: relative;'.(is_admin_bar_showing() ? '
	min-height: -moz-calc(100% - 28px);
	min-height: -webkit-calc(100% - 28px);
	min-height: calc(100% - 28px);' : '
	min-height: 100%;').'
}
.hentry .mejs-controls .mejs-time-rail .mejs-time-current {
	background: '.$color.';
}
</style>
<script type="text/javascript">
var background_color = "'.$background_color.'";
var hover_color = "'.$color.'";
</script>';
}

add_action('wp_head', 'readly_header_output');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Readly 1.2
 */
function readly_customize_preview_js() {
	wp_enqueue_script('readly_customizer', get_template_directory_uri().'/js/customizer.js', array('customize-preview'), '20130304', true);
}

add_action('customize_preview_init', 'readly_customize_preview_js');
