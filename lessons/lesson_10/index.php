<?php

include 'functions.php';

$posts = readData('posts.txt');

include 'head.php';

?>

<?php foreach ($posts as $index => $post): ?>

    <div>
        <?php include '_post_head.php' ?>
        <p><?= shortText($post['text']) ?></p>
        <a href="<?= getBaseUrl() ?>/view_post.php?index=<?= $index ?>">View post</a>
        <hr>
    </div>
<?php endforeach ?>

<?php include 'footer.php' ?>