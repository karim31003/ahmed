<?php
require_once('header.php');
require_once('../../classes.php');
$user = unserialize($_SESSION["user"]);
$homePosts = $user->homePosts();
$homePosts1 = $user->homePosts1();
?>
<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
      <img class="img-account-profile rounded-circle mb-2" style="width:100px;height: 100px;border-radius: 100px" src="<?php if(!empty($user->image)) echo $user->image; else echo 'http://bootdey.com/img/Content/avatar/avatar1.png' ?>">
        <h1 class="fw-light">Welcome <?= htmlspecialchars($user->name) ?></h1>
      </div>
    </div>
    <div class="col-lg-3 col-md-8 mx-auto">
    <?php
    if (isset($_GET["msg"]) && $_GET["msg"] == 'cas') {
      ?>

        <div class="alert alert-success" role="alert">
          <strong>done</strong> post Added Successfully
        </div>


      <?php
      }

      ?>
      <?php

      if (isset($_GET["msg"]) && $_GET["msg"] == 'required_fields') {
      ?>

        <div class="alert alert-danger" role="alert">
          <strong>required fields</strong> required fields
        </div>


      <?php
      }

      ?>
      <?php

      if (isset($_GET["msg"]) && $_GET["msg"] == 'dc') {
      ?>

        <div class="alert alert-success" role="alert">
          <strong>done</strong> delete comment
        </div>


      <?php
      }

      ?>
      <?php

      if (isset($_GET["msg"]) && $_GET["msg"] == 'dd') {
      ?>

        <div class="alert alert-success" role="alert">
          <strong>done</strong> delete comment
        </div>


      <?php
      }

      ?>
    </div>
  </section>

  <div class="album py-5 bg-body-tertiary">
    <div class="container">

      <div class="row">
      <?php
      $users = [];
      foreach ($homePosts1 as $post1) {
        $users[$post1["id"]] = $post1;
      }
      foreach ($homePosts as $post) {
        if (isset($users[$post["user_id"]])) {
          $post1 = $users[$post["user_id"]];
      ?>
        <div class="col-6 offset-3 bg-info mt-5 rounded-2">
          <div class="card">
            <div class="card p-3 mb-2">
              <div class="d-flex justify-content-between p-3">
                <div class="d-flex flex-row align-items-center">
                  <img class="img-account-profile rounded-circle mb-2" style="width:50px;height: 50px;border-radius: 50px" src="<?php echo !empty($post1["image"]) ? htmlspecialchars($post1["image"]) : 'http://bootdey.com/img/Content/avatar/avatar1.png'; ?>">
                  <div class="ms-2 c-details">
                    <h6 class="mb-0"><?= htmlspecialchars($post1["name"]) ?></h6> 
                    <span><?= htmlspecialchars($post["created_at"]) ?></span>
                  </div>
                </div>
                <div class="badge"> <span>Design</span> </div>
              </div>
              <?php
              if (!empty($post["image"])) {
              ?>
                <img class="card-img-top" src="<?= htmlspecialchars($post["image"]) ?>" alt="Post Image" />
              <?php
              }
              ?>
              <div class="card-body">
                <h4 class="card-title"><?= htmlspecialchars($post["title"]) ?></h4>
                <p class="card-text"><?= htmlspecialchars($post["content"]) ?></p>
              </div>
              <div class="post-likes mb-4">
                <button class="like-post" data-post-id="<?= $post['id'] ?>"><span id="post-like-count-<?= $post['id'] ?>"><?= $user->get_post_likes($post['id']) ?></span> 👍 Like</button>
                <button class="unlike-post" data-post-id="<?= $post['id'] ?>"><span id="post-unlike-count-<?= $post['id'] ?>"><?= $user->get_post_unlikes($post['id']) ?></span> 👎 unLike</button>
              </div>
              <?php
              if($user->id == $post["user_id"] && $user->role == "subscriber"){
              ?>
              <div class="ms-4 mb-4">
                <form action="deleteposts home.php" method="post">
                  <button type="submit" class="btn btn-danger">DELETE POSTS</button>
                  <input type="hidden" name="id" value="<?= $post["id"] ?>">
                </form>
              </div>
              <?php
              }
              if($user->role == "admin"){
              ?>
              <div class="ms-4 mb-4">
                <form action="deleteposts home.php" method="post">
                  <button type="submit" class="btn btn-danger">DELETE POSTS</button>
                  <input type="hidden" name="id" value="<?= $post["id"] ?>">
                </form>
              </div>
              <?php
              }
              ?>
              <div class="row d-flex justify-content-center">
                <div class="col">
                  <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                    <div class="card-body p-4">
                      <form action="store_comment home.php" method="post">
                        <div data-mdb-input-init class="form-outline mb-4">
                          <input type="text" id="addANote" name="comment" class="form-control" placeholder="Type comment..." />
                          <input type="hidden" name="post_id" value="<?= htmlspecialchars($post["id"]) ?>">
                          <button type="submit" class="btn btn-primary mt-2 ms-2">+ Add a note</button>
                        </div>
                      </form>
                      <?php
                      $comments = $user->get_post_comment($post["id"]);
                      foreach ($comments as $comment) {
                      ?>
                        <div class="card mb-4">
                          <div class="card-body">
                            <p><?= htmlspecialchars($comment["comment"]) ?></p>
                            <div class="d-flex justify-content-between">
                              <div class="d-flex flex-row align-items-center">
                                <img class="img-account-profile rounded-circle mb-2" style="width:50px;height: 50px;border-radius: 50px" src="<?php echo !empty($comment["image"]) ? htmlspecialchars($comment["image"]) : 'http://bootdey.com/img/Content/avatar/avatar1.png'; ?>">
                                <b><p class="small mb-0 ms-2"><?= htmlspecialchars($comment["name"]) ?></p></b>
                              </div>
                              <div class="d-flex flex-row align-items-center">
                                <p class="small text-muted mb-3"><?= htmlspecialchars($comment["created_at"]) ?></p>
                                <?php
                                if($user->id == $comment["user_id"] && $user->role == "subscriber"){
                                ?>
                                <div class="ms-4 mb-4">
                                  <form action="deletecomment home.php" method="post" style="display:inline-block">
                                    <button type="submit" class="btn btn-danger">DELETE</button>
                                    <input type="hidden" name="comment_id" value="<?= $comment["id"] ?>">
                                  </form>
                                </div>
                                <?php
                                }
                                elseif($user->role == "admin"){
                                ?>
                                <div class="ms-4 mb-4">
                                  <form action="deletecomment home.php" method="post" style="display:inline-block">
                                    <button type="submit" class="btn btn-danger">DELETE</button>
                                    <input type="hidden" name="comment_id" value="<?= $comment["id"] ?>">
                                  </form>
                                </div>
                                <?php
                                }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
        }
      }
      ?>
      </div>
    </div>
  </div>

</main>

<?php
require_once('footer.php');
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.like-post, .unlike-post').forEach(button => {
    button.addEventListener('click', function() {
      const postId = this.dataset.postId;
      const action = this.classList.contains('like-post') ? 'like' : 'unlike';
      
      fetch('like_post.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          'post_id': postId,
          'action': action
        })
      })
      .then(response => response.json())
      .then(data => {
        const currentLikeCount = parseInt(document.getElementById(`post-like-count-${postId}`).innerText);
        const currentUnlikeCount = parseInt(document.getElementById(`post-unlike-count-${postId}`).innerText);
        
        document.getElementById(`post-like-count-${postId}`).innerText = data.like_count;
        document.getElementById(`post-unlike-count-${postId}`).innerText = data.unlike_count;
        
        if (action === 'like' && data.like_count > currentLikeCount) {
          this.style.backgroundColor = 'lightgreen'; // Change to your preferred color for like
        } else if (action === 'unlike' && data.unlike_count > currentUnlikeCount) {
          this.style.backgroundColor = 'red'; // Change to your preferred color for unlike
        }
        
        setTimeout(() => {
          this.style.backgroundColor = ''; // Reset background color after a short delay
        }, 2000); // 1000 milliseconds = 1 second
      });
    });
  });
});
</script>
<style>
  .like-post, .unlike-post {
    cursor: pointer;
    padding: 5px 10px;
    border: none;
    color: white;
    border-radius: 4px;
    margin-right: 10px;
  }
  .like-post {
    background-color: #3498db; /* Blue for like */
  }
  .unlike-post {
    background-color: #e74c3c; /* Red for unlike */
  }
  .post {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .post-actions {
    margin-top: 10px;
  }
</style>