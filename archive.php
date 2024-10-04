<?php get_header(); ?>

<br>        <!-- Filter Section -->
<section class="blog-filter">
    <form method="get" action="<?php echo esc_url(home_url('/')); ?>" id="filterForm">
        <select name="category" id="category">
            <option value="">Select Category</option>
            <?php
            $categories = get_categories();
            foreach ($categories as $category) {
                echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
            }
            ?>
        </select>

        <select name="monthyear" id="monthyear">
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

        <button type="submit" id="filterButton">Filter</button>
    </form>
</section>

<section class="post_cards" id="blogPosts">
    <!-- AJAX-loaded posts will appear here -->

</section>
  <br>


<script>
    document.getElementById('filterButton').addEventListener('click', function (e) {
        e.preventDefault();

        var category = document.getElementById('category').value;
        var monthyear = document.getElementById('monthyear').value;

        if (category && monthyear) {
            // If both are selected, perform an AJAX request to query posts
            var parts = monthyear.split('-');
            var year = parts[0];
            var month = parts[1];

            // Perform AJAX call
            fetch('<?php echo admin_url("admin-ajax.php"); ?>?action=filter_posts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    category: category,
                    year: year,
                    month: month,
                })
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('blogPosts').innerHTML = data;
            });
        } else if (category) {
            // If only category is selected, redirect to the category archive
            window.location.href = "<?php echo home_url('/category/'); ?>" + category;
        } else if (monthyear) {
            // If only month and year are selected, redirect to the date archive
            var parts = monthyear.split('-');
            var year = parts[0];
            var month = parts[1];
            window.location.href = "<?php echo home_url('/'); ?>" + year + '/' + month + '/';
        } else {
            // If no filter is selected, reload the page
            window.location.href = "<?php echo home_url('/blog/'); ?>";
        }
    });
</script>

<!-- archive page posts -->
<section class="post_cards">
<?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="post-card">
                <header class="entry-header">
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-meta">
                       <i><small> <span class="posted-on"><?php  //echo get_the_date(); ?></span></small></i>
                    </div>
                </header>
                <div class="entry-excerpt">
                    <?php // the_excerpt(); ?>
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail(); ?>
                    <?php endif ?>
                      <?php echo wp_trim_words(get_the_content(), 15); ?>
                    <a href="<?php the_permalink(); ?>"><span class="read_arrow">→</span></a>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e('No posts found.', 'textdomain'); ?></p>
    <?php endif; ?>
<!-- post_cards -->
</section>

<?php // get_sidebar(); ?>
<?php get_footer(); ?>
