<?php

include 'db.php';

if (isset($_POST['user']) && isset($_POST['user']['id'])) {
    $id = mysqli_real_escape_string($link, $_POST['user']['id']);

    $sql = false;

    if (isset($_POST['delete'])) {
        $sql = "DELETE FROM users WHERE id = $id";

    } elseif (isset($_POST['update'])) {
        $username = mysqli_real_escape_string($link, $_POST['user']['username']);
        $firstname = mysqli_real_escape_string($link, $_POST['user']['firstname']);

        $sql = "UPDATE users"
            . " SET username = '$username', firstname = '$firstname'"
            . " WHERE id = $id";
    }

    if ($sql) {

        $result = mysqli_query($link, $sql);

        if (!$result) {
            echo 'Error';
        }
    }
}


if (isset($_POST['new_user'])) {
    $username = mysqli_real_escape_string($link, $_POST['new_user']['username']);
    $firstname = mysqli_real_escape_string($link, $_POST['new_user']['firstname']);

    $insertSql = "INSERT INTO users (username, firstname) "
        . "VALUES ('$username', '$firstname')";

    $result = mysqli_query($link, $insertSql);

    if (!$result) {
        echo 'Error';
    }
}


$sql = "SELECT * FROM users";

if (isset($_GET['filter']) && $_GET['filter']) {
    $filter = mysqli_real_escape_string($link, $_GET['filter']);

    $sql .= ' WHERE';
    $sql .= " username LIKE '%$filter%'";
    $sql .= ' OR';
    $sql .= " firstname LIKE '%$filter%'";

}

if ($sort = getSort($link)) {
    $order = getOrderBy($link);
    $sql .= ' ORDER BY';
    $sql .= " $sort $order";
}

function getSort($link)
{
    if (isset($_GET['sort']) && $_GET['sort']) {
        $sort = mysqli_real_escape_string($link, $_GET['sort']);
        return $sort;
    }
    return false;
}

function getOrderBy($link)
{
    $order = 'ASC';

    if (isset($_GET['order_by']) && $_GET['order_by']) {
        $orderBy = mysqli_real_escape_string($link, $_GET['order_by']);
        $order = strtoupper($orderBy);
    }
    return $order;
}

function getSortUrl($link, $column)
{
    $result = '?sort=' . $column;

    if (isset($_GET['sort']) && $_GET['sort']) {
        $sort = $_GET['sort'];
        if ($sort == $column) {
            if (getOrderBy($link) != 'DESC') {

                $result .= '&order_by=desc';
            }
        }
    }
    return $result;
}


$result = mysqli_query($link, $sql);

?>
    <table>
        <tr>
            <th><a href="<?= getSortUrl($link, 'id') ?>">ID</a></th>
            <th><a href="<?= getSortUrl($link, 'username') ?>">Username</a></th>
            <th><a href="<?= getSortUrl($link, 'firstname') ?>">Firstname</a></th>
            <th></th>
        </tr>
        <?php while ($user = mysqli_fetch_assoc($result)): ?>
            <tr>
                <form action="" method="post">
                    <td><?= $user['id'] ?></td>
                    <td><input type="text" value="<?= $user['username'] ?>" name="user[username]"></td>
                    <td><input type="text" value="<?= $user['firstname'] ?>" name="user[firstname]"></td>
                    <td>
                        <input type="hidden" name="user[id]" value="<?= $user['id'] ?>">
                        <input type="submit" value="Update" name="update">
                        <input type="submit" value="Delete" name="delete">
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
        <tr>
            <form action="" method="post">
                <td>#</td>
                <td><input type="text" name="new_user[username]"></td>
                <td><input type="text" name="new_user[firstname]"></td>
                <td><input type="submit" value="Add"></td>
            </form>
        </tr>
    </table>

    <hr>

    <form action="" method="get">
        <input type="text" name="filter">
        <input type="submit" value="Search">
    </form>
<?php

mysqli_close($link);