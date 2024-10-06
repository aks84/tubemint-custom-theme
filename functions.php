<?php

require get_template_directory() . '/class-mega-menu-walker.php';
require get_template_directory() . '/wp-customizer.php';

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


function load_custom_wp_admin_style() {
    wp_enqueue_media();
    wp_enqueue_script('custom-admin-js', get_template_directory_uri() . '/js/admin.js', array('jquery'), '', true);
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');




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
        'primary_menu' => __('Primary Menu', 'custom-theme'),
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




function custom_theme_slider_customizer($wp_customize) {
    // Add a section for the slider
    $wp_customize->add_section('slider_section', array(
        'title'       => __('Hero Slider', 'custom-theme'),
        'priority'    => 30,
        'description' => 'Customize the hero slider.',
    ));

    // Add settings and controls for each slider
    for ($i = 1; $i <= 3; $i++) {
        // Image
        $wp_customize->add_setting("slider_image_$i", array(
            'default'   => '',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            "slider_image_$i",
            array(
                'label'    => __("Slider Image $i", 'custom-theme'),
                'section'  => 'slider_section',
                'settings' => "slider_image_$i",
            )
        ));

        // Text
        $wp_customize->add_setting("slider_text_$i", array(
            'default'           => __("Slider Text $i", 'custom-theme'),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("slider_text_$i", array(
            'label'    => __("Slider Text $i", 'custom-theme'),
            'section'  => 'slider_section',
            'settings' => "slider_text_$i",
            'type'     => 'text',
        ));

        // Button Text
        $wp_customize->add_setting("slider_button_text_$i", array(
            'default'           => __("Learn More", 'custom-theme'),
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control("slider_button_text_$i", array(
            'label'    => __("Button Text $i", 'custom-theme'),
            'section'  => 'slider_section',
            'settings' => "slider_button_text_$i",
            'type'     => 'text',
        ));

        // Button Link
        $wp_customize->add_setting("slider_button_link_$i", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("slider_button_link_$i", array(
            'label'    => __("Button Link $i", 'custom-theme'),
            'section'  => 'slider_section',
            'settings' => "slider_button_link_$i",
            'type'     => 'url',
        ));
    }
}
add_action('customize_register', 'custom_theme_slider_customizer');


function custom_nav_menu_meta_box($item_id, $item, $depth, $args) {
    // Check if the item is marked as a mega menu
    $is_mega_menu = get_post_meta($item_id, '_menu_item_is_mega_menu', true);
    $is_drop_menu = get_post_meta($item_id, '_menu_item_is_drop_menu', true);

    // Output the checkbox for the mega menu option
    ?>
    <p class="field-mega-menu description description-wide">
        <label for="edit-menu-item-mega-menu-<?php echo esc_attr($item_id); ?>">
            <input type="checkbox" id="edit-menu-item-mega-menu-<?php echo esc_attr($item_id); ?>" value="yes" name="menu-item-mega-menu[<?php echo esc_attr($item_id); ?>]" <?php checked($is_mega_menu, 'yes'); ?> />
            <?php esc_html_e('Is it mega menu?'); ?>
        </label>
    </p>
    <p class="field-dropdown-menu description description-wide">
        <label for="edit-menu-item-dropdown-menu-<?php echo esc_attr($item_id); ?>">
            <input type="checkbox" id="edit-menu-item-dropdown-menu-<?php echo esc_attr($item_id); ?>" value="yes" name="menu-item-dropdown-menu[<?php echo esc_attr($item_id); ?>]" <?php checked($is_drop_menu, 'yes'); ?> />
            <?php esc_html_e('Is is drop-down menu?'); ?>
        </label>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'custom_nav_menu_meta_box', 10, 4);


function save_custom_nav_menu_meta_box($menu_id, $menu_item_db_id, $args) {
    // Check if the mega menu option was set for this menu item
    if (isset($_POST['menu-item-mega-menu'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_is_mega_menu', 'yes');
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_is_mega_menu');
    }

    if (isset($_POST['menu-item-drop-menu'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_is_drop_menu', 'yes');
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_is_drop_menu');
    }
}
add_action('wp_update_nav_menu_item', 'save_custom_nav_menu_meta_box', 10, 3);

