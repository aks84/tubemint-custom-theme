<article <?php post_class(); ?>>
    <h2><?php the_title(); ?></h2>
    <div class="post-thumbnail">
        <?php the_post_thumbnail(); ?>
    </div>
    <div class="post-content">
        <?php the_excerpt(); ?>
    </div>
    <a href="<?php the_permalink(); ?>">Read More</a>
</article>
