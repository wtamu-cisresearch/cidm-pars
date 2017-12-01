
<?php
	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>
	
	
<?php if ( ! comments_open() & is_single() )  : ?><p><?php _e( 'Comments are currently closed.', 'carrotlite' ); ?></p><?php endif; ?>
<?php if(comments_open()): ?>
<div id="comments">
	<?php if ($comments) : ?>
		<section class="comments">
			<h2><i class="fa fa-comments"></i> <?php printf( _n( 'One comment', '%1$s comments', get_comments_number(), 'carrotlite'), number_format_i18n( get_comments_number() ));?></h2>
			<ul class="commentlist">
				<?php wp_list_comments('callback=carrotlite_comment'); ?>
			</ul>		
			<p><?php paginate_comments_links(); ?></p>			
		</section>
	<?php endif; ?>
	<section class="comment-form" id="respond">
		<?php comment_form(carrotlite_comment_form_args()); ?>
	</section>
</div>
<?php endif; ?>