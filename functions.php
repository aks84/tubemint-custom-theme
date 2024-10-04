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


// post filter
function filter_posts() {
    $category_slug = sanitize_text_field($_POST['category']);
    $year = intval($_POST['year']);
    $month = intval($_POST['month']);

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'category_name' => $category_slug, // Use category slug for filtering
        'date_query' => array(
            array(
                'year' => $year,
                'month' => $month,
            )
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) { 
     while ($query->have_posts()) : $query->the_post(); ?>
            <div class="post-card">

                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail(); ?>
                <?php endif; ?>
            </div>
            <br>
        <?php endwhile; 

    } else {
        echo '<p>No posts found for the selected category and date.</p>';
    }

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');



// register primary sidebar
add_action( 'widgets_init', 'tubemint_register_sidebar_first' );
function tubemint_register_sidebar_first() {
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




// register secondry sidebar
add_action( 'widgets_init', 'tubemint_register_sidebar_second' );
function tubemint_register_sidebar_second() {
    register_sidebar(
        array(
            'id'            => 'secondary',
            'name'          => __( 'Secondary Sidebar' ),
            'description'   => __( 'A short description of the sidebar.' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}