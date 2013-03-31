<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
        <div class="container">
            <div class="row">
                <div class="span_12">
                    <div id="myCarousel" class="barousel">
                        <!-- Carousel items -->
                        <div class="barousel_image">
                            <?php foreach ($carousel_list as $item) : ?>
                            <img src="<?php echo image_url('features/' . $item['image_file']);?>" alt="ad" />
                            <?php endforeach; ?>
                        </div> <!-- carousel images -->
                        <div class="barousel_content">
                            <?php foreach ($carousel_list as $item) : ?>
                            <div>
                                <p class="header"><?php echo $item['title']; ?></p>
                                <p>
                                    <?php echo smart_trim($item['intro'], 220); ?>
                                    <?php echo anchor('articles/display/' . $item['slug'], lang('read_more')); ?>

                                </p>
                            </div><!-- caption -->
                            <?php endforeach; ?>
                        </div> <!-- carousel captions -->
                    </div> <!-- carousel -->
                </div> <!-- span -->
            </div>
            <div class="row">
                <div class="span_8">
                    <div class="row">
                        <h2><?php echo lang('home_latest_reviews'); ?></h2>
                    </div>
                <?php foreach ($review_list as $item) : ?>
                    <div class="row">
                        <div class="span_12">
                            <h3><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></h3>
                            <img src="<?php echo image_url($item['image_file']);?>" class="index-art"
                                        height="190" width="190" alt="<?php echo lang('article_cover_art_alt'); ?>">
                            <?php echo $item['intro']; ?>
                        &nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], lang('read_more')); ?>
                        <br/><em>(<?php echo lang('article_posted') . ' ' 
                                . credit_display($item['credits'], 1) . ' '
                                . substr($item['published_on'], 0, 10); ?>)</em>
                        </div>
                    </div> <!-- row -->
                <?php endforeach; ?>
                    <div class="row">
                        <?php echo anchor('articles/index/reviews', lang('more_reviews')); ?>
                    </div>
                    <div class="row">
                        <h2><?php echo lang('home_latest_features'); ?></h2>
                    </div>
                <?php foreach ($feature_list as $item) : ?>
                    <div class="row">
                        <div class="span_12">
                            <h3><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></h3>
                            <img src="<?php echo image_url('features/'. $item['image_file']);?>" class="index-art"
                                        height="190" width="190" alt="<?php echo lang('article_cover_art_alt'); ?>">
                            <?php echo $item['intro']; ?>
                        &nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], lang('read_more')); ?>
                        <br/><em>(<?php echo lang('article_posted') . ' ' 
                                . credit_display($item['credits'], 1) . ' '
                                . substr($item['published_on'], 0, 10); ?>)</em>
                        </div>
                    </div> <!-- row -->
                <?php endforeach; ?>
                    <div class="row">
                        <?php echo anchor('articles/index/features', lang('more_features')); ?>
                    </div>
                </div>
                <div class="span_4">
                    <?php echo $template['partials']['right_column']; ?>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
