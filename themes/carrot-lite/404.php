<?php get_header(); ?>
<section class="columns e404">
	<article class="col2 main-msg">
		<p class="errno">404</p>
		<p><?php _e('Houston, we\'ve got a problem! This page was not found!', 'carrotlite'); ?></p>
	</article><article class="col2">
		<p><?php _e("Can't find what you need?<br>Take a moment and do a search below!", 'carrotlite'); ?></p>
		<?php get_search_form(); ?>
		<p><span><?php _e('or', 'carrotlite'); ?></span></p>
		<p><a href="<?php echo esc_url(home_url()); ?>	" class="btn large orange"><i class="fa fa-home"></i> <?php _e('Go back to home page', 'carrotlite'); ?></a></p>
	</article>
</section>
<?php get_footer(); ?>