<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
    <div class="row">
        <div class="span_12">
            <ul class="nav" id="menu">
                <li <?php if ($menu_active == 'home') echo 'class="active"';?>>
                    <a href="<?php echo site_url(); ?>"><?php echo lang('menu_home'); ?></a>
                </li>
                <li <?php if ($menu_active == 'features') echo 'class="active"';?>>
                    <a href="<?php echo site_url('articles/index/features'); ?>"><?php echo lang('menu_features'); ?></a>
                </li>
                <li <?php if ($menu_active == 'reviews') echo 'class="active"';?>>
                    <a href="<?php echo site_url('articles/index/reviews'); ?>"><?php echo lang('menu_reviews'); ?></a>
                </li>
                <li <?php if ($menu_active == 'news') echo 'class="active"';?>>
                    <a href="<?php echo site_url('articles/index/news'); ?>"><?php echo lang('menu_news'); ?></a>
                </li>
                <li <?php if ($menu_active == 'recommendations') echo 'class="active"';?>>
                    <a href="<?php echo site_url('articles/index/recommendations'); ?>"><?php echo lang('menu_recommendations'); ?></a>
                </li>
                <li <?php if ($menu_active == 'artists') echo 'class="active"';?>>
                    <a href="<?php echo site_url('artists/index'); ?>"><?php echo lang('menu_artists'); ?></a>
                </li>
        <!--            <li><a href="<?php echo site_url('labels/index'); ?>"><?php echo lang('menu_labels'); ?></a></li>-->
                <li <?php if ($menu_active == 'about') echo 'class="active"';?>>
                    <a href="<?php echo site_url('welcome/about'); ?>"><?php echo lang('menu_about'); ?></a>
                </li>
                <li <?php if ($menu_active == 'faqs') echo 'class="active"'; ?>>
                    <a href="<?php echo site_url('articles/index/faqs'); ?>"><?php echo lang('menu_faq'); ?></a>
                </li>
                <?php if ($is_logged_in) : ?>
                <li>
                    <?php echo $user_name; ?>
                    <ul>
                        <li>
                            <a href="<?php echo site_url('people/display/' . $user_id); ?>"><?php echo lang('menu_user_page'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('welcome/changepwd'); ?>"><?php echo lang('menu_change_password'); ?></a>
                        </li>
                        <?php if ($can_contribute) : ?>
                        <li>
                            <a href="<?php echo site_url('articles/add'); ?>"><?php echo lang('menu_contribute'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('labels/edit/0'); ?>"><?php echo lang('menu_new_label'); ?></a>
                        </li>
                            <?php if ( ! $can_edit) : ?>
                        <li>
                            <a href="<?php echo site_url('articles/drafts'); ?>"><?php echo lang('menu_my_drafts'); ?></a>
                        </li>
                            <?php endif;?>
                        <?php endif;?>
                        <?php if ($can_edit) : ?>
                        <li>
                            <a href="<?php echo site_url('articles/drafts'); ?>"><?php echo lang('menu_drafts'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('articles/future'); ?>"><?php echo lang('menu_future'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('articles/submissions'); ?>"><?php echo lang('menu_edit'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('ads/index'); ?>"><?php echo lang('menu_ads'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('releases/assign'); ?>"><?php echo lang('menu_assign'); ?></a>
                        </li>
                        <?php endif;?>
                        <li>
                            <a href="<?php echo site_url('welcome/logout'); ?>">Log out</a>
                        </li>
                    </ul>
                </li>
                <?php else :// not logged in ?>
                <li>
                    <a href="<?php echo site_url('welcome/login'); ?>">Log in</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
