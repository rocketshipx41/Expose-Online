<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for artist display page
 */
?>

<div class="row">
<h2><?php echo $artist_info['display']; ?></h2>
<?php if ($artist_info['image_file']): ?>
    <img src="<?php echo image_url('artists/'. $artist_info['image_file']);?>" class="artist-art"
            height="350" width="450" alt="<?php echo lang('article_cover_art_alt'); ?>">
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
    <dd><?php echo auto_link('http://' . $artist_info['url'], 'url'); ?></dd>
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
        <table>
        <?php foreach ($release_list as $item) : ?>
            <tr>
                <td><img src="<?php echo image_url('releases/'. $item['image_file']);?>" class="artist-release-art"
                 height="90" width="90" alt="<?php echo lang('article_cover_art_alt'); ?>"></td>
                <td>
                <?php echo anchor('releases/display/'. $item['release_id'], $item['display_artist'] . ' &mdash; ' . $item['display_title'])
                        . '&nbsp;' . release_line($item); ?>
                </td>
            <?php if ($can_edit) : ?>
                <td><?php echo anchor('releases/edit/'. $item['release_id']
                        .'/' . $artist_info['slug'], lang('edit'), 'class="btn"'); ?></td>
            <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </table>
    </dd>
<?php else : ?>
    <dd><em><?php echo lang('artist_field_none'); ?></em></dd>
<?php endif; ?>
</dl>
</div> <!-- row -->
    <?php if ($can_edit) : ?>
    <?php echo anchor('artists/edit/'. $artist_info['slug'], lang('edit'), 'class="btn"'); ?>
    <?php echo anchor('releases/add/'. $artist_info['id'] . '/'
            . $artist_info['slug'], lang('add_release'), 'class="btn"'); ?>
    <?php endif; ?>
