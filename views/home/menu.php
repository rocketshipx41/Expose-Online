<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
		<div class="navbar-inner">
		    <div class="container">
			<ul class="nav">
			    <li class="active"><a href="<?php echo site_url(); ?>"><?php echo lang('menu_home'); ?></a></li>
			    <li class="divider-vertical"></li>
			    <li><a href="<?php echo site_url('articles/index/features'); ?>"><?php echo lang('menu_features'); ?></a></li>
			    <li class="divider-vertical"></li>
			    <li><a href="<?php echo site_url('articles/index/reviews'); ?>"><?php echo lang('menu_reviews'); ?></a></li>
			    <li class="divider-vertical"></li>
			    <li><a href="<?php echo site_url('articles/index/news'); ?>"><?php echo lang('menu_news'); ?></a></li>
			    <li class="divider-vertical"></li>
			    <li><a href="<?php echo site_url('artists/index'); ?>"><?php echo lang('menu_artists'); ?></a></li>
			    <li class="divider-vertical"></li>
			    <li><a href="<?php echo site_url('labels/index'); ?>"><?php echo lang('menu_labels'); ?></a></li>
			    <li class="divider-vertical"></li>
			    <li><a href="<?php echo site_url('welcome/about'); ?>"><?php echo lang('menu_about'); ?></a></li>
			    <li class="divider-vertical"></li>
			    <li><a href="<?php echo site_url('articles/index/faqs'); ?>"><?php echo lang('menu_faq'); ?></a></li>
			</ul>
			<ul class="nav pull-right">
			    <?php if ($is_logged_in) : ?>
			    <li class="dropdown" id="user-menu">
				<a href="#user-menu" class="dropdown-toggle" 
					data-toggle="dropdown">
				    <?php echo $user_name; ?>
				    <b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
				    <li><a href="user/<?php echo $user_name; ?>"><?php echo lang('menu_user_page'); ?></a></li>
				    <?php if ($can_contribute) : ?>
				    <li><a href="<?php echo site_url('articles/add'); ?>"><?php echo lang('menu_contribute'); ?></a></li>
				    <?php endif;?>
				</ul>
			    </li>
			    <li class="divider-vertical"></li>
			    <li><a href="<?php echo site_url('welcome/logout'); ?>">Log out</a></li>
			    <?php else : ?>
			    <li><a href="<?php echo site_url('welcome/login'); ?>">Log in</a></li>
			    <?php endif; ?>
			</ul>
		    </div>
		</div>
