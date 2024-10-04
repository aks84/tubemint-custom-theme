<div id="primary_sidebar" class="sidebar">

	<?php do_action( 'before_sidebar' ); ?>

	<?php if ( ! dynamic_sidebar( 'sidebar-primary' ) ) : ?>


		<aside id="category_list" class="widget">
			<h3 class="widget-title"><?php _e( 'Categories', 'shape' ); ?></h3>
			<ul>
			
				<?php wp_list_cats(); ?>
			</ul>

		</aside><!-- #categories -->


		<aside id="archives" class="widget">
			<h3 class="widget-title"><?php _e( 'Archives', 'shape' ); ?></h3>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside><!-- #archives -->

	<?php endif; ?>

</div><!-- #primary -->