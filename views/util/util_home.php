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
	    <label><?php echo lang('login_username'); ?></label>
	    <?php echo form_input(array('name' => 'login', 'id' => 'login',
		'value' => '', 'class' => 'span3', 'placeholder' => 'Type your login name')); ?>
	    <label><?php echo lang('login_email'); ?></label>
	    <?php echo form_input(array('name' => 'email', 'id' => 'email',
		'value' => '', 'class' => 'span3', 'placeholder' => 'Type your email address')); ?>
	    <?php echo form_submit(array('name' => 'submit', 'id' => 'submit',
		    'value' => lang('user_submit'), 'class' => 'btn')); ?>
	    <?php echo form_close(); ?>
	</div>
<p><a href="<?php echo site_url('util/newuser'); ?>">New user</a></p>