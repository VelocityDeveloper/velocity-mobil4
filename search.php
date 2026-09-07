<?php
/**
 * The template for displaying search results pages
 *
 * Child theme override (velocity-mobil4):
 * Hero biru seragam + grid kartu Bootstrap untuk hasil pencarian.
 *
 * @package velocity
 */

defined('ABSPATH') || exit;

get_header();

$container = velocitytheme_option('justg_container_type', 'container');
$total     = (int) $GLOBALS['wp_query']->found_posts;
?>

<div class="wrapper" id="search-wrapper">

	<div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php do_action('justg_before_content'); ?>

			<main class="site-main archive-main" id="main">

				<!-- Header pencarian -->
				<header class="page-hero bg-primary text-white rounded-4 shadow-sm p-3 p-md-4 mb-4">
					<div class="d-flex flex-wrap align-items-center gap-2 mb-2">
						<span class="badge rounded-pill bg-white text-primary fw-semibold">Pencarian</span>
						<span class="badge rounded-pill bg-white bg-opacity-25 fw-normal"><?php echo esc_html(number_format_i18n($total)); ?> hasil</span>
					</div>
					<h1 class="fs-3 fw-bold text-white mb-1"><?php echo esc_html(get_search_query()); ?></h1>
				</header>

				<?php if (have_posts()) { ?>

					<!-- Grid hasil pencarian -->
					<div class="list-post row g-3 row-cols-1 mb-4">
						<?php
						while (have_posts()) {
							the_post();
							get_template_part('loop-templates/content', 'search');
						}
						?>
					</div>

					<?php justg_pagination(); ?>

				<?php } else {
					get_template_part('loop-templates/content', 'none');
				} ?>

			</main>

			<?php do_action('justg_after_content'); ?>

		</div>

	</div>

</div>

<?php
get_footer();