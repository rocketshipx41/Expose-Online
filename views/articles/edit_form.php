<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->helper('form');
?>
    <div class="tab-pane" id="edit">
        <?php echo form_open_multipart('articles/edit', array('class' => 'well', 
		'id' => 'article-form')); ?>
	<?php echo form_hidden('article-id', $article_info['id']); ?>
	<?php echo form_hidden('slug', $article_info['slug']); ?>
	<?php echo form_hidden('user-id', $user_id); ?>
	<label><?php echo lang('article_category'); ?></label>
	<?php echo form_dropdown('category', $category_list, 
		$article_info['category_id'], 'id = "category" onChange="changeCategory();"'); ?>
	<label><?php echo lang('article_edit_title'); ?></label>
	<?php echo form_input(array('name' => 'title', 'id' => 'title',
		'value' => $article_info['article_title'], 'class' => 'span5', 
		'placeholder' => 'Title for this article')); ?>
	<label><?php echo lang('article_written_by'); ?></label>
	<?php echo form_multiselect('author[]', $staff_list, array_keys($credit_list[1]),
		'class="chzn-select span5" id="author"'); ?>
	<?php echo form_multiselect('original-author[]', $staff_list, array_keys($credit_list[1]),
		'id="original-author" style="display:none;"'); ?>
	<label class="article-intro"><?php echo lang('article_edit_intro'); ?></label>
	<?php echo form_textarea(array('name' => 'intro', 'id' => 'intro',
		'value' => $article_info['intro'], 'class' => 'span5 article-intro', 
		'placeholder' => 'Introductory paragraph', 'rows' => '5')); ?>
	<label><?php echo lang('article_edit_body'); ?></label>
	<?php echo form_textarea(array('name' => 'body', 'id' => 'body',
		'value' => $article_info['body'], 'class' => 'span5', 
		'placeholder' => 'Article body', 'rows' => '25')); ?>
	<label><?php echo lang('article_artist'); ?></label>
	<?php echo form_multiselect('artist[]', $artist_select_list, array_keys($article_artist_list),
		'class="chzn-select span5" id="artist"'); ?>
	<?php echo form_multiselect('original-artists[]', $artist_select_list, array_keys($article_artist_list),
		'id="original-artists" style="display:none;"'); ?>
	<label><?php echo lang('article_topic'); ?></label>
	<?php echo form_multiselect('topic[]', $topic_select_list, array_keys($article_topic_list),
		'class="chzn-select span5" id="topic"'); ?>
	<?php echo form_multiselect('original-topics[]', $topic_select_list, array_keys($topic_list),
		'id="original-topics" style="display:none;"'); ?>
	<?php echo form_submit('article-submit', 'Submit', 'class="btn"'); ?>
        <?php echo form_close(); ?>
    </div>
