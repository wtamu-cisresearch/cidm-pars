<?php 
get_header(); 
$carrotlite_front = is_front_page();
if($carrotlite_front) :	
	$carrotlite_front_message = get_theme_mod('home_msg') ? carrotlite_sanitize(get_theme_mod('home_msg')) : false;
	if($carrotlite_front_message) : ?>
	<article class="intro">
		<?php echo nl2br($carrotlite_front_message); ?>
	</article>
	<?php endif; 
endif; ?>
<section class="main single">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article class="page">
			<h1><?php the_title(); ?></h1>
			<?php if(has_post_thumbnail()) : ?><div class="post-thumbnail"><?php the_post_thumbnail(); ?></div><?php endif; ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.__('Pages', 'carrotlite').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</article>

		<?php comments_template(); ?>
	<?php endwhile; endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>