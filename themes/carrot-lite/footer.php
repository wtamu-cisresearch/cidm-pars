		<a href="#top" class="go-top" title="Go to top of page"><i class="fa fa-angle-up"></i></a>
	</section>
	<footer>
		<section class="widgets">
			<div class="cols">
				<?php if (!dynamic_sidebar('footer-widget-area') ) : ?><?php endif; ?>	
			</div>
		</section>
		<section class="bottom">
			<?php wp_nav_menu( array('fallback_cb' => 'carrotlite_page_menu', 'depth' => '1', 'theme_location' => 'secondary', 'link_before' => '', 'link_after' => '', 'container' => false) ); ?>
			<p><a href="<?php get_bloginfo('rss2_url') ?>"><i class="fa fa-rss"></i> <?php _e('RSS Feed', 'carrotlite'); ?></a></p>
		</section>
		<?php wp_footer(); ?>
	</footer>
</body>
</html>