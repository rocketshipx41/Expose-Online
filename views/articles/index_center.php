<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * template for article index page center section 
 */
?>
<div class="row">
    <div class="span_12">
        <h2><?php echo $template['title']; ?></h2>
    </div>
</div>
<?php if ( isset($issue_info) ) : ?>
<div class="row">
    <div class="span_12">
        <strong><?php echo lang('issue_description'); ?> : </strong>
            <?php echo $issue_info['description']; ?><br/>
    <?php if ($issue_info['pages']) : ?>
        <strong><?php echo lang('issue_pages'); ?> : </strong>
            <?php echo $issue_info['pages']; ?><br/>
    <?php endif; ?>
        <strong><?php echo lang('issue_blurb'); ?> : </strong>
            <?php echo $issue_info['blurb']; ?><br/>
        <em><?php echo lang('issue_available');?></em>
    </div> <!-- column span -->
</div> <!-- row -->
<?php endif; ?>
<!--<p><?php echo $page_intro; ?></p>-->

<?php foreach ($main_list as $item) : ?>
<div class="row">
    <div class="span_12">
    <h3><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></h3>
    <?php if ($item['category_id'] == 1) : ?>
    <img src="<?php echo image_url($item['image_file']);?>" class="index-art"
                 height="190" width="190" alt="<?php echo lang('article_cover_art_alt'); ?>">
    <?php elseif (($item['category_id'] == 5) || ($item['category_id'] == 2)) : // faq or news ?>
    <?php elseif ($item['image_file']) : ?>
    <img src="<?php echo image_url('features/'. $item['image_file']);?>" class="index-art"
                 height="190" width="190" alt="<?php echo lang('article_cover_art_alt'); ?>">
    <?php endif; ?>
    <?php echo $item['intro']; ?>
    <?php if ( $item['category_id'] == 8 ): // recommendation ?>
    <?php echo $item['body']; ?>
    <?php else : ?>
    &nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?><br/>
    <?php endif; ?>
    <em>(<?php echo lang('article_posted') . ' ' 
            . credit_display($item['credits'], 1) . ' '
            . substr($item['published_on'], 0, 10); ?>)</em>
    </div> <!-- column span -->
</div> <!-- row -->
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
