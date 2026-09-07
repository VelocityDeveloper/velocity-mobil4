<?php
/**
 * Pesan tidak ada konten (Bootstrap 5)
 *
 * Child theme override (velocity-mobil4).
 *
 * @package velocity
 */

defined('ABSPATH') || exit;
?>

<section class="no-results not-found">

	<div class="alert alert-light border-0 shadow-sm rounded-4 text-center mb-0">

		<h1 class="fs-4 fw-bold mb-3"><?php esc_html_e('Nothing Found', 'velocity'); ?></h1>

		<div class="text-secondary mb-3">
			<?php
			if (is_home() && current_user_can('publish_posts')) :

				$kses = array('a' => array('href' => array()));
				printf(
					'<p class="mb-0">' . wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'velocity'), $kses) . '</p>',
					esc_url(admin_url('post-new.php'))
				);

			elseif (is_search()) :

				printf(
					'<p class="mb-0">%s</p>',
					esc_html__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'velocity')
				);

			else :

				printf(
					'<p class="mb-0">%s</p>',
					esc_html__('It seems we can’t find what you’re looking for. Perhaps searching can help.', 'velocity')
				);

			endif;
			?>
		</div>

		<div class="row justify-content-center">
			<div class="col-12 col-md-8 col-lg-6">
				<?php get_search_form(); ?>
			</div>
		</div>

	</div>

</section>