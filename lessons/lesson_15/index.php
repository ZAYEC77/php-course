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

$count = 0;

//$countSql = "SELECT COUNT(*) AS 'count' FROM users";
$countSql = str_replace("SELECT * FROM users", "SELECT COUNT(*) AS 'count' FROM users", $sql);

$r = mysqli_fetch_assoc(mysqli_query($link, $countSql));

if (isset($r['count'])) {
    $count = $r['count'];
}

$limit = 5;


$currentPage = 1;
if (isset($_GET['page']) && $_GET['page']) {
    $currentPage = $_GET['page'];
}
if ($count > $limit) {
    $sql .= " LIMIT $limit";
    $pages = ceil($count / $limit);

//    $offset = 0;
//    for ($i = 1; $i < $currentPage; $i++) {
//        $offset += $limit;
//    }

    $offset = ($currentPage - 1) * $limit;


    $sql .= " OFFSET $offset";
//    echo $sql;
//    die;
}

$result = mysqli_query($link, $sql);

?>
    <p>Total: <?= $count ?></p>
    <p>Current page: <?= $currentPage ?></p>
    <p>Pages: <?= $pages ?></p>
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
    <ul>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <li>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
    <hr>

    <form action="" method="get">
        <input type="hidden" value="<?= getSort($link) ?>" name="sort">
        <input type="hidden" value="<?= getOrderBy($link) ?>" name="order_by">
        <input type="text" name="filter">
        <input type="submit" value="Search">
    </form>
<?php

mysqli_close($link);