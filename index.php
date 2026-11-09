<?php
require_once 'inc/header.php';
require_once 'inc/conn.php';


$limit = 6;
$countResult = mysqli_query($conn, "SELECT COUNT(*) as num_posts FROM `posts`;");
$count = mysqli_fetch_assoc($countResult)['num_posts'];
$countPages = ceil($count / $limit);

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
  $page = $_GET['page'];
}

$offset = ($page - 1) * $limit;



$query = "SELECT id, title, SUBSTR(body, 1, 100) AS body , DATE(created_at) as date, image 
          FROM posts
          ORDER BY created_at DESC
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);

$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
// echo "<pre>";
// print_r($posts);
// die();

?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="banner header-text">
  <div class="owl-banner owl-carousel">
    <div class="banner-item-01">
      <div class="text-content">
        <!-- <h4>Best Offer</h4> -->
        <!-- <h2>New Arrivals On Sale</h2> -->
      </div>
    </div>
    <div class="banner-item-02">
      <div class="text-content">
        <!-- <h4>Flash Deals</h4> -->
        <!-- <h2>Get your best products</h2> -->
      </div>
    </div>
    <div class="banner-item-03">
      <div class="text-content">
        <!-- <h4>Last Minute</h4> -->
        <!-- <h2>Grab last minute deals</h2> -->
      </div>
    </div>
  </div>
</div>
<!-- Banner Ends Here -->



<div class="latest-products">
  <div class="container">
    <?php include "inc/messages.php" ?>
    <div class="row">
      <div class="col-md-12">
        <div class="section-heading">
          <h2>Latest Posts</h2>
          <!-- <a href="products.html">view all products <i class="fa fa-angle-right"></i></a> -->
        </div>
      </div>
      <?php
      if (!empty($posts)):
        foreach ($posts as $post) { ?>
          <div class="col-md-4">
            <div class="product-item">
              <a href="viewPost.php?id=<?= $post['id'] ?>"><img src="assets/images/postImage/<?= $post['image'] ?>" alt=""></a>
              <div class="down-content">
                <a href="viewPost.php?id=<?= $post['id'] ?>">
                  <h4><?= $post['title'] ?></h4>
                </a>
                <h6><?= $post['date'] ?></h6>
                <p> <?= $post['body'] . " ..." ?></p>

                <div class="d-flex justify-content-end">
                  <a href="viewPost.php?id=<?= $post['id'] ?>" class="btn btn-info "> view</a>
                </div>

              </div>
            </div>
          </div>
        <?php } ?>

        <nav aria-label="Page navigation example" class="col-12 d-flex justify-content-center">
          <ul class="pagination">
            <?php if ($page != 1):  ?>
              <li class="page-item"><a class="page-link" href="index.php?page=<?= $page - 1 ?>">Previous</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $countPages; $i++): ?>
              <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="index.php?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor ?>
            <?php if ($page != $countPages):  ?>
              <li class="page-item"><a class="page-link" href="index.php?page=<?= $page + 1 ?>">Next</a></li>
            <?php endif; ?>

          </ul>
        </nav>
      <?php else: ?>
        <h2>No Posts Found</h2>
      <?php endif ?>
    </div>
  </div>
</div>



<?php require_once 'inc/footer.php' ?>