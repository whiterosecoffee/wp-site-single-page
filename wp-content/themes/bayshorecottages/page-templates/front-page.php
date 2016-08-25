<?php /* Template Name: Front Page Templated*/?>
<?php get_header(); ?>
<div id="content">
	
    <section id="home" class="darkSection">
		<img src="<?php bloginfo('stylesheet_directory');?>/img/homeBg2.jpg" id="homeImg"/>
		<!--<h1>Bayshore Cottages</h1>
        <p>Bayshore Cottages is a beautiful resort where people come to relax and enjoy the Bruce Penninsula and its well known man made sandy beach and 
        wonderful hospitality. </p>-->
    </section>	
    
    <section id="accomodations" class=" darkSection">
    	<div class="content contentPadding">
            <h1>Accomodations</h1>
			<?php if (function_exists('nivoslider4wp_show')){ nivoslider4wp_show();}?>
            <?php			
				$page = get_page_by_title( 'Accomodations' );
				$page_date = get_page($page);
				$content = apply_filters('the_content', $page_date->post_content);
				echo $content; 
			?>
    	</div><!--.CONTENT-->
    </section>    
        
    <section id="amenities" class="">
        <div class="content contentPadding ">
            <h1>Amenities</h1>
            <?php			
				$page = get_page_by_title( 'Amenities' );
				$page_date = get_page($page);
				$content = apply_filters('the_content', $page_date->post_content);
				echo $content; 
			?>
            <h3>Complete Cottage Inventory</h3><?php echo do_shortcode('[wpdm_file id=1]');?>
 		</div><!-- .content -->         
    </section>    
     <section id="faq" class="darkSection">
        <div class="content contentPadding">
            <h1>FAQ</h1>
            <h3>Everything you need to know to have a great visit!</h3>
            <?php echo do_shortcode('[faq]'); ?>
        </div>
    </section><!--faq-->      
    
    <section id="gallery" class="">
    <style>
/* PARENT CONTAINER */
@media screen and (min-width: 851px) {div#ppg{max-width:75%; margin:0 auto;}}

/*MAIN IMAGE*/
div#ppg-image{border:1px solid #1a649d; overflow:hidden;}
	div#ppg-image img{width:100%;}

/*OVERFLOW CONTROLS*/
div#ppg-controls{margin-bottom:5px; text-align:}

	div#ppg-controls div.ppg-button{width:22px;}
	div#ppg-controls div#ppg-prev{background-position: -20px 50%;}
	div#ppg-controls div#ppg-next{float:right;}
	
/*THUMBNAILS*/
div#ppg-thumbnails{overflow:hidden;}
	div#ppg-thumbnails ul{width:9999px; max-width:9999px!important; margin-bottom:0!important; padding-left:0!important;}
		
		div#ppg-thumbnails ul li{float:left; margin:.25rem 0 .25rem .25rem; list-style:none!important; padding:none;}
		
			div#ppg-thumbnails ul li a{display:block;}
			div#ppg-thumbnails ul li a:hover{outline:1px solid grey;}

				div#ppg-thumbnails ul li a img{display:block;}
</style>
				

<script type="text/javascript">
$(document).ready(function() {
	//STYLES - RELATIONSHIPS ONLY - SHOULD ADJUST TO SIZE OF THUMBNAILS
	$('div#ppg-controls div.ppg-button').css("height",$('div#ppg-controls').outerHeight( true ) +'px')
	$('div#ppg-controls div.ppg-button').css("background", "#1a649d url(<?php bloginfo('stylesheet_directory'); ?>/img/arrows.png) 0px 50%  no-repeat")
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
        <div class="content contentPadding">
            <h1>Gallery</h1>
            <div id="ppg">
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
                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $posts_array[0]->ID ), 'gallery-featured-image' ); ?>
                
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
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'gallery-featured-image' );
                                setup_postdata($post);?> 
                                <li id="<?php echo $i; ?>">
                                    <a href="javascript:;" class="image" title="<?php echo the_title();?>" rel="<?php echo $image[0]; ?>">
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
            </div><!--ppg-->
        </div>.<!--content-->
    </section><!--faq-->      

    <section id="activities" class="">
		<div class="content contentPadding">
			<h1>Activities</h1>
            <?php			
				$page = get_page_by_title( 'activities' );
				$page_date = get_page($page);
				$content = apply_filters('the_content', $page_date->post_content);
				echo $content; 
			?>
    	</div><!--.CONTENT-->
    </section>
 <section id="aboutUs" class="darkSection">
        <div class="content contentPadding">
        	<?php			
				$page = get_page_by_title( 'About Us' );
				$page_date = get_page($page);
				$content = apply_filters('the_content', $page_date->post_content);
				echo $content; 
			?>
		</div><!--.content-->
    </section>
    
    <iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.ca/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=186+Old+Mill+Road,++Wiarton&amp;aq=&amp;sll=49.25635,-123.103266&amp;sspn=0.010042,0.026157&amp;ie=UTF8&amp;hq=&amp;hnear=186+Old+Mill+Rd,+Wiarton,+Grey+County,+Ontario+N0H+2T0&amp;t=m&amp;ll=44.776535,-81.083565&amp;spn=0.021325,0.095358&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>    
    
    <section id="contactUs">
        <div class="content contentPadding" >
            <img src="<?php bloginfo('stylesheet_directory');?>/img/contact.jpg" id="contact" />
        </div>
	</section>

	<section id="guestBook" class="darkSection">
        <div class="content contentPadding">
            <h1>Guest Book</h1>
            <?php echo do_shortcode('[comment-guestbook]'); ?>
        </div>
    </section>
    <section id="policies" class="mediumSection">
        <div class="content contentPadding  ">
        	<?php			
				$page = get_page_by_title( 'Policies' );
				$page_date = get_page($page);
				$content = apply_filters('the_content', $page_date->post_content);
				echo $content; 
			?>
 		</div>           
    </section>      
</div><!--CONTENT-->


<?php get_footer(); ?>