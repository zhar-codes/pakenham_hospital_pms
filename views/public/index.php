<?php
// PakenhamH_Web_App/views/public/index.php
$title = 'Pakenham Hospital — Care you can trust';
include __DIR__ . '/../_layout_top.php';

$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // /PakenhamH_Web_App/public
?>
<section class="hero py-5">
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-lg-7">
        <h1 class="display-5 fw-semibold">Local care. Modern medicine.</h1>
        <p class="lead">Emergency, surgery, maternity, and community health services for Pakenham and Cardinia.</p>
        <div class="d-flex gap-2">
          <a href="<?= $baseUrl ?>/index.php?p=auth/login" class="btn btn-primary btn-lg px-4">Login</a>
          <a href="<?= $baseUrl ?>/index.php?p=public/register" class="btn btn-outline-primary btn-lg px-4">Register patient</a>
        </div>
        <div class="row mt-4 text-secondary">
          <div class="col-4"><div class="h3 mb-0">24/7</div><div class="small">Emergency</div></div>
          <div class="col-4"><div class="h3 mb-0">80+</div><div class="small">Clinicians</div></div>
          <div class="col-4"><div class="h3 mb-0">15+</div><div class="small">Departments</div></div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-2">Already registered?</h5>
            <p class="mb-3">Sign in and you’ll be redirected to your PMS area based on your role (Admin, Clinician, Reception, or Patient).</p>
            <a class="btn btn-success" href="<?= $baseUrl ?>/index.php?p=auth/login">Go to Login</a>
          </div>
        </div>
      </div>
    </div>

    <hr class="my-5">

    <div class="row g-4">
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
    </div>
  </div>
</section>
<?php include __DIR__ . '/../_layout_bottom.php'; ?>
