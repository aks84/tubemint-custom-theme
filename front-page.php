
<?php get_header(); ?>

<section class="hero-slider">
    <?php
    for ($i = 1; $i <= 3; $i++) {
        $image = get_template_directory_uri() . "/assets/slider_image_$i.jpg";
        $text = "slider_text_$i";
        $button_text = "slider_button_text_$i";
        $button_link = "#";
        if ($image) :
    ?>
    <div class="slider-item">
        <img src="<?php echo esc_url($image); ?>" alt="Slide <?php echo $i; ?>">
        <div class="slider-overlay">
            <h2><?php echo esc_html($text); ?></h2>
            <a href="<?php echo esc_url($button_link); ?>" class="button"><?php echo esc_html($button_text); ?></a>
        </div>
    </div>
    <?php endif; } ?>

    <!-- Add pagination dots -->
<div class="slider-dots">
    <span class="dot" data-slide="0"></span>
    <span class="dot" data-slide="1"></span>
    <span class="dot" data-slide="2"></span>
</div>
</section>

<section class="services">
    <h2>Our Services</h2>
    <div class="service-cards">
        <div class="service-card">
            <h3>Service 1</h3>
            <a href="#">Learn More</a>
        </div>
        <div class="service-card">
            <h3>Service 2</h3>
            <a href="#">Learn More</a>
        </div>
    </div>
</section>

<section class="blog-posts">
    <h2>Latest Blog Posts</h2>
    <div class="post-cards">
        <?php
        $recent_posts = new WP_Query(array('posts_per_page' => 3));
        while ($recent_posts->have_posts()) : $recent_posts->the_post();
        ?>
        <div class="post-card">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail(); ?>
    <?php endif; ?>
            
            <h3><?php the_title(); ?></h3>
            <a href="<?php the_permalink(); ?>">Read More</a>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</section>

<?php get_footer(); ?>
