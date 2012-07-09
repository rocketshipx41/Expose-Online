<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for artist display page
 */
?>
<h2><?php echo $artist_info['display']; ?></h2>

<?php if ($artist_info['image_file']): ?>
    <img src="<?php echo image_url('artists/'. $artist_info['image_file']);?>" class="artist-art"
            height="350" width="500" alt="<?php echo lang('article_cover_art_alt'); ?>">
<?php endif; ?>
<dl>
    <dt><?php echo lang('artist_field_country'); ?></dt>
    <dd><?php echo $artist_info['country_name']; ?></dd>
    <dt><?php echo lang('artist_field_info'); ?></dt>
<?php if ($artist_info['info']): ?>
    <dd><?php echo $artist_info['info']; ?></dd>
<?php else : ?>
    <dd><em><?php echo lang('artist_field_none'); ?></em></dd>
<?php endif; ?>
    <dt><?php echo lang('artist_field_url'); ?></dt>
<?php if ($artist_info['url']): ?>
    <dd><?php echo auto_link($artist_info['url']); ?></dd>
<?php else : ?>
    <dd><em><?php echo lang('artist_field_none'); ?></em></dd>
<?php endif; ?>
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
    <dt><?php echo lang('artist_display_release_list'); ?></dt>
<?php if (count($release_list)) : ?>
    <dd>
        <ul>
        <?php foreach ($release_list as $item) :?>
            <li>
                <?php echo $item['display_artist'] . ' &mdash; ' . $item['display_title']
                        . '&nbsp;' . release_line($item); ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </dd>
<?php else : ?>
    <dd><em><?php echo lang('artist_field_none'); ?></em></dd>
<?php endif; ?>
</dl>
    
    <?php if ($can_edit) : ?>
    <?php echo anchor('artists/edit/'. $artist_info['slug'], lang('edit'), 'class="btn"'); ?>
    <?php endif; ?>
    