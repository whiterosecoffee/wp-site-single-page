<?php //Template Name: Gallery ?>
<?php /*
	
	Requires 
	FOLDER: themeRoot/liquidcarousel 
	FILES: css/photo-gallery.css.  
	PLUGINS: Automatic Featured Image Posts, Bulk Move, Bulk-Select Featured Image, Regenerate Thumbnails. 
	functions.php: 
	
		//THUMNAILS
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'featured-image', 605, 345, true );
		add_image_size( 'featured-thumbnail', 50, 50, true );
	

*/
?>
<?php get_header(); ?>

<style>
/* PARENT CONTAINER */
div#ppg{}

/*MAIN IMAGE*/
div#ppg-image{min-height:414px; border:2px solid #D12222; overflow:hidden;}
	div#ppg-image img{width:100%;}

/*OVERFLOW CONTROLS*/
div#ppg-controls{margin-bottom:5px;}

	div#ppg-controls div.ppg-button{width:22px;}
	div#ppg-controls div#ppg-prev{background-position: -20px 50%;}
	div#ppg-controls div#ppg-next{float:right;}
	
/*THUMBNAILS*/
div#ppg-thumbnails{overflow:hidden;}
	div#ppg-thumbnails ul{width:9999px;}
		
		div#ppg-thumbnails ul li{float:left; margin:.5rem 0 .5rem .5rem ;}
		
			div#ppg-thumbnails ul li a{display:block;}
			div#ppg-thumbnails ul li a:hover{outline:1px solid grey;}

				div#ppg-thumbnails ul li a img{display:block;}
</style>
				

<script type="text/javascript">
$(document).ready(function() {
	//STYLES - RELATIONSHIPS ONLY - SHOULD ADJUST TO SIZE OF THUMBNAILS
	$('div#ppg-controls div.ppg-button').css("height",$('div#ppg-controls').outerHeight( true ) +'px')
	$('div#ppg-controls div.ppg-button').css("background", "#D12222 url(<?php bloginfo('stylesheet_directory'); ?>/img/arrows.png) 0px 50%  no-repeat")
	$('div#ppg-controls div#ppg-prev').css("background-position", "-20px 50%")
	$('div#ppg-thumbnails').css("width", ($('div#ppg').width() - ($('div#ppg-controls div.ppg-button').width()*2)-5)+'px')
	$('div#ppg-thumbnails ul').css("width", ($('#ppg-thumbnails ul li').length * $('#ppg-thumbnails ul li').outerWidth(true))+'px')



	var start_title = $('.wrapper ul li:first-child a').attr("title");
	$('#title').html(start_title);			
	var selection = 0;
	var slideshow_delay = 3; // seconds
	var timer = null;
	
	function select_thumb(selected_thumb) {
		var image = $(selected_thumb).attr("rel");
		var title = $(selected_thumb).attr("title");
		$('#selected-image').attr({src: image});

		$('#title').html(title);	
		
		$('#selected-image').fadeIn('slow');
		//$('#title').fadeIn('slow');
		selection = parseInt($(selected_thumb).parent().attr("id"), 10);
		return false;
	}
	
	function move_photo_selector(distance) {
		selection += distance;
		var list_length = <?php echo (count($posts_array));?>;
		while (selection >= list_length) { selection -= list_length; }
		while (selection < 0) { selection += list_length; }
		thumb_element = $("#" + selection + " a");
		select_thumb(thumb_element);
	}
	
	function advance_slideshow() {
		move_photo_selector(1);
	}
	
	function start_slideshow() {
		advance_slideshow(); // Lets assume that the user has already looked at the current image before they found the Start Slideshow button.
		timer = setInterval(advance_slideshow, (slideshow_delay + 2) * 1000); // Add a second to the interval for fadeOut time, and for fadeIn time.
		$("#start-stop-button").html("Stop Slideshow");
	}
	
	function stop_slideshow() {
		if(timer != null) {
			clearInterval(timer);
			timer = null
			$("#start-stop-button").html("Play Slideshow");
		}
	}
		
	$(function() { // Switch the featured image to the thumbnail's full size image.
		$(".image").click(function() {
			select_thumb(this);
			stop_slideshow();
		});
	});
	$("#start-stop-button").click( function() {
		if(timer == null) start_slideshow();
		else stop_slideshow();
	});

	
	function moveThumbnails	(offset){
		
		currentOffset = parseInt($("#ppg-thumbnails ul").css('margin-left'));
		distance = $("div#ppg-thumbnails").width();
		maxOffset = (($('#ppg-thumbnails ul li').length * $('#ppg-thumbnails ul li').outerWidth(true))-distance)*-1;
		
		if(offset == "ppg-prev") {
			//Past End of List
			if(currentOffset + distance >= 0){
				newOffset = '0px';
			}
			else{
				newOffset = (currentOffset + distance)+'px';
			}
		}//PREV
		
		if(offset == "ppg-next") {
			//Past Start of List
			if(currentOffset - distance <= maxOffset){
				newOffset = maxOffset+'px';
			}
			else{
				newOffset = (currentOffset - distance)+'px';
			}
		}//NEXT
		
		$("#ppg-thumbnails ul").animate({marginLeft:newOffset});
	};
	
	//Move Thumbnail Bar 
	$(".ppg-button").click( function() {
		moveThumbnails($(this).attr('id'));
	});
});
	
</script>

<?php global $post; ?>
<?php 
	
	//Query Database for all published posts in the Gallery category
	$args = array( 
		'numberposts'		=> 999,
		'post_type'			=> 'gallery',
		'post_status'		=> 'publish' 
		);
	
	$posts_array = get_posts( $args );

?>
<div id="primary" class="site-content <?php the_parent_slug();?>">
<div id="content" >
	
    <div id="ppg">
		
		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $posts_array[0]->ID ), 'featured-image' ); ?>
        <div id="ppg-controls">
            <div id="ppg-prev" class="ppg-button floatleft"></div>
            <div id="ppg-thumbnails" class="floatleft">	
                <ul class="floatfix">
                    <?php $i = 0;
                    $total = $posts_array.length; 
                    foreach($posts_array as $post) {
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'gallery-featured-image' );
                        setup_postdata($post);?> 
                        <li id="<?php echo $i; ?>">
                            <a href="#" class="image" title="<?php echo the_title();?>" rel="<?php echo $image[0]; ?>">
                                <?php the_post_thumbnail('gallery-thumbnail', array('class' => 'thumb')); ?>
                        </a>
                        </li><?php
            
                        $i += 1;
                    } //END foreach?>
                </ul>
            </div><!--ppg-thumbnails-->
            <div id="ppg-next" class="ppg-button floatleft"></div>
            <div class="clearboth"></div>
        </div><!--ppg-controls-->
        <div id="ppg-image">
        	<img src="<? echo $image[0]; ?>" id="selected-image"/>
        </div><!--ppg-image-->
        
        
        
    </div><!--ppg-->
  
</div><!-- #content -->

</div><!-- #PRIMARY -->

<div id="secondary" class="site-content">
    

    
    <div id="references" class="secondaryContent">
        <?php $loop = new WP_Query( array( 'post_type' => 'reference', 'orderby' => 'rand', 'posts_per_page' => 1 ) ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <article class="reference">
                <blockquote><?php the_content(); ?></blockquote>
                <cite>
                    <?php the_title( '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' ); ?>
                    <?php echo get_the_excerpt(); ?>
                </cite>
            </article>
        <?php endwhile; ?>

    </div><!--references-->

</div><!--SECONDARY-->        

<?php get_footer(); ?>