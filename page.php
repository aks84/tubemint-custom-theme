<?php get_header(); ?>

<div class="content-area">
<main class="site-main">
<?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <div class="page-body">
                <?php the_content(); // Display the content of the page ?>
            </div>
        <?php endwhile;
    else : ?>
        <p><?php _e('Sorry, no pages were found.', 'textdomain'); ?></p>
    <?php endif; ?>

</main>

<?php get_sidebar("primary"); ?>


</div>


<?php get_footer(); ?>
