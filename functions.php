<?php
// Theme setup
function custom_classic_theme_setup() {
    // Add support for dynamic title tags
    add_theme_support('title-tag');

    // Add custom logo support
    add_theme_support('custom-logo');

    // Add support for featured images
    add_theme_support('post-thumbnails');

    // Register menu
    register_nav_menus(array(
        'header-menu' => __('Header Menu', 'custom-classic-theme')
    ));
}
add_action('after_setup_theme', 'custom_classic_theme_setup');

// Enqueue scripts and styles
function custom_classic_theme_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'custom_classic_theme_scripts');

function custom_theme_enqueue_scripts() {
    wp_enqueue_script('jquery');
    // Add custom JS for the slider
    wp_enqueue_script('slider-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_scripts');

function filter_posts_by_category_and_month() {
    if (isset($_GET['category']) || isset($_GET['month'])) {
        $category = sanitize_text_field($_GET['category']);
        $month = sanitize_text_field($_GET['month']);

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'category__in' => $category ? array($category) : '',
            'date_query' => $month ? array(
                array(
                    'year' => date('Y', strtotime($month)),
                    'month' => date('n', strtotime($month))
                )
            ) : '',
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                get_template_part('template-parts/content', get_post_type());
            }
            wp_reset_postdata();
        } else {
            echo '<p>' . __('No posts found.', 'textdomain') . '</p>';
        }
    }
}

add_action('pre_get_posts', 'filter_posts_by_category_and_month');




add_action( 'widgets_init', 'tubemint_register_sidebars' );
function tubemint_register_sidebars() {
    register_sidebar(
        array(
            'id'            => 'primary',
            'name'          => __( 'Primary Sidebar' ),
            'description'   => __( 'A short description of the sidebar.' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}