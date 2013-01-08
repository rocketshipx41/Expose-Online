<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php if ( count($news_list) ) : ?>
<div class="row">
    <h3><?php echo lang('latest_news'); ?></h3>
</div>
<?php foreach ($news_list as $item) : ?>
<div class="row">
    <div class="span_12">
        <p>
            <strong><?php echo $item['title']; ?></strong> &ndash; 
            <?php echo $item['intro']; ?>&nbsp;&raquo; 
                <?php echo anchor('articles/display/' . $item['slug'], lang('read_more')); ?>
        </p>
    </div>
</div>
<?php endforeach; ?>
<div class="row">
    <?php echo anchor('articles/index/news', lang('more_news')); ?>
    <?php if ($can_edit) : ?>
    &mdash; <?php echo anchor('articles/add/2', lang('add_news')); ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ( count($event_list) ) : ?>
<div class="row">
    <h3><?php echo lang('upcoming_events'); ?></h3>
</div>
<?php foreach ($event_list as $item) : ?>
<div class="row">
    <div class="span_12">
        <p>
            <strong><?php echo $item['title']; ?></strong> &ndash; 
            <?php echo $item['body']; ?>&nbsp;&raquo; 
                <?php echo anchor('articles/display/' . $item['slug'], lang('read_more')); ?>
        </p>
    </div>
</div>
<?php endforeach; ?>
<div class="row">
    <?php echo anchor('articles/index/events', lang('more_events')); ?>
    <?php if ($can_edit) : ?>
    &mdash; <?php echo anchor('articles/add/7', lang('add_event')); ?>
    <?php endif; ?>
</div>
<?php endif; ?>
