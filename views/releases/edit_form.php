<?php

/*
 * release edit form
 */
$this->load->helper('form');
?>
        <?php echo form_open_multipart('releases/edit', array('id' => 'release-form')); ?>
	<?php echo form_hidden('release-id', $release_info['id']); ?>
	<?php echo form_hidden('user-id', $user_id); ?>
	<?php echo form_hidden('action', $action); ?>
	<?php echo form_hidden('artist-slug', $artist_slug); ?>
        <p>
            <label for="display-title"><?php echo lang('release_edit_display_title'); ?></label>
            <?php echo form_input(array('name' => 'display-title', 'id' => 'display-title',
                    'value' => $release_info['display_title'], 'class' => 'span_9', 
                    'placeholder' => 'Title for this release')); ?>
	</p>
        <p>
            <label for="title"><?php echo lang('release_edit_title'); ?></label>
            <?php echo form_input(array('name' => 'title', 'id' => 'title',
                    'value' => $release_info['title'], 'class' => 'span_9', 
                    'placeholder' => 'Title for sorting')); ?>
        </p>
        <p>
            <label for="display-artist"><?php echo lang('release_edit_display_artist'); ?></label>
            <?php echo form_input(array('name' => 'display-artist', 'id' => 'display-artist',
                    'value' => $release_info['display_artist'], 'class' => 'span_9', 
                    'placeholder' => 'Artist for this release')); ?>
	</p>
        <p>
            <label for="artist"><?php echo lang('release_edit_artist'); ?></label>
            <?php echo form_input(array('name' => 'artist', 'id' => 'artist',
                    'value' => $release_info['artist'], 'class' => 'span_9', 
                    'placeholder' => 'Artist for sorting')); ?>
        </p>
        <p>
            <p><?php echo form_checkbox('various-artists', 'va', FALSE) . ' ' 
                    . lang('release_edit_various_artists'); ?></p>
        </p>
        <p>
            <label for="label-id"><?php echo lang('release_edit_label'); ?></label>
            <?php echo form_dropdown('label-id', $label_list, $release_info['label_id'],
                    'id="label-id"'); ?>
        </p>
        <p>
            <label for="catalog-no"><?php echo lang('release_edit_catalog_no'); ?></label>
            <?php echo form_input(array('name' => 'catalog-no', 'id' => 'catalog-no',
                    'value' => $release_info['catalog_no'], 'class' => 'span_2', 
                    'placeholder' => 'Label serial number or other identifier')); ?>
        </p>
        <p>
            <label for="media"><?php echo lang('release_edit_media'); ?></label>
            <?php echo form_input(array('name' => 'media', 'id' => 'media',
                    'value' => $release_info['media'], 'class' => 'span_2', 
                    'placeholder' => 'Media (CD, 2LP, CD+DVD etc.')); ?>
        </p>
        <p>
            <label for="release-type"><?php echo lang('release_edit_type'); ?></label>
            <?php echo form_dropdown('release-type', $release_type_list, 
                    $release_info['release_type_id'], 'id="release-type"'); ?>
        </p>
        <p>
            <label for="year-released"><?php echo lang('release_edit_year_released'); ?></label>
            <?php echo form_input(array('name' => 'year-released', 'id' => 'year-released',
                    'value' => $release_info['year_released'], 'class' => 'span2', 
                    'placeholder' => 'Year releaseed')); ?>
        </p>
        <p>
            <label for="year-recorded"><?php echo lang('release_edit_year_recorded'); ?></label>
            <?php echo form_input(array('name' => 'year-recorded', 'id' => 'year-recorded',
                    'value' => $release_info['year_recorded'], 'class' => 'span2', 
                    'placeholder' => 'Year originally recorded')); ?>
        </p>
        <p>
            <label for="image-file"><?php echo lang('release_edit_image_file'); ?></label>
            <?php echo form_input(array('name' => 'image-file', 'id' => 'image-file',
                    'value' => $release_info['image_file'], 'class' => 'span_9', 
                    'placeholder' => 'File name of cover scan')); ?>
        </p>
        <p>
            <label for="related-artists"><?php echo lang('release_related_artists'); ?></label>
            <?php echo form_multiselect('related-artists[]', $artist_select_list, array_keys($release_artist_list),
                    'class="chzn-select span_5" id="related-artists"'); ?>
            <?php echo form_multiselect('original-artists[]', $artist_select_list, array_keys($release_artist_list),
                    'id="original-artists" style="display:none;"'); ?>
        </p>
        <p>
            <label for="go-to"><?php echo lang('release_go_to'); ?></label>
            <?php echo form_dropdown('go-to', array('artist' => 'Artist page', 
                    'release' => 'Release page'), 'artist', 'id="go-to"'); ?>
        </p>
        <p>
            <?php echo form_submit('release-submit', 'Submit', 'class="btn"'); ?>
        </p>
        <?php echo form_close(); ?>
