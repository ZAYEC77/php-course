<h1><?= $post['title'] ?></h1>
<p><a href="<?= getBaseUrl() ?>/user_posts.php?username=<?= $post['user'] ?>"><?= $post['user'] ?></a></p>
<p><?= date('H:i d.m.Y', $post['created_at']) ?></p>