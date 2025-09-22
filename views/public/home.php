<?php
// PakenhamH_Web_App/views/public/home.php
$title = 'Pakenham Hospital — Welcome';
include __DIR__ . '/../_layout_top.php';

$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // /PakenhamH_Web_App/public
$rootUrl = rtrim(dirname($baseUrl), '/');                // /PakenhamH_Web_App
?>
<section class="hero">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-bold mb-3">Compassion. Care. Community.</h1>
      <p class="lead">
        Welcome to Pakenham Hospital. Book appointments, access your records,
        and connect with our care teams securely online.
      </p>
      <div class="d-flex gap-2 mt-3">
        <a class="btn btn-primary btn-lg" href="<?= $baseUrl ?>/index.php?p=public/login">Login</a>
        <a class="btn btn-outline-primary btn-lg" href="<?= $baseUrl ?>/index.php?p=public/register">Register as Patient</a>
      </div>
    </div>
    <div class="col-lg-5 mt-4 mt-lg-0">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Already registered?</h5>
          <p class="card-text">Sign in and you’ll be redirected to your PMS area based on your role (Admin, Clinician, Reception, or Patient).</p>
          <a class="btn btn-success" href="<?= $baseUrl ?>/index.php?p=public/login">Go to Login</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="row g-4">
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Emergency</h5>
        <p class="card-text">Call 000 for emergencies. For urgent care, visit our ER entrance on Princes Hwy.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Services</h5>
        <p class="card-text">General practice, maternity, pathology, imaging, surgery and more.</p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Contact</h5>
        <p class="card-text">Reception (03) 9000 0000 · Weekdays 8am–6pm</p>
      </div>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../_layout_bottom.php'; ?>
