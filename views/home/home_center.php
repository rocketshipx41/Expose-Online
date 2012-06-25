<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
	<div id="body">
	    <p>Welcome to <?php echo $site_name; ?>.</p>
                <div id="myCarousel" class="carousel slide">
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <?php foreach ($carousel_list as $item) : ?>
                        <div class="item">
                            <?php echo anchor_img('articles/display/' . $item['slug'],
                                    'features/' . $item['image_file'], '', '', 
                                    array('width' => '500px', 'height' => '350px')); ?>
                            <div class="carousel-caption">
                                <h4><?php echo $item['title']; ?></h4>
                                <p><?php echo smart_trim($item['intro'], 220); ?></p>
                            </div><!-- caption -->
                        </div> <!-- carousel item -->
                        <?php endforeach; ?>
                    </div> <!-- carousel inner -->
                    <!-- Carousel nav -->
                    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
                </div> <!-- carousel -->
	</div>
