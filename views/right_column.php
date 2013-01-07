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
        <div class="row">
            <h3><?php echo lang('latest_recommendations'); ?></h3>
        </div>
        <?php foreach ($recommendation_list as $item) : ?>
        <div class="row">
            <div class="span_12">
                <?php echo $item['body']; ?>
            </div>
        </div>
        <?php endforeach; ?>
