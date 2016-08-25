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
div#gallery-menu{float:left; width: 29%; outline:10xp solid red!important;}
div#gallery-menu h1{margin:0 0 10px;}
div#gallery-menu ul#menu-gallery > li{font-weight:bold;}
div#gallery-menu ul#menu-gallery ul.sub-menu > li{font-weight:normal; padding-left:5px;}

div#ppg{float:right; width:70%;}
div#ppg{}

/*MAIN IMAGE*/
div#ppg-image{height:500px; border:2px solid #2c56a3; overflow:hidden;}
	div#ppg-image img{width:100%;}

/*OVERFLOW CONTROLS*/
div#ppg-controls{}

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
	$('div#ppg-controls div.ppg-button').css("background", "#2c56a3 url(<?php bloginfo('stylesheet_directory'); ?>/img/arrows.png) 0px 50%  no-repeat")
	$('div#ppg-controls div#ppg-prev').css("background-position", "-20px 50%")
	$('div#ppg-thumbnails').css("width", ($('div#ppg').width() - ($('div#ppg-controls div.ppg-button').width()*2))+'px')
	$('div#ppg-thumbnails ul').css("width", ($('#ppg-thumbnails ul li').length * $('#ppg-thumbnails ul li').outerWidth(true))+'px')



	var start_title = $('.wrapper ul li:first-child a').attr("title");
	$('#title').html(start_title);			
	var selection = 0;
	var slideshow_delay = 3; // seconds
	var timer = null;
	
	function select_thumb(selected_thumb) {
		var image = $(selected_thumb).attr("rel");
		var title = $(selected_thumb).attr("title");
		$('#selected-image').fadeOut('fast');
		//$('#title').hide();
		$('#selected-image').promise().done(function(){ // Wait for the fadeOut to finish.
			$('#title').html(title);			
			$('#selected-image').attr({src: image});
			$('#selected-image').fadeIn('slow');
		});
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
		'category_name'		=> $post->post_name, 
		'post_status'		=> 'publish' 
		);
	
	$posts_array = get_posts( $args );

?>
<div id="content" >
    
    <div id="gallery-menu">
    	<h1>Our custom work in asdf<?php if($post->post_name == "our-work"){echo "action";}else{ echo get_the_title();}?> </h1>
        <p>Discover Web Dev has been crafting custom work for homes in Sarnia and the surrounding area since 1949.  Contact us to find out what we can do to help you turn your house into your dream home. </p>
		<?php wp_nav_menu( array('menu'  => 'gallery','menu_class' => 'gallery-menu', 'container'=>'div') ); ?>
    </div><!--gallery-menu-->
    	
    <div id="ppg">
		
		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $posts_array[0]->ID ), $post->post_name.'-featured-image' ); ?>
        
        <div id="ppg-image">
        	<img src="<? echo $image[0]; ?>" id="selected-image"/>
        </div><!--ppg-image-->
        
        <div id="ppg-controls">
            <div id="ppg-prev" class="ppg-button floatleft"></div>
            <div id="ppg-thumbnails" class="floatleft">	
                <ul class="floatfix">
                    <?php $i = 0;
                    $total = $posts_array.length; 
                    foreach($posts_array as $post) {
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $post->post_name.'-featured-image' );
                        setup_postdata($post);?> 
                        <li id="<?php echo $i; ?>">
                            <a href="#" class="image" title="<?php echo the_title();?>" rel="<?php echo $image[0]; ?>">
                                <?php the_post_thumbnail('featured-thumbnail', array('class' => 'thumb')); ?>
                        </a>
                        </li><?php
            
                        $i += 1;
                    } //END foreach?>
                </ul>
            </div><!--ppg-thumbnails-->
            <div id="ppg-next" class="ppg-button floatleft"></div>
            <div class="clearboth"></div>
        </div><!--ppg-controls-->
        
    </div><!--ppg-->
  
</div><!-- #content -->
<?php get_footer(); ?>