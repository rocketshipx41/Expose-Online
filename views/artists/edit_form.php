<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for artist edit page
 */
$this->load->helper('form');
?>
    <div id="edit">
        <?php echo form_open_multipart('artists/edit', array('id' => 'artist-form')); ?>
	<?php echo form_hidden('artist-id', $artist_info['id']); ?>
	<?php echo form_hidden('slug', $artist_info['slug']); ?>
	<?php echo form_hidden('user-id', $user_id); ?>
	<?php echo form_hidden('action', $action); ?>
        <p>
            <label for="display-name"><?php echo lang('artist_field_display_name'); ?></label>
            <?php echo form_input(array('name' => 'display-name', 'id' => 'display-name',
                    'value' => $artist_info['display'], 'class' => 'span_5', 
                    'placeholder' => 'How the artist name should be displayed')); ?>
        </p>
        <p>
            <label for="sort-name"><?php echo lang('artist_field_sort_name'); ?></label>
            <?php echo form_input(array('name' => 'sort-name', 'id' => 'sort-name',
                    'value' => $artist_info['name'], 'class' => 'span_5', 
                    'placeholder' => 'How the artist name should be sorted')); ?>
        </p>
        <p>
            <label for="country"><?php echo lang('artist_field_country'); ?></label>
            <?php echo form_dropdown('country', $country_list, $artist_info['country_id'],
                    'class="span_2" id="country"'); ?>
        </p>
        <p>
            <label for="artist-url"><?php echo lang('artist_field_url'); ?></label>
            <?php echo form_input(array('name' => 'artist-url', 'id' => 'artist-url',
                    'value' => $artist_info['url'], 'class' => 'span_5', 
                    'placeholder' => 'The artist official website')); ?>
        </p>
        <p>
            <label for="artist-image"><?php echo lang('artist_field_image'); ?></label>
            <?php echo form_input(array('name' => 'artist-image', 'id' => 'artist-image',
                    'value' => $artist_info['image_file'], 'class' => 'span_5', 
                    'placeholder' => 'An image')); ?>
        </p>
        <p>
            <label for="info"><?php echo lang('artist_field_info'); ?></label>
            <?php echo form_textarea(array('name' => 'info', 'id' => 'info',
                    'value' => $artist_info['info'], 'class' => 'span_5', 
                    'placeholder' => 'Brief profile', 'rows' => '5')); ?>
        </p>
	<?php echo form_submit('artist-submit', 'Submit', 'class="btn"'); ?>
        <?php echo form_close(); ?>
    </div>
