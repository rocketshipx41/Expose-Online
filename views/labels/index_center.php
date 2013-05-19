<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for label index page center section
 */
?>
<div class="row">
    <div class="span_12">
        <h2><?php echo $template['title']; ?></h2>
    </div>
</div>
<div class="row">
    <div class="span_12">
        <strong><?php echo lang('label_item_count'); ?> : </strong>
            <?php echo count($label_list); ?>
    </div> <!-- column span -->
</div> <!-- row -->
<div class="row">
<?php if (count($label_list)) : ?>
    <div class="span_12">
        <ul>
<?php foreach ($label_list as $id => $item) : ?>
            <li>
                <?php echo anchor('labels/display/' . $id, $item['display']); ?>
                (<?php echo $item['release_count'] . ' ' . lang('artist_field_releases'); ?>)
            </li>
<?php endforeach; ?>
        </ul>
    </div>
<?php else : ?>
<p><?php echo lang('label_search_none'); ?></p>
<?php endif; ?>
</div>
<?php if ($can_edit) : ?>
<div class="row">
    <?php echo anchor('labels/add', lang('label_add'), 'class="btn"'); ?>
</div>
<?php endif; ?>
