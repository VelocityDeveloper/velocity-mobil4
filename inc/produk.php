<?php

// Register Custom Post Type & Taxonomy
add_action('init', 'velocity_admin_init');
if (!function_exists('velocity_admin_init')) {
function velocity_admin_init()
{
    register_post_type('produk', array(
        'labels' => array(
            'name' => 'Produk',
            'singular_name' => 'produk',
        ),
        'menu_icon' => 'dashicons-car',
        'public' => true,
        'has_archive' => true,
        'taxonomies' => array('kategori-produk'),
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),
    ));
    register_taxonomy(
        'kategori-produk',
        'produk',
        array(
            'label' => __('Kategori Produk'),
            'hierarchical' => true,
            'show_admin_column' => true,
        )
    );
}
}



// custom produk meta box
if (!function_exists('add_custom_meta_box')) {
function add_custom_meta_box()
{
    $screens = array('produk');
    foreach ($screens as $screen) {
        add_meta_box(
            'velocity_produk_meta',
            __('Detail Produk', 'velprodukdetail'),
            'vel_meta_box_callback',
            $screen
        );
    }
}
}
add_action('add_meta_boxes', 'add_custom_meta_box');

if (!function_exists('vel_meta_box_callback')) {
function vel_meta_box_callback($post)
{
    wp_nonce_field('vel_metabox', 'myplugin_meta_box_nonce');
    $harga = get_post_meta($post->ID, 'ak_harga', true);
    $stok = get_post_meta($post->ID, 'ak_stok', true);
    $kode = get_post_meta($post->ID, 'ak_kode', true);
    $harga_dis = get_post_meta($post->ID, 'ak_harga_dis', true);
    echo '<table class="form-table" role="presentation"><tbody>';
    echo '<tr>';
    echo '<th><label>Harga</label></th>';
    echo '<td><input type="number" name="ak_harga" value="' . esc_attr($harga) . '" size="25" />';
    echo '<br/><small>Isi nominalnya saja, contoh: 250000000</small>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label>Harga Diskon</label></th>';
    echo '<td><input type="number" name="ak_harga_dis" value="' . esc_attr($harga_dis) . '" size="25" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label>Stok</label></th>';
    echo '<td><input type="text" name="ak_stok" value="' . esc_attr($stok) . '" size="25" />';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label>Kode Produk</label></th>';
    echo '<td><input type="text" name="ak_kode" value="' . esc_attr($kode) . '" size="25" /></td>';
    echo '</tr>';
    echo '</tbody></table>';
}
}


if (!function_exists('vel_metabox')) {
function vel_metabox($post_id)
{
    if (!isset($_POST['myplugin_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['myplugin_meta_box_nonce'], 'vel_metabox')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }


    if (!isset($_POST['ak_harga'])) {
        return;
    }
    if (!isset($_POST['ak_stok'])) {
        return;
    }
    if (!isset($_POST['ak_kode'])) {
        return;
    }
    if (!isset($_POST['ak_harga_dis'])) {
        return;
    }
    // Update the meta field in the database.
    update_post_meta($post_id, 'ak_harga', sanitize_text_field($_POST['ak_harga']));
    update_post_meta($post_id, 'ak_stok', sanitize_text_field($_POST['ak_stok']));
    update_post_meta($post_id, 'ak_kode', sanitize_text_field($_POST['ak_kode']));
    update_post_meta($post_id, 'ak_harga_dis', sanitize_text_field($_POST['ak_harga_dis']));
}
}
add_action('save_post', 'vel_metabox');



if (!function_exists('velocity_harga')) {
function velocity_harga($postid = null)
{
    global $post;
    if (empty($postid)) {
        $post_id = $post->ID;
    } else {
        $post_id = $postid;
    }
    $price = get_post_meta($post_id, 'ak_harga', true);
    $price_dis = get_post_meta($post_id, 'ak_harga_dis', true);
    $html = '<span class="text-muted">';

    if ($price && $price_dis) {
        $harga = preg_replace('/[^0-9]/', '', $price);
        $hargadis = preg_replace('/[^0-9]/', '', $price_dis);
        $html .= '<span class="text-danger"><s>Rp ' . number_format($harga, 0, ',', '.') . '</s></span>';
        $html .= 'Rp ' . number_format($hargadis, 0, ',', '.');
    } elseif ($price) {
        $harga = preg_replace('/[^0-9]/', '', $price);
        $html .= 'Rp ' . number_format($harga, 0, ',', '.');
    } else {
        $html .= '(Hubungi Admin)';
    }
    $html .= '</span>';
    return $html;
}
}



// [velocity-produk]
if (!function_exists('velocity_katalog_produk')) {
function velocity_katalog_produk($atts)
{
    ob_start();
    $atribut = shortcode_atts(array(
        'style'     => 'grid', // grid | list
        'kategori'  => '',     // pakai slug
        'jumlah'    => 6,
    ), $atts);
    $args['posts_per_page'] = (int) $atribut['jumlah'];
    $args['post_type']      = 'produk';
    $kategori = $atribut['kategori'];
    $style    = ($atribut['style'] === 'list') ? 'list' : 'grid';
    if ($kategori) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'kategori-produk',
                'field'    => 'slug',
                'terms'    => $kategori,
            ),
        );
    }
    $wpex_query = new wp_query($args);
    echo '<div class="velocity-produk row g-3' . (('list' === $style) ? ' row-cols-1' : ' row-cols-2 row-cols-md-3') . '">';
    foreach ($wpex_query->posts as $post) {
        setup_postdata($post);
        $pid = $post->ID;
        if ('list' === $style) { ?>
            <div class="col">
                <div class="produk-item bg-white rounded-4 shadow-sm overflow-hidden h-100">
                    <div class="row g-0">
                        <div class="col-4 col-md-3"><?php echo velocity_mobil4_thumbnail($pid, 'ratio-4x3'); ?></div>
                        <div class="col-8 col-md-9 p-3 d-flex flex-column">
                            <h4 class="fs-6 fw-bold mb-2 lh-base"><a class="text-decoration-none text-dark" href="<?php echo esc_url(get_permalink($pid)); ?>"><?php echo esc_html(get_the_title($pid)); ?></a></h4>
                            <div class="produk-price fw-bold mb-3"><?php echo velocity_harga($pid); ?></div>
                            <div class="mt-auto"><a class="btn btn-sm btn-primary rounded-3" href="<?php echo esc_url(get_permalink($pid)); ?>">Detail</a></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col">
                <div class="produk-item bg-white rounded-4 shadow-sm overflow-hidden h-100 d-flex flex-column">
                    <?php echo velocity_mobil4_thumbnail($pid, 'ratio-4x3'); ?>
                    <div class="p-2 p-md-3 text-center d-flex flex-column flex-grow-1">
                        <h4 class="fs-6 fw-bold mb-2 lh-base"><a class="text-decoration-none text-dark" href="<?php echo esc_url(get_permalink($pid)); ?>"><?php echo esc_html(get_the_title($pid)); ?></a></h4>
                        <div class="produk-price fw-bold mb-3"><?php echo velocity_harga($pid); ?></div>
                        <a class="btn btn-sm btn-primary rounded-3 mt-auto" href="<?php echo esc_url(get_permalink($pid)); ?>">Detail</a>
                    </div>
                </div>
            </div>
        <?php }
    }
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
}
}
add_shortcode('velocity-produk', 'velocity_katalog_produk');
