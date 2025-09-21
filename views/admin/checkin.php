<?php include __DIR__ . '/../_layout_top.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PMS — Reception · Check-in</title>
  
  
</head>
<body>
<?php
$__hdr_candidates = [__DIR__ . "/includes/header.php", __DIR__ . "/../includes/header.php", __DIR__ . "/../../includes/header.php"];
foreach ($__hdr_candidates as $__p) { if (file_exists($__p)) { include $__p; break; } }
?>
  <header class="topbar">
    <div class="topbar-inner">
      <div class="logo" aria-hidden="true"></div>
      <div class="title">Pakenham Hospital — Patient Management System</div>
      <span class="badge">Reception</span>
      <div class="spacer"></div>
      <div class="user-chip">User Name</div>
      <button class="btn">Logout</button>
    </div>
  </header>

  <main class="page">
    <div class="rec-shell">
      <!-- left nav -->
      <aside class="sidebar">
        <nav class="nav">
          <a href="dashboard.php" class="nav-item">Dashboard</a>
          <a href="index.php?p=check_in" class="nav-item is-active">Check-in</a>
          <a href="appointments.php" class="nav-item">Appointments</a>
          <a href="patients.php" class="nav-item">Patients</a>
          <a href="tickets.php" class="nav-item">Tickets</a>
          <a href="index.php?p=profile_settings" class="nav-item">Profile/Settings</a>
        </nav>
      </aside>

      <!-- content -->
      <section class="content">
        <section class="section">
          <div class="section-label">Welcome / Instructions (large text)</div>
          <div class="hero-panel"></div>
        </section>

        <section class="section">
          <div class="section-label">Enter code or scan QR</div>
          <div class="code-panel"></div>

          <div class="center-actions">
            <button class="btn btn-dark" type="button">Check-in</button>
            <button class="btn" type="button">Need help?</button>
          </div>
        </section>
      </section>
    </div>
  </main>

  <footer class="footer">
    <div class="footer-inner">
      Smart Patient Management System — PMS • For SENG205S (Kent Institute Australia) • Add group member names & student IDs here
    </div>
  </footer>
<?php
$__ftr_candidates = [__DIR__ . "/includes/footer.php", __DIR__ . "/../includes/footer.php", __DIR__ . "/../../includes/footer.php"];
foreach ($__ftr_candidates as $__p) { if (file_exists($__p)) { include $__p; break; } }
?>
</body>
</html>
<?php include __DIR__ . '/../_layout_bottom.php'; ?>
