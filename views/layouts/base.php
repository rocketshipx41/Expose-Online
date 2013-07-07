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
        <?php if ($_SERVER["SERVER_NAME"] == 'localhost') : ?>
<!--        <meta name="robots" content="noindex,nofollow" /> -->
        <?php endif; ?>
        <link rel="shortcut icon" href="/assets/img/site/favicon.ico" />
	<link href="/assets/js/chosen/chosen.css" type="text/css" rel="stylesheet" />
        <link href="/assets/css/kendo.common.min.css" rel="stylesheet" />
	<link href="/assets/css/kendo.moonlight.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="/assets/css/style-caper-base.css" media="screen, projection, print" />
	<link href="/assets/css/expose.css" type="text/css" rel="stylesheet" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.form.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.isdirty.js"></script>
	<script src="/assets/js/chosen/chosen.jquery.js"></script>
        <script src="/assets/js/kendo.web.min.js"></script>
        <script src="/assets/js/jquery.barousel.js"></script>
        <script>
            var scaleVideo = '<?php echo $scale_video; ?>';
            var baseUrl = '<?php echo BASE_URL; ?>';
        </script>
	<script src="/assets/js/expose.js"></script>
	<?php echo $template['metadata']; ?>
    </head>
    <body>
    <?php if ($_SERVER["SERVER_NAME"] != 'localhost') : ?>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '515325815155869', // App ID from the App Dashboard
      channelUrl : '//expose.org/channel.html', // Channel File for x-domain communication
      status     : true, // check the login status upon init?
      cookie     : true, // set sessions cookies to allow your server to access the session?
      xfbml      : true  // parse XFBML tags on this page?
    });

    // Additional initialization code such as adding Event Listeners goes here

  };

  // Load the SDK's source Asynchronously
  // Note that the debug version is being actively developed and might 
  // contain some type checks that are overly strict. 
  // Please report such bugs using the bugs tool.
  (function(d, debug){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
     ref.parentNode.insertBefore(js, ref);
   }(document, /*debug*/ false));
</script>
<?php endif; ?>
<?php if ($system_status_message != '') : ?>
        <div id="systemstatus">
                <p><?php echo $system_status_message; ?></p>
        </div>
<?php endif; ?>
<?php if ( $show_ads ) : ?>
        <div id="banner-ad">
            <a href="http://<?php echo $banner_ad['url']; ?>" target="_blank">
                <img src="<?php echo image_url('ads/' . $banner_ad['image_file']);?>" 
                     alt="<?php echo $banner_ad['alt']; ?>"
                     title="<?php echo $banner_ad['title']; ?>"
                    style="display: block;margin-left: auto;margin-right: auto" />
            </a>
        </div>
<?php endif; ?>
        <header class="app-header clearfix">
            <div class="row">
                <div class="span_12">
                    <img src="<?php echo image_url('site/header.jpg');?>" alt="header"
                        style="display: block;margin-left: auto;margin-right: auto"  />
                </div>
            </div>
            <?php echo $template['partials']['menu']; ?>
        </header>
        <div id="matter">
            <section id="content">
                <div class="app-content">
                    <div class="container">
                        <div class="row">
                            <div class="span_3" id="left-column">
                                <?php echo $template['partials']['left_column']; ?>
                            </div>
                            <?php if ( $show_columns == 3 ) : ?>
                            <div class="span_6">
                            <?php else : ?>
                            <div class="span_9">
                            <?php endif; ?>
                                <?php if (count($page_alerts) != 0) : ?>
                                    <?php foreach ($page_alerts as $item) : ?>
                                <div class="alert-message block-message <?php echo $item['type']; ?>">
                                    <a class="close" href="#" onclick="close_status_alert(this);">×</a>
                                    <?php echo $item['message']; ?>
                                </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="container">
                                <?php echo $template['body']; ?>
                                </div>
                            </div> <!-- span main column -->
                            <?php if ( $show_columns == 3 ) : ?>
                            <div class="span_3" id="right-column">
                                <?php echo $template['partials']['right_column']; ?>
                            </div>
                            <?php endif; ?>
                        </div> <!-- row main content -->
                    </div> <!-- container -->
                </div> <!-- app content -->
            </section> <!-- content -->
        </div> <!-- matter -->
        <hr>
        <footer>
	    <div class="container">
                <div class="row">
                    <div class="span_6">
                        <p>
                            <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">
                            <img alt="Creative Commons License" style="border-width:0" 
                                 src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" /></a>
                                 This <span xmlns:dct="http://purl.org/dc/terms/" 
                                            href="http://purl.org/dc/dcmitype/Text" rel="dct:type">work</span>
                                 is licensed under a <a rel="license" 
                                        href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative 
                                     Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.
                        </p>
                     </div>
                    <div class="span_6">
                             <p class="pull-right">Total page views: <?php echo $hits; ?></p>
                     </div>
                </div> <!-- row -->
	    </div>
	    <?php if (ENVIRONMENT == 'development') : ?>
	    <div class="well">
                <pre>
		<?php echo $trace; ?>
                </pre>
	    </div>
	    <?php endif; ?>
        </footer>
    </body>
</html>