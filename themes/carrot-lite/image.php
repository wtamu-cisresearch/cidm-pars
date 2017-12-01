<?php get_header(); ?>
<section class="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article class="page">
		<h1><?php the_title(); ?></h1>
		<p><?php printf( __( '<a href="%1$s"><span class="icon-chevron-left"></span>%2$s</a>', 'carrotlite' ), get_permalink( $post->post_parent ), get_the_title( $post->post_parent ));?></p>
		<p><a href="<?php echo wp_get_attachment_url($post->ID); ?>" class="image-link"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a></p>
		<?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?>
		<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages', 'carrotlite').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	</article>

	<nav class="post-nav images">
		<span class="prev"><?php previous_image_link(); ?></span>
		<span class="next"><?php next_image_link(); ?></span>
	</nav>

	<?php comments_template(); ?>
	
	<?php endwhile; endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
