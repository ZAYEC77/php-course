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

if ($post) {
    if (isset($_POST['title']) && isset($_POST['text'])) {

        $posts[$index]['title'] = $_POST['title'];
        $posts[$index]['text'] = $_POST['text'];

        writeData('posts.txt', $posts);

        redirect('/view_post.php?index=' . $index);
    }
}

include 'head.php';
?>


<?php if ($post): ?>
    <form action="" method="post">

        <p>
            <label for="title">Title:</label>
            <br>
            <input type="text" name="title" id="title" value="<?= $post['title'] ?>">
        </p>

        <p>
            <label for="text">Text:</label>
            <br>
            <textarea name="text" id="text" cols="30" rows="10"><?= $post['text'] ?></textarea>
        </p>

        <input type="submit" value="Save post">

    </form>
<?php else: ?>
    <h1>Post not found :(</h1>
<?php endif ?>


<?php include 'footer.php' ?>
