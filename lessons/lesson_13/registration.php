<?php

include 'db.php';


if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];


    $insertSql = "INSERT INTO users (email, password) "
        . "VALUES ('$email', '$password')";

    $result = mysqli_query($link, $insertSql);

    if (!$result) {
        echo 'Error';
    }

    // SQL Insert

    mail($email, 'Welcome', 'Please, <a href="http://localhost:8899/lesson_13/confirm.php?email=' . $email . '">confirm</a> your account ');


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
    <input type="submit" value="Sign up">
</form>
