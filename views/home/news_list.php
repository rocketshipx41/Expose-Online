<div>
    <h1>News</h1>
    <ul>
    <?php foreach ($news_list as $item) : ?>
        <li><a href="/articles/display/<?php echo $item['slug']; ?>"><?php echo $item['intro']; ?></a></li>
    <?php endforeach; ?>
    </ul>
</div>
