<?php get_header(); ?>
<section class="main post-list">
	<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
		  <h1><?php single_cat_title(); ?></h1>
		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		  <h1><?php single_tag_title(); ?></h1>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		  <h1><?php echo get_the_time('F jS, Y'); ?></h1>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		  <h1><?php echo get_the_time('F, Y'); ?></h1>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		  <h1><?php echo get_the_time('Y'); ?></h1>
		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		  <h1><?php _e( 'Author Archive', 'carrotlite' ); ?></h1>
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		  <h1><?php _e( 'Blog Archives', 'carrotlite' ); ?></h1>
		<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part('post'); ?>
		<?php endwhile; ?>

		<?php get_template_part('pager'); ?>
		
	<?php else: ?>
		<h2><?php _e( 'Not found', 'carrotlite' ); ?></h2>
		<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'carrotlite' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</section>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
