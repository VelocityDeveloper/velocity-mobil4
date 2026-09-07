<?php
/**
 * The template for displaying archive pages
 *
 * Child theme override (velocity-mobil4):
 * Hero biru seragam + grid kartu Bootstrap untuk arsip
 * (kategori, tag, tanggal, penulis, dan CPT tanpa template khusus).
 *
 * @package velocity
 */

defined('ABSPATH') || exit;

get_header();

$container = velocitytheme_option('justg_container_type', 'container');
$total     = (int) $GLOBALS['wp_query']->found_posts;

if (is_category()) {
	$eyebrow = 'Kategori';
	$title   = single_term_title('', false);
} elseif (is_tag()) {
	$eyebrow = 'Tag';
	$title   = single_term_title('', false);
} elseif (is_date()) {
	$eyebrow = 'Arsip';
	$title   = is_month() ? single_month_title(' ', false) : get_the_date();
} elseif (is_author()) {
	$eyebrow = 'Penulis';
	$user    = get_queried_object();
	$title   = ($user && isset($user->display_name)) ? $user->display_name : '';
} else {
	$eyebrow = 'Arsip';
	$title   = get_the_archive_title();
}
?>

<div class="wrapper archive-shell" id="archive-wrapper">

	<div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php do_action('justg_before_content'); ?>

			<main class="site-main archive-main" id="main">

				<!-- Header arsip -->
				<header class="page-hero bg-primary text-white rounded-4 shadow-sm p-3 p-md-4 mb-4">
					<?php do_action('justg_before_title'); ?>
					<div class="d-flex flex-wrap align-items-center gap-2 mb-2">
						<span class="badge rounded-pill bg-white text-primary fw-semibold"><?php echo esc_html($eyebrow); ?></span>
						<span class="badge rounded-pill bg-white bg-opacity-25 fw-normal"><?php echo esc_html(number_format_i18n($total)); ?> postingan</span>
					</div>
					<h1 class="fs-3 fw-bold text-white mb-1"><?php echo esc_html($title); ?></h1>
					<?php the_archive_description('<div class="taxonomy-description text-white opacity-75">', '</div>'); ?>
					<?php do_action('justg_after_title'); ?>
				</header>

				<?php if (have_posts()) { ?>

					<!-- Grid postingan -->
					<div class="list-post row g-3 row-cols-1 mb-4">
						<?php
						while (have_posts()) {
							the_post();
							get_template_part('loop-templates/content', get_post_format());
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