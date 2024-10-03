
<?php get_header(); ?>

<section class="blog-filter">
    <form method="get">
        <select name="category">
            <option value="">Select Category</option>
            <?php
            $categories = get_categories();
            foreach ($categories as $category) {
                echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
            }
            ?>
        </select>
        <select name="monthyear">
            <option value="">Select Month/Year</option>
            <?php
            global $wpdb;
            $results = $wpdb->get_results("SELECT DISTINCT YEAR(post_date) as year, MONTH(post_date) as month FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date DESC");
            foreach ($results as $result) {
                $monthyear = date("F Y", strtotime($result->year . '-' . $result->month . '-01'));
                echo '<option value="' . esc_attr($result->year . '-' . $result->month) . '">' . esc_html($monthyear) . '</option>';
            }
            ?>
        </select>
        <button type="submit">Filter</button>
    </form>
</section>



<section class="post_cards">
<?php
// Add this before the loop to ensure you're querying the right posts
$args = array(
    'post_type' => 'post', // Ensure you're querying for posts
    'posts_per_page' => 10, // Adjust the number of posts you want
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1 // Pagination support
);

$blog_query = new WP_Query($args);

if ($blog_query->have_posts()) :
    while ($blog_query->have_posts()) : $blog_query->the_post();
?>
<div class="post-card">
    <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail(); ?>
    <?php endif; ?>
    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
    <a href="<?php the_permalink(); ?>"><span class="read_arrow">→</span></a>
</div>
<?php
    endwhile;
    wp_reset_postdata(); // Important: Reset post data after custom query
else :
    echo '<p>No posts found.</p>';
endif;
?>
</section>


<?php get_footer(); ?>
