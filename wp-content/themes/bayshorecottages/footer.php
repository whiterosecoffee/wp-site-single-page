    </div> <!-- CONTENT -->
</div> <!-- PAGE -->        
<footer class="wrap horPadding">
    <footer id="" class="content clearfix contentPadding">
        <?php wp_nav_menu(array('menu' => 'footer-menu', menu_id => 'footer-menu', container => false));?>
        <h2>186 Old Mill Road, Wiarton, ON, Canada NOH 2TO Telephone 519-534-5508 or 905-791-5883  </h2>
        <section id="addedValue">
        	<img src="<?php bloginfo('stylesheet_directory');?>/img/payment-meathods-mc.png" width="50" height="34" class="addedValue"/>
            <img src="<?php bloginfo('stylesheet_directory');?>/img/payment-meathods-visa.png" width="50" height="34" class="addedValue"/>
            <img src="<?php bloginfo('stylesheet_directory');?>/img/payment-meathods-interac.png" class="addedValue"/>
            <img src="<?php bloginfo('stylesheet_directory');?>/img/free-wifi.png" width="50" class="addedValue"/>
		</section>
    </footer> <!-- FOOTER .CONTENT -->
</footer> <!-- FOOTER .WRAP -->

<!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->
<script src="<?php bloginfo('stylesheet_directory');?>/js/main.js"></script>
<script>
$(document).ready(function(){
	$("ul.sub-menu").parent().filter(function() {$(this).prepend("<span></span>");})
	$("ul#menu-main li span").click(function() { //When trigger is clicked...
		$(this).parent().find("ul.sub-menu").toggle('normal').show();
		$(this).parent().siblings().find('ul.sub-menu').slideUp();
		return false;
	});

});
</script>
<?php wp_footer(); // js scripts are inserted using this function ?>
</body>
</html>	