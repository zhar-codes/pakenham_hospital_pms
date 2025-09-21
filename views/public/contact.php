<?php
$title = 'Contact — Pakenham Hospital';
include __DIR__ . '/../_layout_top.php';
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
?>
<h1 class="mb-3">Contact</h1>
<div class="row g-4">
  <div class="col-md-6">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h5 class="card-title">General Enquiries</h5>
        <p class="mb-1"><strong>Phone:</strong> (03) 9000 0000</p>
        <p class="mb-1"><strong>Hours:</strong> Weekdays 8am–6pm</p>
        <p class="mb-0"><strong>Address:</strong> 123 Princes Hwy, Pakenham VIC</p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Patient Portal</h5>
        <p>Existing patients can message care teams and manage bookings.</p>
        <a class="btn btn-primary" href="<?= $baseUrl ?>/index.php?p=auth/login">Open Login</a>
        <a class="btn btn-outline-primary ms-2" href="<?= $baseUrl ?>/index.php?p=public/register">Register</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../_layout_bottom.php'; ?>
