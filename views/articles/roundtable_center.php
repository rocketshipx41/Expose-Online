<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$image_file = '';
$year_list =  '';
?>

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
<?php foreach ($related_list as $id => $article) : ?>
    <p><em><?php echo lang('article_written_by') . ' ' . credit_display($article['credit_list'], 1)
        . ', ' . substr($article['published_on'], 0, 10); ?>:</em></p>
    <?php if ($image_file) : ?>
        <?php echo $image_file; $image_file = ''; ?>
    <?php endif; ?>
    <?php echo $article['body']; ?>
    <?php if ($can_edit) : ?>
    <p><?php echo anchor('articles/edit/'. $id, lang('edit'), 'class="btn"'); ?></p>
    <?php endif; ?>
<?php endforeach; ?>
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
    <?php echo auto_link('http://' . $row, 'url', TRUE); ?><br>
<?php endforeach; ?>
</p>
