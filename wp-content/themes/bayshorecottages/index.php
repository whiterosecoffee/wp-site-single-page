<?php get_header(); ?>
<div id="content" class="contentPadding">
	<?php			
        $page = $post->ID;
        $page_date = get_page($page);
        $content = apply_filters('the_content', $page_date->post_content);
        echo $content; 
    ?>
</div><!--CONTENT-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>