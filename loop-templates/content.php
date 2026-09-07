<?php
/**
 * Kartu postingan untuk grid arsip/blog (Bootstrap 5)
 *
 * Child theme override (velocity-mobil4).
 *
 * @package velocity
 */

defined('ABSPATH') || exit;

$pid   = get_the_ID();
$cats  = ('post' === get_post_type()) ? get_the_category() : array();
$thumb = velocity_mobil4_archive_thumb($pid);
?>

<article <?php post_class('col'); ?> id="post-<?php the_ID(); ?>">

	<div class="bg-white rounded-4 shadow-sm overflow-hidden d-flex">

		<a class="ratio ratio-1x1 flex-shrink-0 overflow-hidden d-block" style="width:220px;" href="<?php echo esc_url(get_permalink()); ?>" aria-hidden="true" tabindex="-1">
			<?php
			if ($thumb) {
				echo $thumb;
			} else {
				echo '<span class="d-flex align-items-center justify-content-center text-primary opacity-50" style="font-size:2.5rem;" aria-hidden="true"><i class="bi bi-image"></i></span>';
			}
			?>
		</a>

		<div class="p-3 d-flex flex-column flex-grow-1 min-w-0">

			<?php if (!empty($cats)) : ?>
				<div class="mb-2">
					<a class="badge rounded-pill bg-primary bg-opacity-10 text-primary text-decoration-none fw-semibold" href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>"><?php echo esc_html($cats[0]->name); ?></a>
				</div>
			<?php endif; ?>

			<h2 class="fs-6 fw-bold mb-2 lh-base">
				<a class="text-decoration-none text-dark" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
			</h2>

			<?php if ('post' === get_post_type()) : ?>
				<div class="text-secondary small mb-2">
					<?php echo esc_html(get_the_date()); ?> &middot; <?php the_author(); ?>
				</div>
			<?php endif; ?>

			<div class="text-secondary small mb-3"><?php echo wp_trim_words(get_the_content(), 15, '...'); ?></div>

			<a class="btn btn-sm btn-primary text-white rounded-3 mt-auto align-self-start" href="<?php echo esc_url(get_permalink()); ?>">Baca Selengkapnya</a>

		</div>

	</div>

</article>