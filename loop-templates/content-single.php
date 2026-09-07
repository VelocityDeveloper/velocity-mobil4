<?php
/**
 * Single post partial template
 *
 * Child theme override (velocity-mobil4):
 * Judul single post memakai hero biru seragam (page, arsip, produk).
 *
 * @package velocity
 */

defined('ABSPATH') || exit;

$cats = ('post' === get_post_type()) ? get_the_category() : array();
?>

<article <?php post_class('single-article'); ?> id="post-<?php the_ID(); ?>">

	<header class="page-hero bg-primary text-white rounded-4 shadow-sm p-3 p-md-4 mb-4">

		<?php do_action('justg_before_title'); ?>

		<?php if (!empty($cats)) : ?>
			<div class="d-flex flex-wrap align-items-center gap-2 mb-2">
				<a class="badge rounded-pill bg-white text-primary text-decoration-none fw-semibold" href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>"><?php echo esc_html($cats[0]->name); ?></a>
			</div>
		<?php endif; ?>

		<h1 class="fs-3 fw-bold text-white mb-1"><?php the_title(); ?></h1>

		<div class="d-flex flex-wrap align-items-center gap-2">
			<span class="badge rounded-pill bg-white bg-opacity-25 fw-normal"><?php echo esc_html(get_the_date()); ?></span>
			<span class="badge rounded-pill bg-white bg-opacity-25 fw-normal"><?php the_author(); ?></span>
		</div>

		<?php do_action('justg_after_title'); ?>

	</header>

	<?php
	if (has_post_thumbnail()) {
		echo '<figure class="single-article__media">';
		echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'w-100 h-auto'));
		if (get_the_post_thumbnail_caption()) {
			echo '<figcaption class="single-article__caption">' . esc_html(get_the_post_thumbnail_caption()) . '</figcaption>';
		}
		echo '</figure>';
	}
	?>

	<div class="entry-content single-article__content">

		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __('Pages:', 'velocity'),
				'after'  => '</div>',
			)
		);
		?>

	</div>

	<footer class="entry-footer single-article__footer">

		<?php justg_entry_footer(); ?>

	</footer>

</article>