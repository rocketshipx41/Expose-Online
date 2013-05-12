<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for artist edit page
 */
$this->load->helper('form');
?>
    <div id="edit">
        <?php echo form_open_multipart('labels/edit', array('id' => 'label-form')); ?>
	<?php echo form_hidden('label-id', $label_info['id']); ?>
	<?php echo form_hidden('user-id', $user_id); ?>
	<?php echo form_hidden('action', $action); ?>
        <p>
            <label for="display-name"><?php echo lang('label_field_display_name'); ?></label>
            <?php echo form_input(array('name' => 'display-name', 'id' => 'display-name',
                    'value' => $label_info['display'], 'class' => 'span_5', 
                    'placeholder' => 'How the label name should be displayed')); ?>
        </p>
        <p>
            <label for="sort-name"><?php echo lang('label_field_sort_name'); ?></label>
            <?php echo form_input(array('name' => 'sort-name', 'id' => 'sort-name',
                    'value' => $label_info['name'], 'class' => 'span_5', 
                    'placeholder' => 'How the label name should be sorted')); ?>
        </p>
        <p>
            <label for="country"><?php echo lang('label_field_country'); ?></label>
            <?php echo form_dropdown('country', $country_list, $label_info['country_id'],
                    'class="span_2" id="country"'); ?>
        </p>
        <p>
            <label for="label-url"><?php echo lang('label_field_url'); ?></label>
            <?php echo form_input(array('name' => 'label-url', 'id' => 'label-url',
                    'value' => $label_info['url'], 'class' => 'span_5', 
                    'placeholder' => 'The label official website')); ?>
        </p>
        <p>
            <label for="label-email"><?php echo lang('label_field_email'); ?></label>
            <?php echo form_input(array('name' => 'label-email', 'id' => 'label-email',
                    'value' => $label_info['email'], 'class' => 'span_5', 
                    'placeholder' => 'The label official email')); ?>
        </p>
        <p>
            <label for="label-address"><?php echo lang('label_field_address'); ?></label>
            <?php echo form_input(array('name' => 'label-address', 'id' => 'label-address',
                    'value' => $label_info['address'], 'class' => 'span_5', 
                    'placeholder' => 'The label mailing address')); ?>
        </p>
        <p>
            <label for="label-phone"><?php echo lang('label_field_phone'); ?></label>
            <?php echo form_input(array('name' => 'label-phone', 'id' => 'label-phone',
                    'value' => $label_info['phone'], 'class' => 'span_5', 
                    'placeholder' => 'The label phone number')); ?>
        </p>
        <p>
            <label for="info"><?php echo lang('label_field_info'); ?></label>
            <?php echo form_textarea(array('name' => 'info', 'id' => 'info',
                    'value' => $label_info['info'], 'class' => 'span_5', 
                    'placeholder' => 'Brief profile', 'rows' => '5')); ?>
        </p>
	<?php echo form_submit('label-submit', 'Submit', 'class="btn primary"'); ?>
        <?php echo form_close(); ?>
    </div>
