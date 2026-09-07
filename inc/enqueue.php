<?php

/**
 * Enqueue child theme styles and scripts.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
if (!function_exists('justg_child_enqueue_parent_style')) {
    function justg_child_enqueue_parent_style()
    {
        // Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
        $parenthandle = 'parent-style';
        $theme = wp_get_theme();
		$parent = $theme->parent();

        // Load the stylesheet
        wp_enqueue_style(
            $parenthandle,
            get_template_directory_uri() . '/style.css',
            array(),  // if the parent theme code has a dependency, copy it to here
            $parent ? $parent->get('Version') : $theme->get('Version')
        );

        // $css_version = $theme->parent()->get('Version') . '.' . filemtime( get_stylesheet_directory() . '/css/custom.css' );
        $css_file = get_stylesheet_directory() . '/css/custom.css';
        $css_version = file_exists($css_file) ? filemtime($css_file) : $theme->get('Version');
        wp_enqueue_style(
            'custom-style',
            get_stylesheet_directory_uri() . '/css/custom.css',
            array(),  // if the parent theme code has a dependency, copy it to here
            $css_version
        );

        wp_enqueue_style(
            'velocity-google-fonts',
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
			array(),
			null
        );

        wp_enqueue_style(
            'child-style',
            get_stylesheet_uri(),
            array($parenthandle),
            $theme->get('Version')
        );

        $js_file = get_stylesheet_directory() . '/js/custom.js';
        $js_version = file_exists($js_file) ? filemtime($js_file) : $theme->get('Version');
        wp_enqueue_script('justg-custom-scripts', get_stylesheet_directory_uri() . '/js/custom.js', array(), $js_version, true);

		$primary_color = sanitize_hex_color(velocity_mobil4_option('primary_color', '#176cb7')) ?: '#176cb7';
		$primary_rgb = implode(',', sscanf($primary_color, '#%02x%02x%02x'));
		wp_add_inline_style('custom-style', ':root{--color-theme:' . $primary_color . ';--bs-primary:' . $primary_color . ';--bs-primary-rgb:' . $primary_rgb . ';}');
    }
}
