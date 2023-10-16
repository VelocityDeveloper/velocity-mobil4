<?php

/**
 * Post rendering content according to caller of get_template_part
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

global $post;
$harga = get_post_meta($post->ID, 'ak_harga', true);
$stok = get_post_meta($post->ID, 'ak_stok', true);
$kode = get_post_meta($post->ID, 'ak_kode', true);
$harga_dis = get_post_meta($post->ID, 'ak_harga_dis', true);
?>

<article <?php post_class('block-primary mb-4'); ?> id="post-<?php the_ID(); ?>">

    <div class="entry-content">

        <div class="mb-3">
            <div class="row m-0 py-3">
                <div class="col-md-6 mb-2 text-center p-1">
                    <?php if (has_post_thumbnail()) { ?>
                        <img src="<?php the_post_thumbnail_url('full'); ?> " />
                    <?php } ?>
                </div>
                <div class="col-md-6 p-1">
                    <?php the_title('<h3 class="entry-title fw-bold">', '</h3>'); ?>
                    <table class="table">
                        <tbody>
                            <?php if (!empty($stok)) { ?>
                                <tr>
                                    <th>Stock Produk</th>
                                    <td><?php echo $stok; ?></td>
                                </tr>
                            <?php } ?>
                            <?php if (!empty($kode)) { ?>
                                <tr>
                                    <th>Kode Produk</th>
                                    <td><?php echo $kode; ?></td>
                                </tr>
                            <?php } ?>
                            <?php if (!empty($harga)) { ?>
                                <tr>
                                    <th>Harga</th>
                                    <td><?php echo velocity_harga(); ?></td>
                                </tr>
                            <?php } ?>
                            <?php if (!empty($harga_dis)) {
                                $diskonper = ($harga_dis / $harga) * 100;
                                $diskonjadi = 100 - $diskonper;
                                echo '<tr><th>Anda Hemat</th><td>' . number_format($diskonjadi, 1, ',', '') . '%</td></tr>';
                            } else {
                                echo '<tr><th>Anda Hemat</th><td>0 %</td></tr>';
                            }
                            ?>
                            <?php $args = array(
                                'orderby' => 'term_order',
                            );
                            $kategori_produk = wp_get_object_terms($post->ID,  'kategori-produk', $args);
                            //echo '<pre>'.print_r($kategori_produk,1).'</pre>'; 
                            if (!empty($kategori_produk)) {
                                if (!is_wp_error($kategori_produk)) {
                                    echo '<tr>';
                                    echo '<th>Kategori</th>';
                                    echo '<td>';
                                    foreach (array_reverse($kategori_produk) as $term) {
                                        echo '<span><a  class="text-dark" href="' . esc_url(get_term_link($term->slug, 'kategori-produk')) . '">' . esc_html($term->name) . '</a></span>, ';
                                    }
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                            <tr>
                                <th>Dilihat</th>
                                <td><?php echo get_post_meta(get_the_ID(), 'hit', true); ?> kali</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <h3 class="fw-bold">Detail Produk</h3>
                    <?php echo get_the_content(); ?>
                </div>
            </div>
        </div>

    </div>

</article><!-- #post-## -->