<aside class="sidebar">
	<?php
	if (!dynamic_sidebar('sidebar-widget-area') ) : ?>
	<section class="widget">
		<h3><span><?php _e( 'Pages', 'carrotlite' ); ?></span></h3>
		<ul>
	        <?php wp_list_pages('title_li='); ?>
		</ul>
	</section>
	<section class="widget">
		<h3><span><?php _e( 'Categories', 'carrotlite' ); ?></span></h3>
		<ul>
	        <?php wp_list_categories('title_li='); ?>
		</ul>
	</section>
	<section class="widget">
		<h3><span><?php _e( 'Archives', 'carrotlite' ); ?></span></h3>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</section>
	<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
	<section class="widget">
		<h3><span><?php _e( 'Meta', 'carrotlite' ); ?></span></h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</section>

	<?php } ?>
	<?php endif; ?>
	
</aside>