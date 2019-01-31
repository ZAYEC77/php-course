<?php

include 'functions.php';

$users = readData('users.txt');

$message = false;

if (hasUser()) {
    redirectToHome();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    foreach ($users as $user) {
        if ($user['username'] == $username && $user['password'] == $password) {
            $_SESSION['user'] = $user;

            redirectToHome();
        }
    }
}

include 'head.php';
?>
    <form method="post">
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </p>
        <input type="submit" value="Login">
    </form>
<?php include 'footer.php' ?>