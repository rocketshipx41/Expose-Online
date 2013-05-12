<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2><?php echo $label_info['display']; ?></h2>
<dl>
    <dt><?php echo lang('label_name'); ?></dt>
    <dd><?php echo $label_info['name']; ?></dd>
    <dt><?php echo lang('label_url'); ?></dt>
    <dd><?php echo auto_link('http://' . $label_info['url'], 'url', TRUE); ?></dd>
    <dt><?php echo lang('label_field_email'); ?></dt>
    <dd><?php echo $label_info['email']; ?></dd>
    <dt><?php echo lang('label_field_phone'); ?></dt>
    <dd><?php echo $label_info['phone']; ?></dd>
    <dt><?php echo lang('label_field_address'); ?></dt>
    <dd><?php echo $label_info['address']; ?></dd>
    <dt><?php echo lang('label_field_info'); ?></dt>
    <dd><?php echo $label_info['info']; ?></dd>
    <dt><?php echo lang('label_releases'); ?></dt>
<?php if (count($release_list)) : ?>
    <dd>
        <table>
        <?php foreach ($release_list as $item) : ?>
            <tr>
                <td>
                    <img src="<?php echo image_url('releases/'. $item['image_file']);?>" 
                         class="artist-release-art" height="90" width="90" 
                         alt="<?php echo lang('article_cover_art_alt'); ?>">
                </td>
                <td>
                <?php echo anchor('releases/display/'. $item['release_id'], 
                        $item['display_artist'] . ' &mdash; ' . $item['display_title'])
                        . '&nbsp;' . release_line($item); ?>
                </td>
            <?php if ($can_edit) : ?>
                <td>
                    <?php echo anchor('releases/edit/'. $item['release_id'], 
                            lang('edit'), 'class="btn"'); ?><br/>
                    <?php echo anchor('articles/add/1/'. $item['release_id'], 
                            lang('artist_review_release'), 'class="btn"'); ?>
                </td>
            <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </table>
    </dd>
<?php else : ?>
    <dd><em><?php echo lang('artist_field_none'); ?></em></dd>
<?php endif; ?>
</dl>
<?php if ($can_contribute) : ?>
    <?php echo anchor('labels/edit/'. $label_info['id'], lang('edit'), 'class="btn"'); ?>
<?php endif; ?>
