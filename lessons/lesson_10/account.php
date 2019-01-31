<?php

include 'functions.php';

if (!hasUser()) {
    redirectToHome();
}

$users = readData('users.txt');

$user = $_SESSION['user'];

$errors = [];

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $userIndex = false;
    foreach ($users as $index => $item) {
        if ($item['username'] === $user['username']) {
            $userIndex = $index;
            break;
        }
    }
    if ($username !== $user['username']) {
        $foundDuplicates = false;
        foreach ($users as $index => $item) {
            if ($item['username'] === $username) {
                $errors[] = 'Username is already exist';
                $foundDuplicates = true;
                break;
            }
        }
        $user['username'] = $username;
    }
    if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['new_password_2'])) {
        $passwordErrors = false;
        if (empty($_POST['old_password'])) {
            $errors[] = 'Please, enter old password';
            $passwordErrors = true;
        } else {
            if ($_POST['old_password'] !== $user['password']) {
                $errors[] = 'Old password is incorrect';
                $passwordErrors = true;
            }
        }

        if (empty($_POST['new_password'])) {
            $errors[] = 'Please, enter new password';
            $passwordErrors = true;
        }

        if (empty($_POST['new_password_2'])) {
            $errors[] = 'Please, enter new password again';
            $passwordErrors = true;
        }

        if ($_POST['new_password'] !== $_POST['new_password_2']) {
            $errors[] = 'Please, repeat new password correct';
            $passwordErrors = true;
        }

        if ($_POST['old_password'] === $_POST['new_password']) {
            $errors[] = 'New password is the same as old';
            $passwordErrors = true;
        }

        if (!$passwordErrors) {
            $user['password'] = $_POST['new_password'];
        }
    }

    if (count($errors) == 0) {
        $_SESSION['user'] = $user;
        if ($userIndex !== false) {
            $users[$userIndex] = $user;
        }
        writeData('users.txt', $users);
    }

}


include 'head.php';
?>

<?php foreach ($errors as $error): ?>
    <p><?= $error ?></p>
<?php endforeach ?>

    <form action="" method="post">

        <p>
            <label for="username">Username:</label>
            <br>
            <input type="text" name="username" id="username" value="<?= $user['username'] ?>">
        </p>
        <p>
            <label for="old_password">Old password:</label>
            <br>
            <input type="password" name="old_password" id="old_password">
        </p>
        <p>
            <label for="new_password">New password:</label>
            <br>
            <input type="password" name="new_password" id="new_password">
        </p>
        <p>
            <label for="new_password_2">New password (again):</label>
            <br>
            <input type="password" name="new_password_2" id="new_password_2">
        </p>
        <input type="submit" value="Update">
    </form>


<?php include 'footer.php' ?>