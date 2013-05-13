<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * listing of all ads
 */
?>
<div class="row">
    <div class="span_12">
        <h2><?php echo $template['title']; ?></h2>
    </div>
</div>
<div class="row">
    <div class="span_12">
        <strong><?php echo lang('label_item_count'); ?> : </strong>
            <?php echo count($ad_list); ?>
    </div> <!-- column span -->
</div> <!-- row -->
<?php if (count($ad_list)) : ?>
<?php foreach ($ad_list as $id => $item) : ?>
<div class="row">
    <div class="span_5 nomargin">
        <img src="<?php echo image_url('ads/'. $item['image_file']);?>" 
                         class="artist-release-art" height="90" width="90" 
                         alt="<?php echo lang('article_cover_art_alt'); ?>">
    </div>
    <div class="span_7 nomargin">
        <p>
            <?php echo anchor('ads/edit/' . $item['id'], $item['title']); ?><br/>
            <?php echo $item['alt']; ?><br/>
            <?php echo $item['position']; ?><br/>
            <?php echo $item['start_date'] . ' - ' . $item['end_date']; ?><br/>
            <?php echo $item['status']; ?><br/>
            <?php echo $item['show_count']; ?>
        </p>
    </div>
</div>
<?php endforeach; ?>
<?php else : ?>
<div class="row">
    <div class="span_12">
        <p><?php echo lang('label_search_none'); ?></p>
    </div>
</div>
<?php endif; ?>
<?php if ($can_edit) : ?>
<div class="row">
    <?php echo anchor('ads/edit/0', lang('ad_add_new'), 'class="btn"'); ?>
</div>
<?php endif; ?>
