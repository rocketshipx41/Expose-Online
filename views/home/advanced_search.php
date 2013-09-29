<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->helper('form');
$search_choices = array(
    'artists' => 'Artist', 
    'articles' => 'Title', 
    'releases' => 'Release',
    'labels' => 'Label'
);
?>
            <?php echo form_open('welcome/search', array('id' => 'omni-search')); ?>
            <div class="row">
            </div>
            <div class="row">
                    <label><?php echo lang('artist_search'); ?></label>
                    <?php echo form_input(array('name' => 'search-value', 'id' => 'search-value')); ?>
                    <?php echo form_dropdown('search-type', $search_choices, 'artist',
                            'id="search-type" onchange="changeSearch();"'); ?>
                    <?php echo form_submit('artist-submit', 'Submit', 'class="btn"'); ?>
            </div>
            <?php echo form_close(); ?>
