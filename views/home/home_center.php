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
                                    <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>

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
                        &nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
                        </div>
                    </div> <!-- row -->
                <?php endforeach; ?>
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
                        &nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
                        </div>
                    </div> <!-- row -->
                <?php endforeach; ?>
                </div>
                <div class="span_4">
                    <div class="row">
                        <img src="http://localhost/assets/img/ads/fake-ad-200x300.png" 
                            alt="ad" class="column-ad" />
                    </div>
                    <div class="row">
                        <h3>Something goes here</h3>
                        <p>Progressive rock, also known as prog rock, prog-rock or simply prog, is a rock music subgenre[2] which originated in the United Kingdom, with further developments in Germany, Italy and France, throughout the mid to late 1960s and 1970s. Developing from psychedelic rock, progressive rock originated, similarly to art rock, as a British attempt to give greater artistic weight and credibility to rock music.[3] Progressive rock intended to break the boundaries of traditional rock music by bringing in a greater and more eclectic range of influences, including free-form and experimental compositional methods, as well as new technological innovations.</p>
                    </div>
                    <div class="row">
                        <h3>Something else goes here</h3>
                        <p>Progressive rock saw a high level of popularity throughout the 1970s, especially in the middle of the decade, with bands such as Pink Floyd, King Crimson, Yes, Supertramp, Jethro Tull, Genesis, Emerson, Lake & Palmer, The Moody Blues, Camel, Gentle Giant and Van der Graaf Generator. It started to fade in popularity by the latter part of the decade, with the rawer and more minimalistic punk rock growing in popularity,[4] and also with the rise of genres such as disco, funk, hard rock/roots rock, and the gradual emergence of hip-hop. Nevertheless, progressive rock bands were able to achieve commercial success well into the 1980s. By the turn of the 21st century, it witnessed a revival, often known as new prog, and has, ever since, enjoyed a cult following. The genre has influenced several other styles, ranging from krautrock to neo-classical metal; it has also fused with several other forms of rock music to create subgenres, including progressive metal.</p>
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
