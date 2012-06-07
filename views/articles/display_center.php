<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<h2><?php echo $article_info['article_title']; ?></h2>

<ul class="nav nav-tabs">
    <li><a href="#main" data-toggle="tab" class="active"><?php echo $article_info['item_name']; ?></a></li>
    <li><a href="#comments" data-toggle="tab"><?php echo lang('comments'); ?></a></li>
    <?php if ($can_edit) : // admin ?>
    <li><a href="#edit" data-toggle="tab"><?php echo lang('edit'); ?></a></li>
    <?php endif; ?>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="main">
	<p><?php echo $article_info['intro']; ?></p>
	<p><?php echo lang('article_written_by') . ' ' 
		. credit_display($credit_list, 1); ?> </p>
	<?php echo $article_info['body']; ?>

	<p>Filed under: <?php echo topic_display($topic_list); ?></p>
    </div>
    <div class="tab-pane" id="comments">
	(comments)
	<pre>
	User ID: <?php echo $user_id; ?>
	User group ID: <?php echo $user_group_id; ?>
	Article ID: <?php echo $article_info['id']; ?>
	Credits: <?php print_r($credit_list); ?>
	Staff: <?php print_r($staff_list); ?>
	Article: <?php print_r($article_info); ?>
	<?php echo $debug; ?>
	</pre>
    </div>
    <?php if ($can_edit) : // admin ?>
	<?php echo $template['partials']['edit_form']; ?>
    <?php endif; ?>
</div>
