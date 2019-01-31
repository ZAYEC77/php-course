<?php


include 'functions.php';

$posts = readData('posts.txt');

$post = false;
if (isset($_GET['index'])) {
    $index = $_GET['index'];
    if (isset($posts[$index])) {
        $post = $posts[$index];
    }
}

include 'head.php';
?>

<?php if ($post): ?>
    <div>
        <?php include '_post_head.php' ?>
        <?php if(isset($post['image']) && $post['image']): ?>
            <img src="files/<?= $post['image'] ?>" alt="" style="width: 30%;">
        <?php endif ?>
        <p><?= nl2br($post['text']) ?></p>

        <?php if ($post['user'] == getUsername()): ?>
            <a href="<?= getBaseUrl() ?>/edit_post.php?index=<?= $index ?>">Edit post</a>
        <?php endif ?>
    </div>
<?php else: ?>
    <h1>Post not found :(</h1>
<?php endif ?>

<?php include 'footer.php' ?>
