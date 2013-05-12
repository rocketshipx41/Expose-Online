<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2><?php echo $release_info['display_artist'] . ' &mdash; ' 
        . $release_info['display_title']; ?></h2>
<img src="<?php echo image_url('releases/'. $release_info['image_file']);?>" 
                 height="400" width="400" alt="<?php echo lang('article_cover_art_alt'); ?>">
<dl>
    <dt><?php echo lang('release_edit_label'); ?></dt>
    <dd><?php echo anchor('labels/display/' . $release_info['label_id'], $release_info['label_name']); ?></dd>
    <dt><?php echo lang('release_edit_catalog_no'); ?></dt>
    <dd><?php echo $release_info['catalog_no']; ?></dd>
    <?php if (($release_info['year_recorded'] > 0) 
            && ($release_info['year_recorded'] != $release_info['year_released'])) : ?>
    <dt><?php echo lang('release_edit_year_recorded'); ?></dt>
    <dd><?php echo $release_info['year_recorded']; ?></dd>
    <?php endif; ?>
    <dt><?php echo lang('release_edit_year_released'); ?></dt>
    <dd><?php echo $release_info['year_released']; ?></dd>
    
</dl>
    <dt><?php echo lang('artist_display_article_list'); ?></dt>
<?php if (count($article_list)) : ?>
    <dd>
        <ul>
        <?php foreach ($article_list as $item) :?>
            <li>
                <?php echo $item['category'] . ': ' . anchor('articles/display/' 
                        . $item['slug'], $item['title']); ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </dd>
<?php else : ?>
    <dd><em><?php echo lang('artist_field_none'); ?></em></dd>
<?php endif; ?>
<p><?php echo lang('article_artist') . ': ' . artist_display($artist_list); ?></p>
    <?php if ($can_edit) : ?>
        <?php echo anchor('releases/edit/'. $release_info['id'], 
                lang('edit'), 'class="btn"'); ?>
        <?php echo anchor('articles/add/1/'. $release_info['id'], 
                lang('release_review'), 'class="btn"'); ?>
    <?php endif; ?>
