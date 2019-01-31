<?php
include 'functions.php';


$users = readData('users.txt');

$message = false;

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];

    if (array_search($username, array_column($users, 'username')) === false) {
        $users [] = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
        ];

        writeData('users.txt', $users);
        $message = 'Registration complete';
    } else {
        $message = 'Error';
    }

}

include 'head.php';
?>
<?php if ($message): ?>
    <p><?= $message ?></p>
<?php endif ?>
    <form method="post">
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </p>
        <input type="submit" value="Sign up">
    </form>
<?php include 'footer.php' ?>