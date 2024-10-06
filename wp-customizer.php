<?php 
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




function mega_menu_customizer($wp_customize) {
    // Mega Menu Section
    $wp_customize->add_section('mega_menu_section', array(
        'title' => __('Mega Menu', 'custom-theme'),
        'priority' => 35,
    ));

    // Add columns
    for ($i = 1; $i <= 3; $i++) {
        // Column title setting
        $wp_customize->add_setting("mega_menu_column_{$i}_title", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("mega_menu_column_{$i}_title", array(
            'label' => __("Column {$i} Title", 'custom-theme'),
            'section' => 'mega_menu_section',
            'type' => 'text',
        ));

        // Column menu selection using dropdown for available menus
        $wp_customize->add_setting("mega_menu_column_{$i}_menu", array(
            'default' => '',
            'sanitize_callback' => 'absint', // Store the menu ID
        ));
        
        // Dropdown to select a WordPress menu
        $wp_customize->add_control(new WP_Customize_Nav_Menu_Control(
            $wp_customize,
            "mega_menu_column_{$i}_menu", 
            array(
                'label' => __("Select Menu for Column {$i}", 'custom-theme'),
                'section' => 'mega_menu_section',
                'type' => 'select',
                'priority' => 10
            )
        ));

         // Loop through each column
    for ($i = 1; $i <= 3; $i++) {
        // Add settings for column titles
        $wp_customize->add_setting("mega_menu_column_{$i}_title", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        // Add control for column titles
        $wp_customize->add_control("mega_menu_column_{$i}_title", array(
            'label' => __("Column {$i} Title", 'custom-theme'),
            'section' => 'mega_menu_section',
            'type' => 'text',
        ));

        // Get all available menus
        $menus = wp_get_nav_menus();
        $menu_choices = array();
        foreach ($menus as $menu) {
            $menu_choices[$menu->term_id] = $menu->name;
        }

        // Add settings for column menus
        $wp_customize->add_setting("mega_menu_column_{$i}_menu", array(
            'default' => '',
            'sanitize_callback' => 'absint',  // Sanitize as integer
        ));

        // Add control for column menus (dropdown)
        $wp_customize->add_control("mega_menu_column_{$i}_menu", array(
            'label' => __("Select Menu for Column {$i}", 'custom-theme'),
            'section' => 'mega_menu_section',
            'type' => 'select',
            'choices' => $menu_choices,  // List available menus in the dropdown
        ));
    }}

   // MEGA MENU

    
}
add_action('customize_register', 'mega_menu_customizer');
