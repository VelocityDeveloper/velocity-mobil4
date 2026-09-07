<?php
/**
 * Template arsip CPT "produk" dan taksonomi "kategori-produk".
 *
 * Tampilan memakai utility Bootstrap 5 (badge, grid, ratio) dengan sedikit
 * sentuhan custom pada blok "Arsip & katalog produk" di css/custom.css.
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = velocity_mobil4_option('justg_container_type', 'container');
$total     = (int) $GLOBALS['wp_query']->found_posts;

// Label kecil dan judul header arsip.
if (is_tax('kategori-produk')) {
	$queried = get_queried_object();
	$tax_obj = get_taxonomy('kategori-produk');
	$eyebrow = ($tax_obj && isset($tax_obj->labels->singular_name)) ? $tax_obj->labels->singular_name : 'Kategori Produk';
	$title   = ($queried && isset($queried->name)) ? $queried->name : single_term_title('', false);
} else {
	$eyebrow = 'Katalog';
	$title   = post_type_archive_title('', false);
}
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php do_action('justg_before_content'); ?>

			<main class="site-main col order-2" id="main">

				<!-- Header arsip -->
				<header class="produk-hero bg-primary text-white rounded-4 shadow-sm p-3 p-md-4 mb-4">
					<?php do_action('justg_before_title'); ?>
					<div class="d-flex flex-wrap align-items-center gap-2 mb-2">
						<span class="badge rounded-pill bg-white text-primary fw-semibold"><?php echo esc_html($eyebrow); ?></span>
						<span class="badge rounded-pill bg-white bg-opacity-25 fw-normal"><?php echo esc_html(number_format_i18n($total)); ?> produk</span>
					</div>
					<h1 class="fs-3 fw-bold text-white mb-1"><?php echo esc_html($title); ?></h1>
					<?php the_archive_description('<div class="taxonomy-description text-white opacity-75">', '</div>'); ?>
					<?php do_action('justg_after_title'); ?>
				</header>

				<?php if ( have_posts() ) { ?>

					<!-- Grid produk -->
					<div class="velocity-produk row g-3 row-cols-2 row-cols-md-3">
						<?php
						while ( have_posts() ) {
							the_post();
							$pid = get_the_ID();
							?>
							<div class="col">
								<div class="produk-item bg-white rounded-4 shadow-sm overflow-hidden h-100 d-flex flex-column">
									<?php echo velocity_mobil4_thumbnail($pid, 'ratio-4x3'); ?>
									<div class="p-2 p-md-3 text-center d-flex flex-column flex-grow-1">
										<h4 class="fs-6 fw-bold mb-2 lh-base">
											<a class="text-decoration-none text-dark" href="<?php echo esc_url(get_permalink($pid)); ?>"><?php echo esc_html(get_the_title($pid)); ?></a>
										</h4>
										<div class="produk-price fw-bold mb-3"><?php echo velocity_harga($pid); ?></div>
										<a class="btn btn-sm btn-primary rounded-3 mt-auto" href="<?php echo esc_url(get_permalink($pid)); ?>">Detail</a>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>

				<?php } else { ?>

					<!-- State kosong -->
					<div class="alert alert-light border-0 shadow-sm rounded-4 text-center mb-0">
						Belum ada produk yang diterbitkan. Silakan pilih kategori lainnya.
					</div>

				<?php } ?>

				<!-- Display the pagination component. -->
				<?php if (function_exists('justg_pagination')) { ?>
					<div class="mt-4"><?php justg_pagination(); ?></div>
				<?php } else {
					the_posts_pagination();
				} ?>
			</main><!-- #main -->

			<!-- Do the right sidebar check. -->
			<?php do_action('justg_after_content'); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();