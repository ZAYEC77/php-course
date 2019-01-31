<?php


echo '<pre>GET:';
print_r($_GET);

$sort = 1;
$search = 'Text';

if (isset($_GET['sort'])) {
    if ($_GET['sort'] == '1') {
        $sort = -1;
    }
}

?>


<a href="?sort=<?php echo $sort ?>&search=<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">Sort</a>
<a href="?search=<?php echo $search ?>&sort=<?= isset($_GET['sort']) ? $_GET['sort'] : '' ?>">Search</a>
<!--<a href="?limit=2">Click me 2</a>-->
