<div class='pager'>
	<?php 
	global $wp_query;
	$carrotlite_big = 999999999;
	echo paginate_links(array(
		'base' => str_replace( $carrotlite_big, '%#%', esc_url( get_pagenum_link( $carrotlite_big ) ) ),  
    	'format' => '/page/%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'next_text' => __('Next page', 'carrotlite') . ' <i class="fa fa-chevron-right"></i>',
		'prev_text' => '<i class="fa fa-chevron-left"></i>' . __('Previous page', 'carrotlite'),
	));
	 ?> 
</div>