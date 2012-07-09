<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
	<div id="body">
	    <p>Welcome to <?php echo $site_name; ?>.</p>
            <div id="myCarousel" class="carousel slide span6">
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

            <div class="row">
                <h2><?php echo lang('home_latest_reviews'); ?></h2>
            </div>
        <?php foreach ($review_list as $item) : ?>
            <div class="row">
            <h3><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></h3>
            <img src="<?php echo image_url($item['image_file']);?>" class="index-art"
                        height="190" width="190" alt="<?php echo lang('article_cover_art_alt'); ?>">
            <?php echo $item['intro']; ?>
        &nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
            </div>
        <?php endforeach; ?>

        <div class="row">
           <h2><?php echo lang('home_latest_features'); ?></h2>
            </div>
        <?php foreach ($feature_list as $item) : ?>
        <div class="row">
            <h3><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></h3>
            <img src="<?php echo image_url('features/'. $item['image_file']);?>" class="index-art"
                        height="190" width="190" alt="<?php echo lang('article_cover_art_alt'); ?>">
            <?php echo $item['intro']; ?>
        &nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
            </div>
        <?php endforeach; ?>
	</div> <!-- body -->
