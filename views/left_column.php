<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h3><?php echo lang('latest_news'); ?></h3>
<?php foreach ($news_list as $item) : ?>
<div class="row">
    <p>
        <strong><?php echo $item['title']; ?></strong> &ndash; 
        <?php echo $item['intro']; ?>&nbsp;&raquo; 
            <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
    </p>
</div>
<?php endforeach; ?>
