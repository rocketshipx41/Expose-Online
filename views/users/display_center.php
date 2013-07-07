<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * template for user display page
 */
?>
<div class="row">
<h2><?php echo $user_info['display_name']; ?></h2>
<dl>
<?php if ($can_contribute) : ?>
    <dt><?php echo lang('people_email'); ?></dt>
    <dd><?php echo $user_info['email']; ?></dd>
<?php endif; ?>
<?php if ($can_contribute) : ?>
    <dt><?php echo lang('people_user_name'); ?></dt>
    <dd><?php echo $user_info['username']; ?></dd>
    <dt><?php echo lang('people_last_login'); ?></dt>
    <dd><?php echo $user_info['last_login']; ?></dd>
    <dt><?php echo lang('people_activated'); ?></dt>
    <dd><?php echo $user_info['activated']; ?></dd>
<?php endif; ?>
    <dt><?php echo lang('people_contributions'); ?></dt>
<?php if (count($article_list)) : ?>
    <dd>
        <?php echo lang('people_article_count') . ': ' . count($article_list); ?><br/>
        <ul>
        <?php foreach ($article_list as $item) :?>
            <li>
                <?php echo $item['category'] . ': ' . anchor('articles/display/' 
                        . $item['slug'], $item['title']); ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </dd>
<?php else : ?>
    <dd><em><?php echo lang('artist_field_none'); ?></em></dd>
<?php endif; ?>
</dl>
</div> <!-- row -->