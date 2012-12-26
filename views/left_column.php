<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div class="span3">
        <h3><?php echo lang('latest_news'); ?></h3>
    </div>
</div>
<?php foreach ($news_list as $item) : ?>
<div class="row">
    <div class="span3">
        <p>
            <strong><?php echo $item['title']; ?></strong> &ndash; 
            <?php echo $item['intro']; ?>&nbsp;&raquo; 
                <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
        </p>
    </div>
</div>
<?php endforeach; ?>
