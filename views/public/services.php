<?php
$title = 'Services — Pakenham Hospital';
include __DIR__ . '/../_layout_top.php';
?>
<h1 class="mb-3">Services</h1>
<ul class="list-group mb-3">
  <li class="list-group-item">Emergency Department (24/7)</li>
  <li class="list-group-item">General Practice &amp; Outpatients</li>
  <li class="list-group-item">Maternity &amp; Neonatal Care</li>
  <li class="list-group-item">Pathology &amp; Diagnostic Imaging</li>
  <li class="list-group-item">Surgery &amp; Day Procedures</li>
  <li class="list-group-item">Allied Health (Physio, OT, Dietetics)</li>
</ul>
<p class="text-muted">For appointments, please use the <a href="<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?>/index.php?p=auth/login">patient portal</a>.</p>
<?php include __DIR__ . '/../_layout_bottom.php'; ?>
