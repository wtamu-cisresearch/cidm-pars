<!-- Start: Post -->
<article <?php post_class(); ?>>
	<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	<p class="post-meta"><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')) ?> <?php if(has_category()): ?><span class="delimiter">|</span> <i class="fa fa-folder"></i> <?php the_category(", "); ?> <?php endif; ?> <?php if ( comments_open() ) : ?> <span class="delimiter">|</span> <?php comments_popup_link('0', '1', '<i class="fa fa-comment"></i> %', 'comment-link'); ?><?php endif; ?></p>
	<?php if(has_post_thumbnail()) : ?><div class="post-thumbnail"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a></div><?php endif; ?>
	<?php the_excerpt(); ?>
	<p class="more"><a href="<?php the_permalink() ?>"><?php _e( 'Read more', 'carrotlite' );?> <span class="fa fa-chevron-circle-right"></span></a></p>
	<?php if(has_tag()): ?><p class="tags"><span class="fa fa-tags"></span> <?php _e('Tags', 'carrotlite'); ?>: <?php the_tags(""); ?></p><?php endif; ?>
</article>
<!-- End: Post -->