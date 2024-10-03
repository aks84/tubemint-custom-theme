<?php get_header(); ?>

<div class="content-area">
    <main class="site-main">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="<?php echo esc_url(home_url('/')); ?>">
                <select name="category">
                    <option value="">Select Category</option>
                    <?php
                    $categories = get_categories();
                    foreach ($categories as $category) {
                        echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" value="Filter">
            </form>
        </div>

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="entry-meta">
                            <span class="posted-on"><?php echo get_the_date(); ?></span>
                        </div>
                    </header>
                    <div class="entry-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php esc_html_e('No posts found.', 'textdomain'); ?></p>
        <?php endif; ?>
    </main>
</div>

<?php // get_sidebar(); ?>
<?php get_footer(); ?>
