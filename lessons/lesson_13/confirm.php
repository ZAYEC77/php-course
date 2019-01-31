<?php
include 'db.php';


if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $sql = "UPDATE users"
        . " SET active = 1"
        . " WHERE email LIKE '$email'";
    mysqli_query($link, $sql);

    echo 'Try to login';
}