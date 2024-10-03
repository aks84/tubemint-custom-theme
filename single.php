<?php get_header(); ?>

<div class="content-area">
    <main class="site-main">
        <?php
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <i><small>
                        <span class="posted-on"> Publish: <?php echo get_the_date(); ?></span>,
                        <span class="cat-links"> Under: <?php the_category(', '); ?></span></small>
                        </i>
                    </div>
                </header>
                <div class="entry-content">
                    <?php the_post_thumbnail(); ?>
                    <?php the_content(); ?>
                </div>
                <footer class="entry-footer">
                    <i><small><span class="tags-links"><?php the_tags('Tags: ', ', '); ?></span></small></i>
                </footer>
            </article>
        <?php endwhile; ?>

       <div class="post-navigation">
        <br>
        
        <div class="nav-previous">
           <h3> <?php previous_post_link('%link', '<span class="meta-nav">&laquo;</span> %title'); ?></h3>
        </div>
        <div class="nav-next">
            <h3><?php next_post_link('%link', '%title <span class="meta-nav">&raquo;</span>'); ?></h3>
        </div>
        
        <br>
    </div>  
    <!-- post nav -->

    <div class="related-posts">
    <h3 style="text-decoration: underline;">Related Posts</h3>
    <ul id="related_posts">
        <?php
        // Get the current post's categories
        $categories = get_the_category();
        if ($categories) {
            // Get the IDs of the categories
            $category_ids = array();
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }

            // Query related posts
            $related_posts_args = array(
                'category__in' => $category_ids, // Posts from the same category
                'post__not_in' => array(get_the_ID()), // Exclude the current post
                'posts_per_page' => 3, // Limit to 3 posts
                'orderby' => 'rand' // Randomize the posts
            );

            $related_posts_query = new WP_Query($related_posts_args);

            // Loop through related posts
            if ($related_posts_query->have_posts()) {
                while ($related_posts_query->have_posts()) {
                    $related_posts_query->the_post(); ?>
                   <bold> <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li></bold>
                <?php }
                wp_reset_postdata(); // Reset the post data
            } else {
                echo '<li>No related posts found.</li>';
            }
        } else {
            echo '<li>No categories found.</li>';
        }
        ?>
    </ul>
</div>
<!-- related posts -->



    </main>

    <?php get_sidebar("primary"); ?>





</div>


<?php get_footer(); ?>
