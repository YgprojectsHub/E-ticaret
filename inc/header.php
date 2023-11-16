<?php 
echo !defined('security') ? die("HACK") : null;

require_once './system/function.php';

if($arow->sitedurum != 1){
	go($site.'/maintenance.php');
	die();
}

?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title><?php echo $title['title'];?></title>

		<meta name="robots" content="index, follow">
		<meta name="description" content="<?php echo $title['desc'];?>">
		<meta name="keywords" content="<?php echo $title['keyw'];?>">
		<meta name='copyright' content='<?php echo baslik;?>'>
		<link rel="canonical" href="<?php echo loc();?>" />
		<meta property="og:locale" content="en">
		<meta property="og:title" content="<?php echo $title['title'];?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo loc();?>">
		<meta property="og:image" content="<?php echo $title['img'];?>">
		<meta property="og:site_name" content="<?php echo $title['title'];?>">
		<meta property="og:description" content="<?php echo $title['desc'];?>">

		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:site" content="@yusufg">
		<meta name="twitter:creator" content="yusufgb2b">
		<meta name="twitter:title" content="<?php echo $title['title'];?>">
		<meta name="twitter:description" content="<?php echo $title['desc'];?>">
		<meta name="twitter:image:src" content="<?php echo $title['img'];?>">


		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo site;?>/uploads/favicon.ico">
		<!-- Place favicon.ico in the root directory -->
		
		<!-- Google Font -->
		<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>

		<!-- all css here -->
		<!-- bootstrap v5 css -->
		<link rel="stylesheet" href="<?php echo site;?>/css/bootstrap.min.css">
		<!-- animate css -->
		<link rel="stylesheet" href="<?php echo site;?>/css/animate.min.css">
		<!-- jquery-ui.min css -->
		<link rel="stylesheet" href="<?php echo site;?>/css/jquery-ui.min.css">
		<!-- meanmenu css -->
		<link rel="stylesheet" href="<?php echo site;?>/css/meanmenu.min.css">
		<!-- nivo-slider css -->
		<!-- slick css -->
		<link rel="stylesheet" href="<?php echo site;?>/css/slick.min.css">
		<!-- lightbox css -->
		<link rel="stylesheet" href="<?php echo site;?>/css/lightbox.min.css">
		<!-- material-design-iconic-font css -->
		<link rel="stylesheet" href="<?php echo site;?>/css/material-design-iconic-font.css">
		<!-- All common css of theme -->
		<link rel="stylesheet" href="<?php echo site;?>/css/default.css">
		<!-- style css -->
		<link rel="stylesheet" href="<?php echo site;?>/style.css">
        <!-- shortcode css -->
        <link rel="stylesheet" href="<?php echo site;?>/css/shortcode.css">
		<!-- responsive css -->
		<link rel="stylesheet" href="<?php echo site;?>/css/responsive.css">
		<!-- modernizr css -->
		<script src="<?php echo site;?>/js/vendor/modernizr-3.11.2.min.js"></script>
	</head>
	<body>	