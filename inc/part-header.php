<?php
defined('ABSPATH') || exit;
?>

<div class="site-branding-row d-flex align-items-center justify-content-between gap-4 py-3">
    <div class="site-branding-logo flex-shrink-0">
        <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
        <?php endif; ?>
    </div>
    <div class="site-branding-copy text-end ms-auto border-end border-3 border-primary pe-3">
        <?php if (is_front_page() && is_home()) : ?>
            <h1 class="site-title h3 fw-bold mb-1"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
        <?php else : ?>
            <p class="site-title h3 fw-bold mb-1"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
        <?php endif; ?>
        <?php $description = get_bloginfo('description', 'display'); ?>
        <?php if ($description || is_customize_preview()) : ?>
            <p class="site-description mb-0"><?php echo esc_html($description); ?></p>
        <?php endif; ?>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark mobil4-main-nav" aria-labelledby="main-navigation-label">
    <div class="container">
        <h2 id="main-navigation-label" class="visually-hidden"><?php esc_html_e('Main Navigation', 'justg'); ?></h2>

        <span class="mobil4-menu-label d-lg-none fw-semibold"><?php esc_html_e('Menu Utama', 'justg'); ?></span>
        <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobil4MenuOffcanvas" aria-controls="mobil4MenuOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
            <span class="velocity-menu-toggle-icon" aria-hidden="true"></span>
        </button>

        <div class="offcanvas-lg offcanvas-start mobil4-menu-panel" tabindex="-1" id="mobil4MenuOffcanvas" aria-labelledby="mobil4MenuOffcanvasLabel">
            <div class="offcanvas-header d-lg-none">
                <div>
                    <div class="offcanvas-title fw-bold" id="mobil4MenuOffcanvasLabel"><?php bloginfo('name'); ?></div>
                    <small class="text-white-50"><?php esc_html_e('Menu Utama', 'justg'); ?></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#mobil4MenuOffcanvas" aria-label="<?php esc_attr_e('Close', 'justg'); ?>"></button>
            </div>
            <?php
            $menu_args = array(
                'theme_location'  => 'primary',
                'container_class' => 'offcanvas-body mobil4-menu-body',
                'container_id'    => '',
                'menu_class'      => 'navbar-nav flex-lg-row flex-wrap align-items-lg-center',
                'fallback_cb'     => false,
                'menu_id'         => 'main-menu',
                'depth'           => 4,
            );
            if (class_exists('justg_WP_Bootstrap_Navwalker')) {
                $menu_args['walker'] = new justg_WP_Bootstrap_Navwalker();
            }
            wp_nav_menu($menu_args);
            ?>
        </div>
    </div>
</nav>

<?php if (has_header_image()) : ?>
    <div class="site-header-media mt-3 mb-1">
        <a class="d-block" href="<?php echo esc_url(home_url('/')); ?>">
            <img class="w-100 h-auto" src="<?php echo esc_url(get_header_image()); ?>" width="<?php echo esc_attr(get_custom_header()->width); ?>" height="<?php echo esc_attr(get_custom_header()->height); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
        </a>
    </div>
<?php endif; ?>
