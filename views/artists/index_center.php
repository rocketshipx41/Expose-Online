<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for artist index page center section
 */
$this->load->helper('form');
?>

<div class="row">
    &nbsp;|&nbsp;
    <?php for ($i = 0; $i < strlen($nav_chars); $i++) : ?>
    <?php echo anchor('artists/index/' . substr($nav_chars, $i, 1), substr($nav_chars, $i, 1)); ?>&nbsp;|&nbsp;
    <?php endfor; ?>
    <?php echo form_open('artists/search', array('id' => 'artist-search')); ?>
	<label><?php echo lang('artist_search'); ?></label>
	<?php echo form_input(array('name' => 'search-value', 'id' => 'search-value')); ?>
        <?php echo form_submit('artist-submit', 'Submit', 'class="btn"'); ?>
    <?php echo form_close(); ?></div>

<?php foreach ($artist_list as $item) : ?>
<div class="row">
    <img src="<?php echo image_url($item['image_file']);?>" class="index-art"
                 height="150" width="150" alt="<?php echo lang('article_cover_art_alt'); ?>">
    <h3><?php echo anchor('artists/display/' . $item['slug'], $item['display']); ?></h3>
    <p><?php echo lang('artist_field_country') . ': ' . $item['country_id']; ?></p>
    <?php $last_slug = $item['slug']; ?>
</div>
<?php endforeach; ?>

<?php if ($starter != '') : ?>
&laquo; 
<?php echo anchor('artists/index/' . $backlink,
        lang('artist_index_prev')); ?>
&nbsp;|&nbsp;         
<?php endif; ?>
<?php echo anchor('artists/index/' . $last_slug . '1',
        lang('artist_index_next')); ?> 
&raquo;
