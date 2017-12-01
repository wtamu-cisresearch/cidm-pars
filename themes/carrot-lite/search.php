<?php get_header(); ?>
<section class="main post-list">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part('post'); ?>
		<?php endwhile; ?>

		<?php get_template_part('pager'); ?>
		
	<?php else : ?>
	<article class="post">
		<h1><?php _e( 'No posts found. Try a different search?', 'carrotlite' ); ?></h1>
		<?php get_search_form(); ?>
	</article>
	<?php endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>