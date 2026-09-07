<?php
/**
 * Template Name: Pricelist Template
 *
 * Tabel pricelist produk dengan hero biru seragam, Bootstrap 5,
 * gambar fallback berantai (same helper as archive loop),
 * dan tombol Print yang rapi.
 *
 * @package justg
 */

defined('ABSPATH') || exit;

get_header();
$container = velocity_mobil4_option('justg_container_type', 'container');
$total     = 0; // dikalkulasi nanti
?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr($container); ?>" id="content">

		<div class="row">

			<div class="content-area col order-2" id="primary">

				<main class="site-main" id="main" role="main">

					<?php
					$args = array(
						'post_type'      => 'produk',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
					);
					$the_query = new WP_Query($args);
					$total     = $the_query->found_posts;
					?>

					<!-- Hero -->
					<header class="page-hero bg-primary text-white rounded-4 shadow-sm p-3 p-md-4 mb-4">
						<div class="d-flex flex-wrap align-items-center gap-2 mb-2">
							<span class="badge rounded-pill bg-white text-primary fw-semibold">Pricelist</span>
							<span class="badge rounded-pill bg-white bg-opacity-25 fw-normal"><?php echo esc_html(number_format_i18n($total)); ?> produk</span>
						</div>
						<?php the_title('<h1 class="fs-3 fw-bold text-white mb-0">', '</h1>'); ?>
					</header>

					<?php if ($the_query->have_posts()) : ?>

					<!-- Tabel pricelist -->
					<div class="overflow-hidden">
						<div class="table-responsive">
							<table class="table table-striped table-hover align-middle mb-0">
								<thead class="table-light">
									<tr>
										<th scope="col" class="text-nowrap">Kode</th>
										<th scope="col">Nama</th>
										<th scope="col" class="text-center">Gambar</th>
										<th scope="col" class="text-center">Stok</th>
										<th scope="col" class="text-end text-nowrap">Harga</th>
									</tr>
								</thead>
								<tbody>
									<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
										<?php
										$pid  = get_the_ID();
										$kode = get_post_meta($pid, 'ak_kode', true);
										$stok = get_post_meta($pid, 'ak_stok', true);
										?>
										<tr>
											<td class="text-nowrap fw-semibold"><?php echo esc_html($kode ? $kode : '—'); ?></td>
											<td>
												<a class="fw-semibold text-decoration-none" href="<?php echo esc_url(get_permalink($pid)); ?>">
													<?php echo esc_html(get_the_title($pid)); ?>
												</a>
											</td>
											<td class="text-center" style="width:110px;">
												<?php
												$thumb_url = velocity_mobil4_thumbnail_url($pid);
												if ($thumb_url) : ?>
													<img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title($pid)); ?>" class="img-fluid rounded" style="max-height:80px;width:auto;" loading="lazy">
												<?php endif; ?>
											</td>
											<td class="text-center"><?php echo esc_html($stok ? $stok : '—'); ?></td>
											<td class="text-end fw-bold text-nowrap"><?php echo velocity_harga($pid); ?></td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>

					<?php else : ?>

						<div class="alert alert-light border-0 shadow-sm rounded-4 text-center mb-0">
							Belum ada produk yang diterbitkan.
						</div>

					<?php endif; ?>

					<?php wp_reset_postdata(); ?>

				</main>

			</div>

		</div>

	</div>

</div>

<?php
get_footer();
