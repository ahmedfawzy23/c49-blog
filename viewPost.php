<?php
require_once 'inc/header.php';
require_once 'inc/conn.php';


$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
  $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
  header('location: ' . $redirect);
  exit;
}

$sql = "SELECT * FROM posts where id = $id";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);


if (empty($post)) {
  header('location: 404.html');
  exit;
}
?>

<!-- Page Content -->
<div class="page-heading products-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="text-content">
          <h4><?= $post['title'] ?></h4>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="best-features about-features">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="section-heading">
          <h2><?= $post['title'] ?></h2>
        </div>
      </div>
      <div class="col-md-6">
        <div class="right-image">
          <img src="assets/images/postImage/<?= $post['image'] ?>" alt="">
        </div>
      </div>
      <div class="col-md-6">
        <div class="left-content">
          <div class="container mb-3">

            <?= $post['body'] ?>
          </div>
          <div class="d-flex justify-content-center">
            <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']): ?>
              <a href="editPost.php?id=<?= $post['id'] ?>" class="btn btn-success mr-3 "> edit post</a>

              <a href="deletePost.php?id=<?= $post['id'] ?>" class="btn btn-danger "> delete post</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'inc/footer.php' ?>