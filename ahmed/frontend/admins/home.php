<?php
require_once("header.php");
require_once("../../classes.php");
$user = unserialize($_SESSION["user"]);
$All_user = $user->get_all_users();
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

  <h2>All Admin Users</h2>
  <div class="table-responsive small">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Phone</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($All_user as $user) { 
          if($user["role"] == "admin" && empty($user["banned"]))
          { 
          ?>
          <tr>
            <td><?= htmlspecialchars($user["id"]) ?></td>
            <td><?= htmlspecialchars($user["name"]) ?></td>
            <td><?= htmlspecialchars($user["email"]) ?></td>
            <td><?= htmlspecialchars($user["role"]) ?></td>
            <td><?= htmlspecialchars($user["phone"]) ?></td>
            <td>
              <form action="ban_user.php" method="post" style="display:inline-block">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user["id"]) ?>">
                <button type="submit" class="btn btn-danger">BAN</button>
              </form>
              <form action="deleteaccount.php" method="post" style="display:inline-block">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user["id"]) ?>">
                <button type="submit" class="btn btn-danger">DELETE ACCOUNT</button>
              </form>
              <form action="makesubscriber.php" method="post" style="display:inline-block">
              <input type="hidden" name="user_id" value="<?= htmlspecialchars($user["id"]) ?>">
              <button type="submit" class="btn btn-success">Make Subscriber</button>
              </form>
            </td>
          </tr>
        <?php 
        } 
      } 
      ?>
      </tbody>
    </table>
    <br>
    <h2>All Subscriber Users</h2>
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Phone</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($All_user as $user) { 
          if($user["role"] == "subscriber" && empty($user["banned"])) { 
            
          ?>
          <tr>
            <td><?= htmlspecialchars($user["id"]) ?></td>
            <td><?= htmlspecialchars($user["name"]) ?></td>
            <td><?= htmlspecialchars($user["email"]) ?></td>
            <td><?= htmlspecialchars($user["role"]) ?></td>
            <td><?= htmlspecialchars($user["phone"]) ?></td>
            <td>
              <form action="ban_user.php" method="post" style="display:inline-block">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user["id"]) ?>">
                <button type="submit" class="btn btn-danger">BAN</button>
              </form>
              <form action="deleteaccount.php" method="post" style="display:inline-block">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user["id"]) ?>">
                <button type="submit" class="btn btn-danger">DELETE ACCOUNT</button>
              </form>
              <form action="makeadmin.php" method="post" style="display:inline-block">
              <input type="hidden" name="user_id" value="<?= htmlspecialchars($user["id"]) ?>">
              <button type="submit" class="btn btn-success">Make Admin</button>
              </form>
            </td>
          </tr>
        <?php 
      } 
      } 
      ?>
      </tbody>
    </table>
  </div>
</main>

<?php require_once("footer.php"); ?>
