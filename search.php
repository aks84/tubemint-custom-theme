
<?php get_header(); ?>

<div class="container">
    <h1>
        <?php 
        // Display search query
        printf(__('Search Results for: %s', 'textdomain'), get_search_query()); 
        ?>
    </h1>

    <?php if (have_posts()) : ?>
        <div class="search-results">
            <?php while (have_posts()) : the_post(); ?>
                <div class="search-result-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php the_excerpt(); ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Post navigation -->
        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <p><?php _e('Sorry, no results found.', 'textdomain'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
