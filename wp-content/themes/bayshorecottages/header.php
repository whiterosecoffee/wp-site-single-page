<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">	<title><?php wp_title(); ?></title>
    <script src="<?php bloginfo('stylesheet_directory');?>/js/modernizr.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/style.css">
    <link href='http://fonts.googleapis.com/css?family=Vollkorn:700,400' rel='stylesheet' type='text/css'>
    <!--[if (lt IE 9) & (!IEMobile)]>
        <link rel="stylesheet" href="css/ie.css">
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <![endif]-->


    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script> 
<?php wp_head();?>

</head>
<body>
<?php DISPLAY_ACURAX_ICONS(); ?>

<header class="wrap">
    <header class="content">
        <a class="nav-btn" id="nav-open-btn" href="#nav">Book Navigation</a>
        <nav id="nav" role="navigation" class="">
            <?php wp_nav_menu(array(container => ''));?>
            <a id="nav-close-btn" class="nav-btn" href="#top">Return to Content</a>
        </nav>
	</header><!--.content-->
</header><!--.wrap-->
<div id="page" class="">
	<div id="main" class="<?php the_parent_slug();?> floatfix">