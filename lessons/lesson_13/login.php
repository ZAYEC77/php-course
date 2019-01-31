<?php
include "db.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password = '$password'";

    $result = mysqli_query($link, $sql);

    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['active']) {
            //LOGIN
            echo 'OK';
        } else {
            echo 'Error, user is not active';
        }
    } else {
        echo 'Error, user not found';
    }
}
?>


<form method="post">
    <p>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
    </p>
    <p>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </p>
    <input type="submit" value="Login">
</form>
