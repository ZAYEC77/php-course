<?php

include 'functions.php';

$posts = readData('posts.txt');

$users = readData('users.txt');

$username = false;

if (isset($_GET['username'])) {
    $tmp = $_GET['username'];

    foreach ($users as $user) {
        if ($user['username'] == $tmp) {
            $username = $tmp;
        }
    }
}

$userPosts = [];

foreach ($posts as $index => $post) {
    if ($post['user'] == $username) {
        $userPosts[$index] = $post;
    }
}

include 'head.php';

?>

<?php if ($username): ?>
    <?php if (!empty($userPosts)): ?>
        <h1>Posts from <?= $username ?>:</h1>
        <?php foreach ($userPosts as $index => $post): ?>
            <div>
                <?php include '_post_head.php' ?>
                <p><?= shortText($post['text']) ?></p>
                <a href="<?= getBaseUrl() ?>/view_post.php?index=<?= $index ?>">View post</a>
                <hr>
            </div>
        <?php endforeach ?>
    <?php else: ?>
        <h1>This user doesn't have any posts :/</h1>
    <?php endif ?>

<?php else: ?>
    <h1>User not found :(</h1>
<?php endif ?>



<?php include 'footer.php' ?>
