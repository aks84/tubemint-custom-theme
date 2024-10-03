
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header id="site-header" class="site-header">
    <div class="header-logo">
        <?php if ( has_custom_logo() ) {
            the_custom_logo();
        } else { ?>
            <h1><?php bloginfo( 'name' ); ?></h1>
        <?php } ?>
    </div>
    <nav class="site-navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
    </nav>
</header>

