<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
	<title><?php echo $template['title']; ?></title>
	<link href="http://localhost/assets/css/bootstrap.css" type="text/css" rel="stylesheet" />
	<link href="http://localhost/assets/css/expose.css" type="text/css" rel="stylesheet" />
	<link href="http://localhost/assets/js/chosen/chosen.css" type="text/css" rel="stylesheet" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="http://localhost/assets/js/bootstrap-alert.js"></script>
	<script src="http://localhost/assets/js/bootstrap-tab.js"></script>
	<script src="http://localhost/assets/js/bootstrap-dropdown.js"></script>
	<script src="http://localhost/assets/js/chosen/chosen.jquery.js"></script>
	<script src="http://localhost/assets/js/expose.js"></script>
	<?php echo $template['metadata']; ?>
    </head>
    <body>
	<div class="container">
	    <div class="row">
		<img src="<?php echo image_url('ads/LuckyBanner1.gif');?>" alt="ad"
		     style="display: block;margin-left: auto;margin-right: auto" />
	    </div>
	    <div class="row">
		<img src="<?php echo image_url('site/header.jpg');?>" alt="header" />
	    </div>
	    <div class="navbar"id="site-menu">
		<?php echo $template['partials']['menu']; ?>
	    </div>
	    <?php if ($load_message): ?>
	    <div class="alert alert-info">
		<a class="close" data-dismiss="alert" href="#">×</a>
		<p><?php echo $load_message; ?></p>
	    </div>
	    <?php endif; ?>
	    <div class="row" id="main-content">
		<div class="span3">
		    <h2>left column</h2>
		</div>
		<div class="span6">
		    <h1><?php echo $page_name; ?></h1>
		    <?php echo $template['body']; ?>
		</div>
		<div class="span3">
		    <h2>right column</h2>
		</div>
	    </div>
	</div>
	<footer>
	    <div class="container">
	    <p><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">
		    <img alt="Creative Commons License" style="border-width:0" 
			 src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" /></a>
			 This <span xmlns:dct="http://purl.org/dc/terms/" 
				    href="http://purl.org/dc/dcmitype/Text" rel="dct:type">work</span>
			 is licensed under a <a rel="license" 
				href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative 
			     Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.</p>
	    </div>
	    <?php if (ENVIRONMENT == 'development') : ?>
	    <div class="well">
		<?php echo $trace; ?>
	    </div>
	    <?php endif; ?>
	</footer>
    </body>
</html>