<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

$title = 'Login — Pakenham Hospital';
include __DIR__ . '/../_layout_top.php';

$baseUrl = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

if (empty($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
?>
<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-3">Sign in</h3>

        <?php if ($flash): ?>
          <div class="alert alert-danger" role="alert"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= $baseUrl ?>/index.php?p=auth/login" novalidate>
          <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
          <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <input class="form-control" id="username" type="text" name="username" required autofocus autocomplete="username">
          </div>
          <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input class="form-control" id="password" type="password" name="password" required autocomplete="current-password">
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
