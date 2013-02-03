<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
        <div class="row">
            <img src="http://localhost/assets/img/ads/fake-ad-200x300.png" 
                alt="ad" class="column-ad" />
        </div>
<?php if ( count($recommendation_list) ) : ?>
        <div class="row">
            <h3><?php echo lang('latest_recommendations'); ?></h3>
        </div>
        <?php foreach ($recommendation_list as $item) : ?>
        <div class="row">
            <div class="span_12">
                <p><strong><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></strong></p>
                <?php echo $item['body']; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="row">
            <?php echo anchor('articles/index/recommendations', lang('more_recommendations')); ?>
            <?php if ($can_edit) : ?>
            &mdash; <?php echo anchor('articles/add/8', lang('add_recommendation')); ?>
            <?php endif; ?>
        </div>
<?php endif; ?>