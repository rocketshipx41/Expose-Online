<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->helper('form');
$search_choices = array('artists' => 'Artist', 'articles' => 'Title');
?>
            <div class="row">
                <fb:like send="true" width="208" show_faces="true" />
            </div>
            <div class="row">
                <?php echo form_open('artists/search', array('id' => 'omni-search')); ?>
                    <label><?php echo lang('artist_search'); ?></label>
                    <?php echo form_input(array('name' => 'search-value', 'id' => 'search-value')); ?>
                    <?php echo form_dropdown('search-type', $search_choices, 'artist',
                            'id="search-type" onchange="changeSearch();"'); ?>
                    <?php echo form_submit('artist-submit', 'Submit', 'class="btn"'); ?>
                <?php echo form_close(); ?>
            </div>
<?php if ( count($recommendation_list) ) : ?>
        <div class="row">
            <h3><?php echo lang('latest_recommendations'); ?></h3>
        </div>
        <?php foreach ($recommendation_list as $item) : ?>
        <div class="row">
            <div class="span_12">
                <p><strong><?php echo anchor('articles/display/' . $item['slug'], $item['title']); ?></strong></p>
                <?php echo $item['body']; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="row">
            <?php echo anchor('articles/index/recommendations', lang('more_recommendations')); ?>
            <?php if ($can_edit) : ?>
            &mdash; <?php echo anchor('articles/add/8', lang('add_recommendation')); ?>
            <?php endif; ?>
        </div>
<?php endif; ?>
<?php if ( $show_ads ) : ?>
        <div class="row">
            <a href="http://<?php echo $side_ad['url']; ?>" target="_blank">
                <img src="<?php echo image_url('ads/' . $side_ad['image_file']);?>" 
                     alt="<?php echo $side_ad['alt']; ?>"
                     title="<?php echo $side_ad['title']; ?>"
                    style="display: block;margin-left: auto;margin-right: auto" />
            </a>
        </div>
<?php endif; ?>
