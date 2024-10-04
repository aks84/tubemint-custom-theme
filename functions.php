<?php

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

function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');



// Theme setup
function tubemint_custom_theme_setup() {
    // Add support for dynamic title tags
    add_theme_support('title-tag');
    add_theme_support('widgets');
    add_theme_support( 'html5', array(
        'comment-list', 
        'comment-form',
        'search-form',
        'gallery',
        'caption',
    ) );
    add_theme_support('link-color');
    add_theme_support('menus');
    add_theme_support('responsive-embeds');
    add_theme_support(
            'post-formats',
            array(
                'aside',
                'image',
                'video',
                'quote',
                'link',
                'gallery',
                'audio',
            )
        );

    // Add custom logo support
    add_theme_support('custom-logo');

    // Add support for featured images
    add_theme_support('post-thumbnails');

    // Register menu
    register_nav_menus(array(
        'header-menu' => __('Header Menu', 'custom-theme')
    ));

    register_nav_menus(array(
        'footer_menu' => __('Footer Menu', 'custom-theme'),
    ));
}
add_action('after_setup_theme', 'tubemint_custom_theme_setup');





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



// Theme customizer 

function tubemint_custom_theme_customizer($wp_customize) {
    // Social Media Section
    $wp_customize->add_section('footer_social_section', array(
        'title' => __('Footer Social Media', 'custom-theme'),
        'priority' => 30,
    ));

    $social_media = array('Facebook', 'Twitter', 'Instagram', 'LinkedIn');
    foreach ($social_media as $platform) {
        $wp_customize->add_setting('footer_' . strtolower($platform) . '_link', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('footer_' . strtolower($platform) . '_link', array(
            'label' => __($platform . ' URL', 'custom-theme'),
            'section' => 'footer_social_section',
            'type' => 'url',
        ));
    }

    // Payment Icons Section
    $wp_customize->add_section('footer_payment_section', array(
        'title' => __('Footer Payment Icons', 'custom-theme'),
        'priority' => 31,
    ));

    // Add a repeatable image field for payment gateway icons
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting('footer_payment_icon_' . $i, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            'footer_payment_icon_' . $i,
            array(
                'label' => __('Payment Gateway Icon ' . $i, 'custom-theme'),
                'section' => 'footer_payment_section',
                'settings' => 'footer_payment_icon_' . $i,
            )
        ));
    }
}
add_action('customize_register', 'tubemint_custom_theme_customizer');





// Register Footer Widgets
function tubemint_custom_theme_widgets() {
    register_sidebar(array(
        'name' => 'Footer Address',
        'id' => 'footer_address',
        'before_widget' => '<div class="footer-address">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer Contact Info',
        'id' => 'footer_contact',
        'before_widget' => '<div class="footer-contact">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(
    array(
        'id'            => 'secondary',
        'name'          => __( 'Secondary Sidebar' ),
        'description'   => __( 'A short description of the sidebar.' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(
        array(
            'id'            => 'primary',
            'name'          => __( 'Primary Sidebar' ),
            'description'   => __( 'A short description of the sidebar.' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
    ));

}
add_action('widgets_init', 'tubemint_custom_theme_widgets');
