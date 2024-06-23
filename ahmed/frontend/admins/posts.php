<?php
require_once("header.php");
require_once("../../classes.php");
$user = unserialize($_SESSION["user"]);
$All_user = $user->get_all_posts();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
      </div>
      <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
        <svg class="bi">
          <use xlink:href="#calendar3" />
        </svg>
        This week
      </button>
    </div>
  </div>

  <h2>All Posts</h2>
  <div class="table-responsive small">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">title</th>
          <th scope="col">content</th>
          <th scope="col">image</th>
          <th scope="col">user_id</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($All_user as $posts) {
        ?>
          <tr>
            <td><?= $posts["id"] ?></td>
            <td><?= $posts["title"] ?></td>
            <td><?= $posts["content"] ?></td>
            <td><?php 
              if(!empty($posts["image"])) {
             ?>
                <a href="<?= $posts["image"] ?>">view</a>
             <?php 
              }
              else{
                ?>
                  no image
                <?php
              }
             ?>
             </td>
            <td><?= $posts["user_id"] ?></td>
            <td>
              <form action="deleteposts.php" method="post" style="display:inline-block">
                <button type="submit" class="btn btn-danger">DELETE POSTS</button>
                <input type="hidden" name="id" value="<?= $posts["id"] ?>">
              </form>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</main>

<?php
require_once("footer.php");
?>