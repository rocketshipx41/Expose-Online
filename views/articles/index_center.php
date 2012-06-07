<!--<p><?php echo $page_intro; ?></p>-->

<?php foreach ($main_list as $item) : ?>
<h3><?php echo $item['title']; ?></h3>
<p><?php echo $item['intro']; ?>
&raquo; <?php echo anchor('articles/display/' . $item['slug'], 'Read more'); ?></p>
<?php endforeach; ?>
