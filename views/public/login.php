<?php
// PakenhamH_Web_App/views/public/login.php
$title = 'Login — Pakenham Hospital';
include __DIR__ . '/../_layout_top.php';
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-3">Sign in</h3>
        <?php if ($flash): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= $baseUrl ?>/index.php?p=auth/login" novalidate>
          <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <input class="form-control" id="username" name="username" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input class="form-control" id="password" type="password" name="password" required>
          </div>
          <button class="btn btn-primary w-100" type="submit">Login</button>
        </form>
        <hr>
        <p class="mb-0">New here? <a href="<?= $baseUrl ?>/index.php?p=public/register">Register as patient</a>.</p>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../_layout_bottom.php'; ?>
