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
	<?php echo form_hidden('release-id', $release_id); ?>
	<?php echo form_hidden('action', $action); ?>
	<?php echo form_hidden('original-issue', $article_info['issue_no']); ?>
	<?php echo form_hidden('original-status', $article_info['status']); ?>
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
                <?php if ($article_info['id']) : ?>
                <?php echo form_multiselect('original-author[]', $staff_list, array_keys($credit_list[1]),
                        'id="original-author" style="display:none;"'); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row photo-line">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_photo_by'); ?></label>
                <?php echo form_multiselect('photographer[]', $staff_list, array_keys($credit_list[2]),
                        'class="chzn-select span_9" id="photographer"'); ?>
                <?php if ($article_info['id']) : ?>
                <?php echo form_multiselect('original-photographer[]', $staff_list, array_keys($credit_list[2]),
                        'id="original-photographer" style="display:none;"'); ?>
                <?php endif; ?>
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
                <?php if ($article_info['id']) : ?>
                <?php echo form_multiselect('original-artists[]', $artist_select_list, array_keys($artist_list),
                        'id="original-artists" style="display:none;"'); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_topic'); ?></label>
                <?php echo form_multiselect('topic[]', $topic_select_list, array_keys($topic_list),
                        'class="chzn-select span_9" id="topic"'); ?>
                <?php if ($article_info['id']) : ?>
                <?php echo form_multiselect('original-topics[]', $topic_select_list, array_keys($topic_list),
                        'id="original-topics" style="display:none;"'); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_related_links'); ?></label>
                <?php echo form_input('links', implode('; ', $link_list), 
                        'class="span_9" id="links"'); ?>        
        	<?php echo form_hidden('original-links', implode('; ', $link_list)); ?>
            </div>
        </div>
        <?php if ($can_edit) : ?>
        <div class="row image-line">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_image_file'); ?></label>
                <?php echo form_input('image_file', $article_info['image_file'], 
                        'class="span_9" id = "image_file"'); ?>        
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('issue_no'); ?></label>
                <?php echo form_dropdown('issue_no', $issue_list, $article_info['issue_no'], 
                        'class="span_9" id = "issue_no"'); ?>        
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <label class="stacked"><?php echo lang('article_publish_date'); ?></label>
                <?php echo form_input('published_on', $article_info['published_on'], 
                        'class="span_9" id = "published_on"'); ?>        
            </div>
        </div>
        <div class="row">
            <div class="span_9">
                <p><?php echo form_checkbox('make-live', 'publish', ($article_info['status'] =='live')) . ' ' . lang('article_publish_now'); ?></p>
            </div>
        </div>
        <div class="row front-page-line">
            <div class="span_9">
                <p><?php echo form_checkbox('front-page', 'frontpage', ($article_info['front_page'] =='1')) . ' ' . lang('article_front_page'); ?></p>
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
