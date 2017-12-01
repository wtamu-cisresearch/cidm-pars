<form method="get" class="searchform" action="<?php echo esc_url(home_url()); ?>">
<fieldset>
	<input type="text" value="<?php the_search_query(); ?>" name="s" placeholder="Search the site"> <button type="submit" name="searchsubmit" value="<?php _e('Search', 'carrotlite') ?>"><i class="fa fa-search"></i></button>
</fieldset>
</form>