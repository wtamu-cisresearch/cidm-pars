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

<?php if($carrotlite_front) : ?>
	<section class="main post-grid cols">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<article <?php post_class('col col3'); ?>>
					<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<p class="post-meta"><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')) ?> <?php if(has_category()): ?><span class="delimiter">|</span> <i class="fa fa-folder"></i> <?php the_category(", "); ?> <?php endif; ?> <?php if ( comments_open() ) : ?><span class="delimiter">|</span> <i class="fa fa-comment"></i> <?php comments_popup_link('0', '1', '%', 'comment-link'); ?><?php endif; ?></p>
					<?php if(has_post_thumbnail()) : ?><div class="post-thumbnail"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('grid'); ?></a></div><?php endif; ?>
					<?php the_excerpt(); ?>
					<p class="more"><a href="<?php the_permalink() ?>"><?php _e( 'Read more', 'carrotlite' );?> <span class="fa fa-chevron-circle-right"></span></a></p>
					<?php if(has_tag()): ?><p class="tags"><span class="fa fa-tags"></span> <?php _e('Tags', 'carrotlite'); ?>: <?php the_tags(""); ?></p><?php endif; ?>
				</article>
			<?php endwhile; ?>

			<?php get_template_part('pager'); ?>
			
		<?php else : ?>
			<h2 class="center"><?php _e( 'Not found', 'carrotlite' ); ?></h2>
			<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'carrotlite' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</section>
<?php else : ?>
	<section class="main post-list">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('post'); ?>				
			<?php endwhile; ?>

			<?php get_template_part('pager'); ?>
			
		<?php else : ?>
			<h2 class="center"><?php _e( 'Not found', 'carrotlite' ); ?></h2>
			<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'carrotlite' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</section>
<?php endif; ?>
<?php if(!$carrotlite_front) get_sidebar(); ?>
<?php get_footer(); ?>
