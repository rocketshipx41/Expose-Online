<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2>Utilities</h2>
	<div id="body">
	    <p>New user</p>
	    <?php echo form_open('util/newuser', array('class' => 'well')); ?>
	    <label class="stacked"><?php echo lang('login_username'); ?></label>
	    <?php echo form_input(array('name' => 'login', 'id' => 'login',
		'value' => '', 'size' => '50', 'placeholder' => 'Type your login name')); ?>
	    <label class="stacked"><?php echo lang('login_email'); ?></label>
	    <?php echo form_input(array('name' => 'email', 'id' => 'email',
		'value' => '', 'size' => '60', 'placeholder' => 'Type your email address')); ?>
	    <label class="stacked"><?php echo lang('user_fullname'); ?></label>
	    <?php echo form_input(array('name' => 'fullname', 'id' => 'fullname',
		'value' => '', 'size' => '60', 'placeholder' => 'Type your full name')); ?>
	    <label class="stacked"><?php echo lang('user_sortname'); ?></label>
	    <?php echo form_input(array('name' => 'sortname', 'id' => 'sortname',
		'value' => '', 'size' => '60', 'placeholder' => 'Full name for sorting')); ?>
	    <br/><br/><?php echo form_submit(array('name' => 'submit', 'id' => 'submit',
		    'value' => lang('user_submit'), 'class' => 'btn primary')); ?>
	    <?php echo form_close(); ?>
	</div>
<p><a href="<?php echo site_url('util/newuser'); ?>">New user</a></p>