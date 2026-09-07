<?php
/**
 * Partial template for content in page.php
 *
 * Child theme override (velocity-mobil4):
 * Sembunyikan judul halaman (entry-header / page title) di halaman depan (front page).
 *
 * @package velocity
 */

defined('ABSPATH') || exit;
?>

<article <?php post_class('page-article'); ?> id="post-<?php the_ID(); ?>">

	<?php if (!is_front_page()) : ?>
	<header class="page-hero bg-primary text-white rounded-4 shadow-sm p-3 p-md-4 mb-4">
		<?php do_action('justg_before_title'); ?>
		<h1 class="fs-3 fw-bold text-white mb-1"><?php the_title(); ?></h1>
		<?php do_action('justg_after_title'); ?>
	</header>
	<?php endif; ?>

	<?php
	if (has_post_thumbnail()) {
		echo '<figure class="page-article__media">';
		echo get_the_post_thumbnail($post->ID, 'large');
		echo '</figure>';
	}
	?>

	<div class="entry-content page-article__content">

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

	<footer class="entry-footer page-article__footer">

		<?php edit_post_link(__('Edit', 'velocity'), '<span class="edit-link">', '</span>'); ?>

	</footer>

</article>