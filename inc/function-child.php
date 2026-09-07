<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{

    // Load justg_child_enqueue_parent_style after theme setup
    add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 999);

    //remove action from Parent Theme
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
    remove_theme_support('widgets-block-editor');
}

if (!function_exists('velocity_mobil4_option')) {
    function velocity_mobil4_option($name, $default = '')
    {
        return function_exists('velocitytheme_option')
            ? velocitytheme_option($name, $default)
            : get_theme_mod($name, $default);
    }
}

if (!function_exists('velocity_mobil4_first_content_image')) {
    function velocity_mobil4_first_content_image($post_id)
    {
        $content = (string) get_post_field('post_content', $post_id);
        if (function_exists('parse_blocks')) {
            $blocks = parse_blocks($content);
            $queue  = $blocks;
            while ($queue) {
                $block = array_shift($queue);
                if ('core/image' === ($block['blockName'] ?? '') && !empty($block['attrs']['id'])) {
                    $url = wp_get_attachment_image_url((int) $block['attrs']['id'], 'full');
                    if ($url) {
                        return $url;
                    }
                }
                if (!empty($block['innerBlocks'])) {
                    $queue = array_merge($block['innerBlocks'], $queue);
                }
            }
        }
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $match)) {
            return esc_url_raw(html_entity_decode($match[1]));
        }
        return '';
    }
}

if (!function_exists('velocity_mobil4_thumbnail_url')) {
    function velocity_mobil4_thumbnail_url($post_id = null)
    {
        $post_id = $post_id ?: get_the_ID();
        $url = get_the_post_thumbnail_url($post_id, 'full');
        if (!$url) {
            $url = velocity_mobil4_first_content_image($post_id);
        }
        return $url ?: get_stylesheet_directory_uri() . '/img/no-image.webp';
    }
}

if (!function_exists('velocity_mobil4_thumbnail')) {
    function velocity_mobil4_thumbnail($post_id = null, $ratio = 'ratio-4x3', $class = '', $show_caption = false)
    {
        $post_id = $post_id ?: get_the_ID();
        $caption = has_post_thumbnail($post_id) ? wp_get_attachment_caption(get_post_thumbnail_id($post_id)) : '';
        $html  = '<figure class="m-0">';
        $html .= '<a class="ratio ' . esc_attr($ratio) . ' overflow-hidden" href="' . esc_url(get_permalink($post_id)) . '">';
        $html .= '<img class="w-100 h-100 object-fit-cover ' . esc_attr($class) . '" src="' . esc_url(velocity_mobil4_thumbnail_url($post_id)) . '" alt="' . esc_attr(get_the_title($post_id)) . '" loading="lazy">';
        $html .= '</a>';
        if ($show_caption && $caption) {
            $html .= '<figcaption class="figure-caption mt-2">' . wp_kses_post($caption) . '</figcaption>';
        }
        $html .= '</figure>';
        return $html;
    }
}


///remove breadcrumbs
add_action('wp_head', function () {
    if (!is_single()) {
        remove_action('justg_before_title', 'justg_breadcrumb');
    }
});

///add action builder part
add_action('justg_header', 'justg_header_berita');
if (!function_exists('justg_header_berita')) {
function justg_header_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
}
add_action('justg_do_footer', 'justg_footer_berita');
if (!function_exists('justg_footer_berita')) {
function justg_footer_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}
}
add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
if (!function_exists('justg_before_wrapper_content')) {
function justg_before_wrapper_content()
{
    // Card polos full-width: perataan pinggir mengandalkan .container di
    // dalam tiap template agar lurus dengan container header.
    echo '<div class="card rounded-0 border-light border-top-0 border-bottom-0 shadow">';
}
}
add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
if (!function_exists('justg_after_wrapper_content')) {
function justg_after_wrapper_content()
{
    echo '</div>';
}
}


// excerpt more
if (!function_exists('velocity_custom_excerpt_more')) {
    function velocity_custom_excerpt_more($more)
    {
        return '...';
    }
}
add_filter('excerpt_more', 'velocity_custom_excerpt_more');

// excerpt length
if (!function_exists('velocity_excerpt_length')) {
function velocity_excerpt_length($length)
{
    return 40;
}
}
add_filter('excerpt_length', 'velocity_excerpt_length');


//register widget
add_action('widgets_init', 'justg_widgets_init', 20);
if (!function_exists('justg_widgets_init')) {
    function justg_widgets_init()
    {
        register_sidebar(
            array(
                'name'          => __('Main Sidebar', 'justg'),
                'id'            => 'main-sidebar',
                'description'   => __('Main sidebar widget area', 'justg'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title"><span>',
                'after_title'   => '</span></h3>',
                'show_in_rest'   => false,
            )
        );
    }
}


if (!function_exists('justg_right_sidebar_check')) {
    function justg_right_sidebar_check()
    {
        if (is_singular('fl-builder-template')) {
            return;
        }
        if (!is_active_sidebar('main-sidebar')) {
            return;
        }
        echo '<div class="widget-area right-sidebar pt-3 pt-md-0 ps-md-3 ps-0 pe-0 col-md-4 order-3" id="right-sidebar" role="complementary">';
        do_action('justg_before_main_sidebar');
        dynamic_sidebar('main-sidebar');
        do_action('justg_after_main_sidebar');
        echo '</div>';
    }
}

if (!function_exists('velocity_mobil4_archive_thumb')) {
    /**
     * Thumbnail untuk kartu arsip/blog dengan fallback berantai:
     * featured image -> gambar pertama di konten -> lampiran pertama -> kosong (ikon).
     *
     * @return string Markup <img> atau string kosong bila tidak ada gambar.
     */
    function velocity_mobil4_archive_thumb($post_id = null, $size = 'medium_large')
    {
        $post_id = $post_id ?: get_the_ID();

        if (has_post_thumbnail($post_id)) {
            return get_the_post_thumbnail($post_id, $size, array('class' => 'w-100 h-100 object-fit-cover', 'loading' => 'lazy'));
        }

        // Gambar pertama di dalam konten (blok core/image atau tag <img>).
        $url = velocity_mobil4_first_content_image($post_id);
        if ($url) {
            return '<img src="' . esc_url($url) . '" class="w-100 h-100 object-fit-cover" alt="' . esc_attr(get_the_title($post_id)) . '" loading="lazy">';
        }

        // Lampiran pertama pada post (post lama yang gambarnya tidak di konten).
        $attachments = get_posts(array(
            'post_type'      => 'attachment',
            'posts_per_page' => 1,
            'post_parent'    => $post_id,
        ));
        if ($attachments && isset($attachments[0]->ID)) {
            return wp_get_attachment_image($attachments[0]->ID, $size, '', array('class' => 'w-100 h-100 object-fit-cover', 'loading' => 'lazy'));
        }

        return '';
    }
}
