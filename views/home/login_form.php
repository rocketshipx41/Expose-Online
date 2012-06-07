<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->helper('form');
?>

	<div id="body">
	    <p><?php echo lang('login_instruction'); ?></p>
	    <?php echo form_open('welcome/login', array('class' => 'well')); ?>
	    <label><?php echo lang('login_username'); ?></label>
	    <?php echo form_input(array('name' => 'login', 'id' => 'login',
		'value' => '', 'class' => 'span3', 'placeholder' => 'Type your login name')); ?>
	    <label><?php echo lang('login_password'); ?></label>
	    <?php echo form_password(array('name' => 'password', 'id' => 'password', 
		    'class' => 'span3')); ?>
	    <?php echo form_submit(array('name' => 'submit', 'id' => 'submit',
		    'value' => lang('login_submit'), 'class' => 'btn')); ?>
	    <?php echo form_close(); ?>
	</div>
