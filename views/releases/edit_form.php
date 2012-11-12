<?php

/*
 * release edit form
 */
$this->load->helper('form');
?>
        <?php echo form_open_multipart('releases/edit', array('class' => 'well', 
		'id' => 'release-form')); ?>
	<?php echo form_hidden('release-id', $release_info['id']); ?>
	<?php echo form_hidden('user-id', $user_id); ?>
	<?php echo form_hidden('action', $action); ?>
	<?php echo form_hidden('artist-slug', $artist_slug); ?>

        <label><?php echo lang('release_edit_display_title'); ?></label>
	<?php echo form_input(array('name' => 'display-title', 'id' => 'display-title',
		'value' => $release_info['display_title'], 'class' => 'span5', 
		'placeholder' => 'Title for this release')); ?>
	
        <label><?php echo lang('release_edit_title'); ?></label>
	<?php echo form_input(array('name' => 'title', 'id' => 'title',
		'value' => $release_info['title'], 'class' => 'span5', 
		'placeholder' => 'Title for sorting')); ?>
	
        <label><?php echo lang('release_edit_display_artist'); ?></label>
	<?php echo form_input(array('name' => 'display-artist', 'id' => 'display-artist',
		'value' => $release_info['display_artist'], 'class' => 'span5', 
		'placeholder' => 'Artist for this release')); ?>
	
        <label><?php echo lang('release_edit_artist'); ?></label>
	<?php echo form_input(array('name' => 'artist', 'id' => 'artist',
		'value' => $release_info['artist'], 'class' => 'span5', 
		'placeholder' => 'Artist for sorting')); ?>
        
	<p><?php echo form_checkbox('various-artists', 'va', FALSE) . ' ' 
                . lang('release_edit_various_artists'); ?></p>
        
	<label><?php echo lang('release_edit_label'); ?></label>
	<?php echo form_dropdown('label-id', $label_list, $release_info['label_id'],
		'id="label-id"'); ?>

        <label><?php echo lang('release_edit_catalog_no'); ?></label>
	<?php echo form_input(array('name' => 'catalog-no', 'id' => 'catalog-no',
		'value' => $release_info['catalog_no'], 'class' => 'span2', 
		'placeholder' => 'Label serial number or other identifier')); ?>

        <label><?php echo lang('release_edit_media'); ?></label>
	<?php echo form_input(array('name' => 'media', 'id' => 'media',
		'value' => $release_info['media'], 'class' => 'span2', 
		'placeholder' => 'Media (CD, 2LP, CD+DVD etc.')); ?>

	<label><?php echo lang('release_edit_type'); ?></label>
	<?php echo form_dropdown('release-type', $release_type_list, 
                $release_info['release_type_id'], 'id="release-type"'); ?>

        <label><?php echo lang('release_edit_year_released'); ?></label>
	<?php echo form_input(array('name' => 'year-released', 'id' => 'year-released',
		'value' => $release_info['year_released'], 'class' => 'span2', 
		'placeholder' => 'Year releaseed')); ?>

        <label><?php echo lang('release_edit_year_recorded'); ?></label>
	<?php echo form_input(array('name' => 'year-recorded', 'id' => 'year-recorded',
		'value' => $release_info['year_recorded'], 'class' => 'span2', 
		'placeholder' => 'Year originally recorded')); ?>

        <label><?php echo lang('release_edit_image_file'); ?></label>
	<?php echo form_input(array('name' => 'image-file', 'id' => 'image-file',
		'value' => $release_info['image_file'], 'class' => 'span5', 
		'placeholder' => 'File name of cover scan')); ?>

	<label><?php echo lang('release_related_artists'); ?></label>
	<?php echo form_multiselect('related-artists[]', $artist_select_list, array_keys($release_artist_list),
		'class="chzn-select span5" id="related-artists"'); ?>
	<?php echo form_multiselect('original-artists[]', $artist_select_list, array_keys($release_artist_list),
		'id="original-artists" style="display:none;"'); ?>
        
        <label><?php echo lang('release_go_to'); ?></label>
	<?php echo form_dropdown('go-to', array('artist' => 'Artist page', 
                'release' => 'Release page'), 'artist', 'id="go-to"'); ?>

        <br/><?php echo form_submit('release-submit', 'Submit', 'class="btn"'); ?>
        <?php echo form_close(); ?>
