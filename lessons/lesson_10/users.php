<?php

include 'functions.php';

$users = readData('users.txt');

include 'head.php';
?>

    <ol>

        <?php foreach ($users as $user): ?>
            <li>
                <a href="<?= getBaseUrl() ?>/user_posts.php?username=<?= $user['username'] ?>"><?= $user['username'] ?></a>
            </li>
        <?php endforeach ?>

    </ol>

<?php include 'footer.php' ?>