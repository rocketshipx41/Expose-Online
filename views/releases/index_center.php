<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for releases index page center section
 */
?>
<div class="row">
    <div class="span_12">
        <h2><?php echo $template['title']; ?></h2>
    </div>
</div>
<div class="row">
    <div class="span_12">
        <strong><?php echo lang('label_item_count'); ?> : </strong>
            <?php echo count($release_list); ?>
    </div> <!-- column span -->
</div> <!-- row -->
<div class="row">
    <div class="span_12">
<?php if (count($release_list)) : ?>
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
<?php else : ?>
    <p><?php echo lang('release_search_none') . ': "' . $search_value . '"'; ?></p>
<?php endif; ?>
    </div>
</div>