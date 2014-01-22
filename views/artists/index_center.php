<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for artist index page center section
 */
$this->load->helper('form');
?>
<div class="row">
    <?php for ($i = 0; $i < strlen($nav_chars); $i++) : ?>
    <?php echo anchor('artists/index/' . substr($nav_chars, $i, 1), 
            substr($nav_chars, $i, 1), 
            'class="btn small" title="Skip to ' . substr($nav_chars, $i, 1) .'"'); ?>
    <?php endfor; ?>
    <?php echo form_open('artists/search', array('id' => 'artist-search')); ?>
	<label><?php echo lang('artist_search'); ?></label>
	<?php echo form_input(array('name' => 'search-value', 'id' => 'search-value')); ?>
        <?php echo form_submit('artist-submit', 'Submit', 'class="btn"'); ?>
    <?php echo form_close(); ?>
</div> <!-- row -->
<div class="row">
    <div class="span_12">
        <strong><?php echo lang('article_item_count'); ?> : </strong>
            <?php echo $item_count; ?>
    </div> <!-- column span -->
</div> <!-- row -->
<?php if (($starter != '') || (count($artist_list))) : ?>
<div class="row">
<?php if ($starter != '') : ?>
    <span>
        &laquo; 
        <?php echo anchor('artists/index/' . $backlink,
                lang('artist_index_prev')); ?>
    </span>
<?php endif; ?>
    <span class="pull-right">
        <?php echo anchor('artists/index/' . $last_slug . '1',
                lang('artist_index_next')); ?> 
        &raquo;
    </span>
</div> <!-- row -->
<?php endif; ?>
<?php if (count($artist_list)) : ?>
<?php foreach ($artist_list as $item) : ?>
<div class="row">
    <div class="span_5 nomargin">
    <img src="<?php echo image_url($item['image_file']);?>" class="index-art"
                 height="150" width="150" alt="<?php echo lang('article_cover_art_alt'); ?>">
    </div>
    <div class="span_7 nomargin">
    <h3 class="tight"><?php echo anchor('artists/display/' . $item['slug'], $item['display']); ?></h3>
    <span class="smallspan"><ul>
        <li><?php echo lang('artist_field_country') . ': ' . $item['country']; ?></li>
        <li><?php echo lang('artist_field_releases') . ': ' . $item['release_count']; ?></li>
        <li><?php echo lang('artist_field_articles') . ': ' . $item['article_count']; ?></li>
    </ul></span>
    </div>
</div> <!-- row -->
<?php endforeach; ?>
<?php else : ?>
<div class="row">
    <p><?php echo lang('artist_search_none') . ': "' . $search_value . '"'; ?></p>
</div> <!-- row -->
<?php endif; ?>
<?php if (($starter != '') || (count($artist_list))) : ?>
<div class="row">
<?php if ($starter != '') : ?>
    <span>
        &laquo; 
        <?php echo anchor('artists/index/' . $backlink,
                lang('artist_index_prev')); ?>
    </span>
<?php endif; ?>
    <span class="pull-right">
        <?php echo anchor('artists/index/' . $last_slug . '1',
                lang('artist_index_next')); ?> 
        &raquo;
    </span>
</div> <!-- row -->
<?php endif; ?>
<?php if ($can_edit) : ?>
<div class="row">
    <?php echo anchor('artists/add', lang('artist_add'), 'class="btn"'); ?>
</div>
<?php endif; ?>
