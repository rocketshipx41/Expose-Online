<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php if ($article_info['category_id'] != 1) : ?>
<h2><?php echo $article_info['article_title']; ?></h2>
<?php endif; ?>
<p><?php echo $article_info['intro']; ?></p>
<?php if ($article_info['category_id'] == 1) : ?>
    <?php if (count($release_list)) : ?>
        <?php foreach ($release_list as $release) : ?>
<p><strong><?php echo $release['display_artist'] . ' &mdash; ' . $release['display_title']; ?></strong><br/>
<em><?php echo release_line($release); ?></em><p>
            <?php if ($release['image_file']) : ?>
                <?php $image_file = $release['image_file']; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
<p><?php echo lang('article_written_by') . ' ' . credit_display($credit_list, 1); ?> </p>
<?php if ($meta['has_photographer']) : ?>
<p><?php echo lang('article_photo_by') . ' ' . credit_display($credit_list, 2); ?> </p>
<?php endif; ?>
<?php if ($meta['has_illustrator']) : ?>
<p><?php echo lang('article_illustrated_by') . ' ' . credit_display($credit_list, 3); ?> </p>
<?php endif; ?>
<?php if ($image_file): ?>
    <img src="<?php echo image_url('releases/'. $image_file);?>" class="review-art"
            height="200" width="200" alt="<?php echo lang('article_cover_art_alt'); ?>">
<?php endif; ?>
<?php echo $article_info['body']; ?>

<p>
    <?php echo lang('article_topic') . ': ' . topic_display($topic_list, TRUE); ?>
    <?php if ( $article_info['issue_no'] ) : ?>
        <?php echo ', ' . anchor('articles/issue/' . $article_info['issue_no'],
                lang('issue_no') . ' ' . $article_info['issue_no']); ?>
    <?php endif; ?>
</p>
<p><?php echo lang('article_artist') . ': ' . artist_display($artist_list); ?></p>
<p><?php echo lang('article_links'); ?><br>
<?php foreach ($link_list as $row): ?>
    <?php echo auto_link($row); ?><br>
<?php endforeach; ?>
</p>
<?php if ($can_edit) : ?>
<?php echo anchor('articles/edit/'. $article_info['id'], lang('edit'), 'class="btn"'); ?>
<?php endif; ?>
