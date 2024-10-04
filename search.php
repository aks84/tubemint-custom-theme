
<?php get_header(); ?>

  <h3 style="text-align: center;">
        <?php 
        // Display search query
        printf(__('Search Results for: %s', 'textdomain'), get_search_query()); 
        ?>
    </h3>

<section class="post_cards">

  

    <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="post-card">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                   <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail(); ?>
                  <?php endif; ?>
                    <?php echo wp_trim_words(get_the_content(), 20); ?>
                    <a href="<?php the_permalink(); ?>"><span class="read_arrow">→</span></a>
                </div>
            <?php endwhile; ?>


    <?php else : ?>
        <p><?php _e('Sorry, no results found.', 'textdomain'); ?></p>
    <?php endif; ?>
</section>

        <!-- Post navigation -->
        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>

<?php get_footer(); ?>
