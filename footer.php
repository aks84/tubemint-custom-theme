<?php wp_footer(); ?>

<footer class="site-footer">
    
<div class="footer-widgets">

<!-- Column 1st -->
<div class="footer-column">
    <h3>Reach Us</h3>
    <?php if (is_active_sidebar('footer_address')) : ?>
        <?php dynamic_sidebar('footer_address'); ?>
    <?php endif; ?>

                <?php if (is_active_sidebar('footer_contact')) : ?>
        <?php dynamic_sidebar('footer_contact'); ?>
    <?php endif; ?>
</div>

<!-- Solumn 2nd -->
<div class="footer-column">
<div class="footer-menu">
<h3>Popular Links</h3>
<?php
wp_nav_menu(array(
    'theme_location' => 'footer_menu',
    'container' => false,
    'menu_class' => 'footer-menu-list',
));
?>
</div>




</div>

<!-- Solumn 3rd -->

<div class="footer-column">
<div class="social-media-icons">
<h3>Be Social</h3>
<?php
$social_media = array('facebook', 'twitter', 'instagram', 'linkedin');
foreach ($social_media as $platform) {
$link = get_theme_mod('footer_' . $platform . '_link', '');
if ($link) {
    echo '<a href="' . esc_url($link) . '" target="_blank"><i class="fab fa-' . $platform . '"></i></a>';
}
}
?>
</div>

<div class="payment-icons">
    <?php
    for ($i = 1; $i <= 5; $i++) {
        $icon_url = get_theme_mod('footer_payment_icon_' . $i);
        if ($icon_url) {
            echo '<img src="' . esc_url($icon_url) . '" alt="Payment Icon" class="payment-icon" />';
        }
    }
    ?>
</div>

</div>
</div>

<script>
// header search box
const searchbar = document.querySelector('.Searchbar');
const toggle = searchbar.querySelector('.Searchbar-toggle');

toggle.addEventListener('click', event => {
  searchbar.classList.toggle('Searchbar--active');
});
</script>

<script>
    // sticky header
    jQuery(document).ready(function($) {
    var header = $('#site-header');
    var sticky = header.offset().top;

    $(window).scroll(function() {
        if (window.pageYOffset > sticky) {
            header.addClass('sticky');
        } else {
            header.removeClass('sticky');
        }
    });
});
</script>

</footer>
