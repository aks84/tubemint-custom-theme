<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">

    <link rel="profile" href="https://gmpg.org/xfn/11">
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

<!-- Header Mega Menu -->
<nav class="main-navigation">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary_menu', 
        'menu_class' => 'nav-menu',
        'container' => false,
        'walker' => new Mega_Menu_Walker() // Custom walker to control menu structure
    ));
    ?>
</nav>


<!-- Header Search Toggle Bar -->
<div class="header-search">
<form role="search" method="get" class="Searchbar" action="<?php echo esc_url(home_url('/')); ?>">
  <input class="Searchbar-input" type="text" placeholder="Search" value="<?php echo get_search_query(); ?>" name="s" autofocus />
  <span class="Searchbar-toggle">
    <i class="fas fa-search Icon Icon-search"></i>
    <i class="fas fa-times Icon Icon-close"></i>
  </span>
   </form>
</div>
</header>

