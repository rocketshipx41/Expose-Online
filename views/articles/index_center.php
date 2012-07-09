<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * template for article index page center section 
 */
?>
<!--<p><?php echo $page_intro; ?></p>-->

<?php foreach ($main_list as $item) : ?>
<div class="row">
    <h3><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></h3>
    <?php if ($item['category_id'] == 1) : ?>
    <img src="<?php echo image_url($item['image_file']);?>" class="index-art"
                 height="190" width="190" alt="<?php echo lang('article_cover_art_alt'); ?>">
    <?php elseif ($item['category_id'] == 5) : // faq ?>
    <?php else : ?>
    <img src="<?php echo image_url('features/'. $item['image_file']);?>" class="index-art"
                 height="190" width="190" alt="<?php echo lang('article_cover_art_alt'); ?>">
    <?php endif; ?>
    <?php echo $item['intro']; ?><br/>
    <em>(<?php echo lang('article_posted') . ' ' 
            //. credit_display($credit_list, 1) . ' '
            . substr($item['updated_on'], 0, 10); ?>)</em>
&nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
</div>
<?php endforeach; ?>

<?php if ($offset != 0) : ?>
&laquo; 
    <?php if ($category_slug) : ?>
<?php echo anchor('articles/index/' . $category_slug . '/' . ($offset - 5),
        lang('article_index_newer')); ?>
    <?php elseif ($topic_slug) : ?>
<?php echo anchor('articles/topic/' . $topic_slug . '/' . ($offset - 5),
        lang('article_index_newer')); ?>
    <?php endif; ?>
&nbsp;|&nbsp; 
        
<?php endif; ?>
<?php if ($category_slug) : ?>
<?php echo anchor('articles/index/' . $category_slug . '/' . ($offset + 5),
        lang('article_index_older')); ?> 
<?php elseif ($topic_slug) : ?>
<?php echo anchor('articles/topic/' . $topic_slug . '/' . ($offset + 5),
        lang('article_index_newer')); ?>
<?php endif; ?>
&raquo;
