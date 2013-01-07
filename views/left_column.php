<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <h3><?php echo lang('latest_news'); ?></h3>
</div>
<?php foreach ($news_list as $item) : ?>
<div class="row">
    <div class="span_12">
        <p>
            <strong><?php echo $item['title']; ?></strong> &ndash; 
            <?php echo $item['intro']; ?>&nbsp;&raquo; 
                <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
        </p>
    </div>
</div>
<?php endforeach; ?>
<div class="row">
    <h3><?php echo lang('upcoming_events'); ?></h3>
</div>
<?php foreach ($event_list as $item) : ?>
<div class="row">
    <div class="span_12">
        <p>
            <strong><?php echo $item['title']; ?></strong> &ndash; 
            <?php echo $item['body']; ?>&nbsp;&raquo; 
                <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
        </p>
    </div>
</div>
<?php endforeach; ?>
