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
        <?php if ($article_info['category_id'] != 1) : ?>
	<p><?php echo $article_info['intro']; ?></p>
        <?php else: // review ?>
            <?php if (count($release_list)) : ?>
                <?php foreach ($release_list as $release) : ?>
        <h3><?php echo $release['display_artist'] . ' &mdash; ' . $release['display_title']; ?></h3>
        <em><?php echo release_line($release); ?></em><br/>
                    <?php if ($release['image_file']) : ?>
                        <?php $image_file = $release['image_file']; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
	<p><?php echo lang('article_written_by') . ' ' 
		. credit_display($credit_list, 1); ?> </p>
        <?php if ($image_file): ?>
            <img src="<?php echo image_url('releases/'. $image_file);?>" class="review-art"
                 height="160" width="160" alt="<?php echo lang('article_cover_art_alt'); ?>">
        <?php endif; ?>
	<?php echo $article_info['body']; ?>

	<p><?php echo lang('article_topic') . ': ' . topic_display($article_topic_list); ?></p>
	<p><?php echo lang('article_artist') . ': ' . artist_display($article_artist_list); ?></p>
    </div>
    <div class="tab-pane" id="comments">
	(comments)
	<pre>
	User ID: <?php echo $user_id; ?>
	User group ID: <?php echo $user_group_id; ?>
	Article ID: <?php echo $article_info['id']; ?>
	Credits: <?php print_r($credit_list); ?>
	Staff: <?php //print_r($staff_list); ?>
        Releases: <?php print_r($release_list); ?>
	Article: <?php print_r($article_info); ?>
	<?php //echo $debug; ?>
	</pre>
    </div>
    <?php if ($can_edit) : // admin ?>
	<?php echo $template['partials']['edit_form']; ?>
    <?php endif; ?>
</div>
