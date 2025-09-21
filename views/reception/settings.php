<?php
$title  = 'Reception · Settings';
$user   = $user ?? 'User Name';
$active = 'settings';
$menu   = 'reception';
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>
  <section class="col-lg-9">
    <div class="row g-4">
      <div class="col-md-6"><div class="card h-100"><div class="card-body">
        <h1 class="h6 mb-3">Privacy Notice / Disclaimer</h1>
        <div class="form-floating"><textarea class="form-control" id="privacy" style="height:160px">—</textarea><label for="privacy">Text</label></div>
        <div class="mt-3"><button class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Save</button></div>
      </div></div></div>

      <div class="col-md-6"><div class="card h-100"><div class="card-body">
        <h2 class="h6 mb-3">Session Timeout</h2>
        <label class="form-label" for="timeout">Minutes</label>
        <input id="timeout" type="number" min="5" step="5" class="form-control" value="30">
        <div class="form-text">Users will be signed out after inactivity.</div>
        <div class="mt-3"><button class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Save</button></div>
      </div></div></div>

      <div class="col-md-6"><div class="card h-100"><div class="card-body">
        <h2 class="h6 mb-3">Escalation Toggle</h2>
        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="escalation"><label class="form-check-label" for="escalation">Auto escalate overdue tickets</label></div>
        <div class="mt-3"><button class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Save</button></div>
      </div></div></div>

      <div class="col-md-6"><div class="card h-100"><div class="card-body">
        <h2 class="h6 mb-3">Notifications</h2>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="sms"><label class="form-check-label" for="sms">SMS reminders to patients</label></div>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="email"><label class="form-check-label" for="email">Email confirmations to patients</label></div>
        <div class="mt-3"><button class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Save</button></div>
      </div></div></div>
    </div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
