<!--<p><?php echo $page_intro; ?></p>-->

<?php foreach ($main_list as $item) : ?>
<div class="row">
    <h3><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></h3>
    <?php if ($item['category_id'] == 1) : ?>
    <img src="<?php echo image_url('releases/'. $item['image_file']);?>" class="index-art"
                 height="90" width="90" alt="<?php echo lang('article_cover_art_alt'); ?>">
    <?php else : ?>
    <img src="<?php echo image_url('features/'. $item['image_file']);?>" class="index-art"
                 height="90" width="90" alt="<?php echo lang('article_cover_art_alt'); ?>">
    <?php endif; ?>
    <?php echo $item['intro']; ?>
&nbsp;&raquo; <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?>
</div>
<?php endforeach; ?>

<?php if ($offset != 0) : ?>
&laquo; <?php echo anchor('articles/index/' . $category_slug . '/' . ($offset - 5),
        lang('article_index_newer')); ?>&nbsp;|&nbsp; 
<?php endif; ?>
<?php echo anchor('articles/index/' . $category_slug . '/' . ($offset + 5),
        lang('article_index_older')); ?> &raquo;
