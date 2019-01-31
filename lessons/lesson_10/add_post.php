<?php

include 'functions.php';

$posts = readData('posts.txt');


$errors = [];
if (isset($_POST['title']) && isset($_POST['text'])) {

    $image = false;
    if (isset($_FILES['image'])) {
        $formImage = $_FILES['image'];
        if ($formImage['error'] !== UPLOAD_ERR_OK) {
            if ($formImage['error'] == UPLOAD_ERR_NO_FILE) {
                $errors [] = 'Please, select file';
            } else {
                $errors [] = 'File upload error';
            }
        } else {
            if ($formImage['size'] > 4 * 1024 * 1024) { //4 mb
                $errors [] = 'File size error';
            } else {
                $destination = time() . '_' . $formImage['name'];
                move_uploaded_file($formImage['tmp_name'], 'files' . DIRECTORY_SEPARATOR . $destination);
                $image = $destination;
            }
        }
    }
    if (count($errors) === 0) {
        $posts[] = [
            'image' => $image,
            'title' => $_POST['title'],
            'text' => $_POST['text'],
            'user' => getUsername(),
            'created_at' => time(),
        ];

        writeData('posts.txt', $posts);

        redirectToHome();
    }
}

include 'head.php';
?>


<?php foreach ($errors as $error): ?>
    <p><?= $error ?></p>
<?php endforeach ?>


<form action="" method="post" enctype="multipart/form-data">

    <p>
        <label for="title">Title:</label>
        <br>
        <input type="text" name="title" id="title">
    </p>

    <p>
        <label for="text">Text:</label>
        <br>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
    </p>

    <p>
        <label for="image">Image:</label>
        <br>
        <input type="file" name="image">
    </p>

    <input type="submit" value="Add post">

</form>

<?php include 'footer.php' ?>
 