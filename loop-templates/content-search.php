<?php
/**
 * Kartu hasil pencarian (Bootstrap 5)
 *
 * Child theme override (velocity-mobil4).
 *
 * @package velocity
 */

defined('ABSPATH') || exit;

$pid   = get_the_ID();
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

			<?php if ('post' === get_post_type()) : ?>
				<div class="mb-2">
					<span class="badge rounded-pill bg-white bg-opacity-25 fw-normal"><?php echo esc_html(get_the_date()); ?></span>
				</div>
			<?php endif; ?>

			<h2 class="fs-6 fw-bold mb-2 lh-base">
				<a class="text-decoration-none text-dark" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
			</h2>

			<div class="text-secondary small mb-3"><?php the_excerpt(); ?></div>

			<a class="btn btn-sm btn-primary rounded-3 mt-auto align-self-start" href="<?php echo esc_url(get_permalink()); ?>">Lihat Detail</a>

		</div>

	</div>

</article>