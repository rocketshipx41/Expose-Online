<?php
/***************************************************************
 * Date         Author      Purpose
 * 2010.12.29	Jon			duplicate old-style pathnet layout
 * 2011.09.08	Jon			revamp to caper standards
 *
 * $Header: $
***************************************************************/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<title><?php echo $template['title']; ?></title>
	<link href="http://localhost/assets/css/bootstrap.css" rel="stylesheet">
	<link href="http://localhost/assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="http://localhost/assets/css/bootstrap-majipoor.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<script src="http://localhost/assets/js/bootstrap-dropdown.js"></script>
    </head>
    <body>
	<div class="navbar navbar-fixed-top">
	    <div class="navbar-inner">
		<div class="container-fluid">
		    <div class="nav-collapse">
			<ul class="nav">
			    <li <?php if ($menu_active == 'home') echo ' class="active"'; ?>><a href="http://localhost/index.php/jon/">Home</a></li>
			    <li class="divider-vertical"></li>
			    <li<?php if ($menu_active == 'bio') echo ' class="active"'; ?>><a href="http://localhost/index.php/jon/people/biography">Biography</a></li>
			    <li class="divider-vertical"></li>
			    <li<?php if ($menu_active == 'excerpts') echo ' class="active"'; ?>><a href="http://localhost/index.php/jon/works/excerpts">Excerpts</a></li>
			    <li class="divider-vertical"></li>
			    <li id="biblio"<?php if ($menu_active == 'biblio') { echo ' class="active dropdown"'; } else { echo ' class="dropdown"'; } ?>>
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
					    Bibliography
					    <b class="caret"></b>
				    </a>
				    <ul class="dropdown-menu">
					    <li><a href="http://localhost/index.php/jon/works/index">Complete</a></li>
					    <li><a href="http://localhost/index.php/jon/works/index/novels">Novels</a></li>
					    <li><a href="http://localhost/index.php/jon/works/index/short-fiction">Short fiction</a></li>
					    <li><a href="http://localhost/index.php/jon/works/index/nonfiction">Nonfiction</a></li>
					    <li><a href="http://localhost/index.php/jon/works/index/collections">Collections</a></li>
					    <li><a href="http://localhost/index.php/jon/works/index/editing">Editing</a></li>
				    </ul>
			    </li>
			    <li class="divider-vertical"></li>
			    <li<?php if ($menu_active == 'mags') echo ' class="active"'; ?>><a href="http://localhost/index.php/jon/publications/magazines">Magazines</a></li>
			    <li class="divider-vertical"></li>
			    <li<?php if ($menu_active == 'artists') echo ' class="active"'; ?>><a href="http://localhost/index.php/jon/people/index/artists">Artists</a></li>
			    <li class="divider-vertical"></li>
			    <li<?php if ($menu_active == 'pseudo') echo ' class="active"'; ?>><a href="http://localhost/index.php/jon/people/pseudonyms/robert-silverberg">Pseudonyms</a></li>
			    <li class="divider-vertical"></li>
			    <li<?php if ($menu_active == 'majipoor') echo ' class="active"'; ?>>
				<a href="#">Majipoor
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
				    <li><a href="http://localhost/index.php/majipoor/index">Overview</a></li>
				    <li><a href="http://localhost/index.php/majipoor/sources">Sources</a></li>
				    <li><a href="http://localhost/index.php/majipoor/history">History</a></li>
				    <li><a href="http://localhost/index.php/majipoor/government">Government</a></li>
				    <li><a href="http://localhost/index.php/majipoor/technology">Technology</a></li>
				    <li><a href="http://localhost/index.php/majipoor/inhabitants">Inhabitants</a></li>
				    <li><a href="http://localhost/index.php/majipoor/geography">Geography &amp; Geology</a></li>
				    <li><a href="http://localhost/index.php/majipoor/flora-fauna">Flora &amp; Fauna</a></li>
				</ul>
			    </li>
			    <li class="divider-vertical"></li>
			    <li<?php if ($menu_active == 'whatsnew') echo ' class="active"'; ?>><a href="http://localhost/index.php/jon/index/whatsnew">What's new</a></li>
			    <li class="divider-vertical"></li>
			    <li<?php if ($menu_active == 'contact') echo ' class="active"'; ?>><a href="http://localhost/index.php/jon/index/contact">Contact</a></li>							
			</ul>
<!--						<ul class="nav pull-right">
			</ul>-->
		    </div>
		</div>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row-fluid"> <!-- main content -->
		<div class="span2"> <!-- left side column -->
		    <div class="well">
			<form class="form-search">
			    <input type="text" class="input-medium search-query">
			    <button type="submit" class="btn">Search</button>
			</form>
			<h3>Recent updates</h3>
			<?php foreach ($whatsnew_list as $item) : ?>
			<p><em><?php echo $item['date']; ?></em>: <?php echo $item['body']; ?></p>
			<?php endforeach; ?>
			<p><a href="/index/whatsnew">More updates</a></p>
		    </div>
		</div> <!-- left side column -->
		<div class="span8"> <!-- center area -->
		    <div class="hero-unit">
			<p>
			    <img src="http://localhost/assets/img/rslogo.jpg" alt="Robert Silverberg logo by Ken Seamon" />
			    <span class="pull-right site-slogan">The Quasi-Official<br/>Robert Silverberg Site</span>
			</p>
		    </div>
		    <div>
			<h1>Welcome to Majipoor.com</h1>
			<?php echo $template['body']; ?>
		    </div>
		</div> <!-- center area -->
	    </div> <!-- main content -->

	</div> <!-- main container -->

	<footer class="footer">
	    <p><strong>Acknowledgements:</strong> Robert Silverberg for cause, support, and cooperation;
		Ken Seamon for graphics; Rodney Walters for books and info; Alvaro
		Zinos-Amaro for comments and content; and all the fellow fans who have sent
		encouragement, information, and translations.</p>
	    <hr>
	    <p>This <a href="http://www.ringsurf.com/netring?ring=silverberg;action=home">Robert Silverberg Web Ring</a>
		site owned by <a href="mailto:coronal@majipoor.com">Jon Davis.</a></p>
	</footer>
    </body>
</html>