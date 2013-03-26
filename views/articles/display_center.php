<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$image_file = '';
$year_list =  '';
?>

<?php if (($article_info['category_id'] != 1)&& ($article_info['category_id'] != 4)) : ?>
<h2><?php echo $article_info['article_title']; ?></h2>
<?php endif; ?>
<?php if ($article_info['category_id'] == 1) : ?>
    <?php if (count($release_list)) : ?>
        <?php foreach ($release_list as $release) : ?>
<p><strong><?php echo $release['display_artist'] . ' &mdash; ' . $release['display_title']; ?></strong><br/>
<em><?php echo release_line($release); ?></em><p>
            <?php if ($release['image_file']) : ?>
                <?php $image_file .= '<img src="' . image_url('releases/'. $release['image_file'])
                        . '" class="review-art" height="250" width="250" alt="' 
                        . lang('article_cover_art_alt') . '" title="'
                        .  $release['display_title']. '"/>'; ?>
            <?php endif; ?>
            <?php $year_list .= ', ' . anchor('articles/releases/' . $release['year_released'],
                $release['year_released'] . ' ' . lang('article_release_year_topic')); ?>
            <?php if ( $release['year_released'] != $release['year_recorded']) : ?>
                <?php $year_list .= ', ' . anchor('articles/releases/' . $release['year_recorded'],
                    $release['year_recorded'] . ' ' . lang('article_release_year_topic')); ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php elseif ($article_info['category_id'] == 4) : ?>
<div class="feature-top-photo">
    <img src="<?php echo image_url('features/' . $article_info['image_file']);?>" 
         alt="feature photo" width="680" />
    <h2 class="feature-title"><span><?php echo $article_info['article_title']; ?></span></h2>
</div>
<?php endif; ?>
<p><?php echo $article_info['intro']; ?></p>
<?php if ( $show_columns == 2 ) : ?>
<div class="row">
    <fb:like send="true" width="500" show_faces="true" />
</div>
<?php endif; ?>
<p><em><?php echo lang('article_written_by') . ' ' . credit_display($credit_list, 1); ?> </em></p>
<?php if ($meta['has_photographer']) : ?>
<p><em><?php echo lang('article_photo_by') . ' ' . credit_display($credit_list, 2); ?></em></p>
<?php endif; ?>
<?php if ($meta['has_illustrator']) : ?>
<p><em><?php echo lang('article_illustrated_by') . ' ' . credit_display($credit_list, 3); ?></em></p>
<?php endif; ?>
<?php if ($image_file) : ?>
    <?php echo $image_file; ?>
<?php endif; ?>
<?php echo $article_info['body']; ?>
<p><em>(<?php echo lang('article_published') . ' ' . substr($article_info['published_on'], 0, 10); ?>)</em></p>

<p>
    <?php echo lang('article_topic') . ': ' . topic_display($topic_list, TRUE); ?>
    <?php if ( $article_info['issue_no'] ) : ?>
        <?php echo ', ' . anchor('articles/issue/' . $article_info['issue_no'],
                lang('issue_no') . ' ' . $article_info['issue_no']); ?>
    <?php endif; ?>
    <?php echo $year_list; ?>
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
