<?php

/**
 * Template Name: Pricelist Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 * Good for landingpages and other types of pages where you want to add a lot of custom markup.
 *
 * @package justg
 */

get_header();
$container         = velocitytheme_option('justg_container_type', 'container');
?>

<div class="wrapper" id="page-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content">

        <div class="row">

            <div class="content-area col order-2" id="primary">

                <main class="site-main" id="main" role="main">
                    <?php the_title('<h3 class="entry-title fw-bold">', '</h3>'); ?>
                    <?php
                    $args = array(
                        'post_type' => 'produk',
                        'post_status' => 'publish',
                        'posts_per_page ' => -1,
                    );
                    $the_query = new WP_Query($args); ?>
                    <div class="text-end">
                        <button class="btn btn-warning text-end rounded-0" name="print" value="Print Pricelist" onclick="window.print()">Print Pricelist <i class="fa fa-print" aria-hidden="true"></i></button>
                    </div>
                    <div class="table-responsive my-2">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th style="background-color:#ffca2c;">Kode</th>
                                <th style="background-color:#ffca2c;">Nama Barang</th>
                                <th style="background-color:#ffca2c;">Gambar</th>
                                <th style="background-color:#ffca2c;">Stok</th>
                                <th style="background-color:#ffca2c;">Harga</th>
                            </thead>
                            <?php
                            if ($the_query->have_posts()) :
                                while ($the_query->have_posts()) :
                                    $the_query->the_post();
                                    $idpost = get_the_ID();
                            ?>
                                    <tr>
                                        <td><?php echo get_post_meta($idpost, 'ak_kode', true); ?></td>
                                        <td><?php echo get_the_title(); ?></td>
                                        <td style="max-width:60px;"><?php echo do_shortcode('[resize-thumbnail width="90" height="50" linked="false" class="w-100"]'); ?></td>
                                        <td><?php echo get_post_meta($idpost, 'ak_stok', true); ?></td>
                                        <td><?php echo velocity_harga(); ?></td>
                                    </tr>
                            <?php
                                endwhile;
                            endif; ?>
                        </table>
                    </div>
                    <?php
                    wp_reset_postdata();
                    ?>

                </main><!-- #main -->

            </div>

        </div>

    </div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
