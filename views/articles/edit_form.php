<?php
/*
 * template for article edit page
 */
$this->load->helper('form');
?>
    <div id="edit" >
        <?php echo form_open_multipart('articles/edit', array('id' => 'article-form')); ?>
	<?php echo form_hidden('article-id', $article_info['id']); ?>
	<?php echo form_hidden('slug', $article_info['slug']); ?>
	<?php echo form_hidden('user-id', $user_id); ?>
	<?php echo form_hidden('action', $action); ?>
	<?php echo form_hidden('original-issue', $article_info['issue_no']); ?>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_category'); ?></label>
                <?php echo form_dropdown('category', $category_list, $article_info['category_id'], 
                        'class="span_9" id = "category" onChange="changeCategory();"'); ?>
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_edit_title'); ?></label>
                <?php echo form_input(array('name' => 'title', 'id' => 'title',
                        'value' => $article_info['article_title'], 'class' => 'span_9', 
                        'placeholder' => 'Title for this article')); ?>
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_written_by'); ?></label>
                <?php echo form_multiselect('author[]', $staff_list, array_keys($credit_list[1]),
                        'class="chzn-select span_9" id="author"'); ?>
                <?php echo form_multiselect('original-author[]', $staff_list, array_keys($credit_list[1]),
                        'id="original-author" style="display:none;"'); ?>
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="article-intro stacked"><?php echo lang('article_edit_intro'); ?></label>
                <?php echo form_textarea(array('name' => 'intro', 'id' => 'intro',
                        'value' => $article_info['intro'], 'class' => 'span_9 article-intro', 
                        'placeholder' => 'Introductory paragraph', 'rows' => '5')); ?>
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_edit_body'); ?></label>
                <?php echo form_textarea(array('name' => 'article-body', 'id' => 'article-body',
                        'value' => $article_info['body'], 'class' => 'span_9 rich-editor', 
                        'placeholder' => 'Article body', 'rows' => '25')); ?>
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_artist'); ?></label>
                <?php echo form_multiselect('artist[]', $artist_select_list, array_keys($artist_list),
                        'class="chzn-select span_9" id="artist"'); ?>
                <?php echo form_multiselect('original-artists[]', $artist_select_list, array_keys($artist_list),
                        'id="original-artists" style="display:none;"'); ?>
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_topic'); ?></label>
                <?php echo form_multiselect('topic[]', $topic_select_list, array_keys($topic_list),
                        'class="chzn-select span_9" id="topic"'); ?>
                <?php echo form_multiselect('original-topics[]', $topic_select_list, array_keys($topic_list),
                        'id="original-topics" style="display:none;"'); ?>
            </div>
        </div>
        <?php if ($can_edit) : ?>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('issue_no'); ?></label>
                <?php echo form_dropdown('issue_no', $issue_list, $article_info['issue_no'], 
                        'class="span_9" id = "issue_no"'); ?>        
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <p><?php echo form_checkbox('make-live', 'publish', FALSE) . ' ' . lang('article_publish_now'); ?></p>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="span_9">
	<?php echo form_submit('article-submit', 'Submit', 'class="btn primary"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
