<?php get_header(); ?>
<section class="main single">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article class="post">
			<h1><?php the_title(); ?></h1>
			<p class="post-meta"><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')) ?> <?php if(has_category()): ?><span class="delimiter">|</span> <i class="fa fa-folder"></i> <?php the_category(", "); ?> <?php endif; ?> <?php if ( comments_open() ) : ?><span class="delimiter">|</span> <i class="fa fa-comment"></i> <?php comments_popup_link('0', '1', '%', 'comment-link'); ?><?php endif; ?> <?php edit_post_link(' <i class="fa fa-edit"></i>' .  __('Edit this entry', 'carrotlite'), '', ''); ?></p>
			<?php if(has_post_thumbnail()) : ?><div class="post-thumbnail"><?php the_post_thumbnail(); ?></div><?php endif; ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.__('Pages', 'carrotlite').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php if(has_tag()): ?><p class="tags"><span class="fa fa-tags"></span> <?php _e('Tags', 'carrotlite'); ?>: <?php the_tags(""); ?></p><?php endif; ?>
		</article>

		<?php comments_template(); ?>

		<nav class="post-nav">
			<?php previous_post_link('<span class="prev"><i class="fa fa-chevron-left"></i> %link </span>'); ?>
			<?php next_post_link('<span class="next"> %link <i class="fa fa-chevron-right"></i></span>'); ?>
		</nav>
	<?php endwhile; endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
