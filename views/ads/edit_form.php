<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for artist edit page
 */
$this->load->helper('form');
$position_list = array('top' => 'Top banner', 'side' => 'Side column');
$status_list = array('draft' => 'Draft', 'live' => 'Live');
?>
    <div id="edit">
        <?php echo form_open_multipart('ads/edit', array('id' => 'ad-form')); ?>
	<?php echo form_hidden('ad-id', $ad_info['id']); ?>
	<?php echo form_hidden('user-id', $user_id); ?>
	<?php echo form_hidden('action', $action); ?>
        <p>
            <label for="ad-title"><?php echo lang('ad_field_title'); ?></label>
            <?php echo form_input(array('name' => 'ad-title', 'id' => 'ad-title',
                    'value' => $ad_info['title'], 'class' => 'span_5', 
                    'placeholder' => 'Ad title (hover text)')); ?>
        </p>
        <p>
            <label for="ad-alt"><?php echo lang('ad_field_alt'); ?></label>
            <?php echo form_input(array('name' => 'ad-alt', 'id' => 'ad-alt',
                    'value' => $ad_info['alt'], 'class' => 'span_5', 
                    'placeholder' => 'Ad alt text (no image)')); ?>
        </p>
        <p>
            <label for="ad-url"><?php echo lang('ad_field_url'); ?></label>
            <?php echo form_input(array('name' => 'ad-url', 'id' => 'ad-url',
                    'value' => $ad_info['url'], 'class' => 'span_5', 
                    'placeholder' => 'URL for ad click')); ?>
        </p>
        <p>
            <label for="ad-image"><?php echo lang('ad_field_image'); ?></label>
            <?php echo form_input(array('name' => 'ad-image', 'id' => 'ad-image',
                    'value' => $ad_info['image_file'], 'class' => 'span_5', 
                    'placeholder' => 'Image file name')); ?>
        </p>
        <p>
            <label for="position"><?php echo lang('ad_field_position'); ?></label>
            <?php echo form_dropdown('position', $position_list, $ad_info['position'],
                    'class="span_2" id="position"'); ?>
        </p>
        <p>
            <label for="status"><?php echo lang('ad_field_status'); ?></label>
            <?php echo form_dropdown('status', $status_list, $ad_info['status'],
                    'class="span_2" id="status"'); ?>
        </p>
        <p>
            <label for="ad-email"><?php echo lang('ad_field_email'); ?></label>
            <?php echo form_input(array('name' => 'ad-email', 'id' => 'ad-email',
                    'value' => $ad_info['contact_email'], 'class' => 'span_5', 
                    'placeholder' => 'Contact email for purchaser')); ?>
        </p>
        <p>
            <label for="start-date"><?php echo lang('ad_field_start_date'); ?></label>
            <?php echo form_input(array('name' => 'start-date', 'id' => 'start-date',
                    'value' => $ad_info['start_date'], 'class' => 'span_3 datepicker', 
                    'placeholder' => 'Ad start date')); ?>
        </p>
        <p>
            <label for="end-date"><?php echo lang('ad_field_start_date'); ?></label>
            <?php echo form_input(array('name' => 'end-date', 'id' => 'end-date',
                    'value' => $ad_info['end_date'], 'class' => 'span_3 datepicker', 
                    'placeholder' => 'Ad end date')); ?>
        </p>
        <p>
            <?php echo form_checkbox('ad-paid', 'paid', ($ad_info['paid'])) 
                    . ' ' . lang('ad_field_paid'); ?>
        </p>
 	<?php echo form_submit('ad-submit', 'Submit', 'class="btn primary"'); ?>
        <?php echo form_close(); ?>
    </div>
