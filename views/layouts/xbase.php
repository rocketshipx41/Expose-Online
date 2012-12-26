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
        <link rel="shortcut icon" href="/assets/img/site/favicon.ico" />
	<link href="/assets/css/expose.css" type="text/css" rel="stylesheet" />
	<link href="/assets/js/chosen/chosen.css" type="text/css" rel="stylesheet" />
        <link href="/assets/css/kendo.common.min.css" rel="stylesheet" />
	<link href="/assets/css/kendo.default.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="/assets/css/style-caper-base.css" media="screen, projection, print" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.form.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.isdirty.js"></script>
	<script src="/assets/js/chosen/chosen.jquery.js"></script>
        <script type="text/javascript" src="/assets/js/common.js"></script>
        <script src="/assets/js/kendo.all.min.2012.3.106.js"></script>
	<script src="/assets/js/expose.js"></script>
	<?php echo $template['metadata']; ?>
    </head>
    <body>
        <div class="row">
            <div class="span_12">
                <img src="<?php echo image_url('ads/LuckyBanner1.gif');?>" alt="ad"
                    style="display: block;margin-left: auto;margin-right: auto" />
            </div>
        </div>
        <div class="row">
            <div class="span_12">
                <img src="<?php echo image_url('site/header.jpg');?>" alt="header"
                    style="display: block;margin-left: auto;margin-right: auto"  />
            </div>
        </div>
        <header class="app-header clearfix">
            <?php echo $template['partials']['menu']; ?>
        </header>
        <?php if ($load_message): ?>
        <div class="alert alert-info">
            <a class="close" data-dismiss="alert" href="#">×</a>
            <p><?php echo $load_message; ?></p>
        </div>
        <?php endif; ?>
        <div class="row" id="main-content">
            <div class="span_3" id="left-column">
                <?php echo $template['partials']['left_column']; ?>
            </div>
        <?php if ( $show_columns == 3 ) : ?>
            <div class="span_6" id="center-column">
                <div class="row">
                    <div class="span_6">
                        <h1><?php echo $page_name; ?></h1>
                    </div>
                </div>
                <?php echo $template['body']; ?>
            </div>
            <div class="span_3"id="right-column">
                <?php echo $template['partials']['right_column']; ?>
            </div>
        <?php else : ?>
            <div class="span_9" id="center-column">
                <h1><?php echo $page_name; ?></h1>
                <?php echo $template['body']; ?>
            </div>
        <?php endif; ?>
        </div>
	<footer>
            <hr>
	    <div class="container">
                <img src="<?php echo image_url('site/agent.gif');?>" class="footer-man"
                 alt="<?php echo lang('article_cover_art_alt'); ?>">
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