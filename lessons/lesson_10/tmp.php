<?php
include 'functions.php';

$users = readData('users.txt');

$messageUsersPasswords = false;
$messageUsersFailedDuplicate = false;
$messageUsersFailedVoid = false;
$message = false;


if (isset ($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) {

        $password_length = strlen($password);

        $found_user = false;

        foreach ($users as $user) {
            if ($username === $user['username']) {
                $found_user = $user;
                break;
            }
        }

        if ($found_user['username'] !== $username) {
            if ($password_length >= 8) {
                $users [] = [
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'firstname' => $_POST['firstname'],
                ];
                writeData('users.txt', $users);
                $message = 'Registration complete';
            } else {
                $messageUsersPasswords = 'Registration failed password must have at least 8 characters ';
            }
        } else {
            $messageUsersFailedDuplicate = 'Registration failed, this username is already exist';
        }
    } else {
        $message = 'Registration failed need input data';// пусті
    }

}

include 'head.php';
?>

<?php if ($messageUsersPasswords): ?>
    <p><?= $messageUsersPasswords ?> </p>
<?php endif ?>
<?php if ($messageUsersFailedDuplicate): ?>
    <p><?= $messageUsersFailedDuplicate ?> </p>
<?php endif ?>
<?php if ($messageUsersFailedVoid): ?>
    <p><?= $messageUsersFailedVoid ?> </p>
<?php endif ?>
<?php if ($message): ?>
    <p><?= $message ?> </p>
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
        <p>
            <label for="firstname">First name:</label>
            <input type="text" name="firstname" id="firstname">
        </p>
        <input type="submit" value="Sing up">
    </form>


<?php

include 'footer.php';
?>