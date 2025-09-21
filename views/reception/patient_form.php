<?php
$title  = 'Reception · Patient Form';
$user   = $user ?? 'User Name';
$active = 'patients';
$menu   = 'reception';
require_once __DIR__ . '/../../includes/header.php';
$id = $_GET['id'] ?? null; // edit if present
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>
  <section class="col-lg-9">
    <div class="card"><div class="card-body">
      <h1 class="h6 mb-3"><?= $id ? 'Edit' : 'New' ?> Patient</h1>
      <form class="row g-3" method="post" action="<?= $routeReception ?>/patients.php">
        <div class="col-md-6"><label class="form-label" for="first">First name</label><input id="first" name="first" class="form-control"></div>
        <div class="col-md-6"><label class="form-label" for="last">Last name</label><input id="last" name="last" class="form-control"></div>
        <div class="col-md-4"><label class="form-label" for="dob">DOB</label><input id="dob" name="dob" type="date" class="form-control"></div>
        <div class="col-md-4"><label class="form-label" for="phone">Phone</label><input id="phone" name="phone" class="form-control"></div>
        <div class="col-md-4"><label class="form-label" for="email">Email</label><input id="email" name="email" type="email" class="form-control"></div>
        <div class="col-12"><label class="form-label" for="address">Address</label><input id="address" name="address" class="form-control"></div>
        <div class="col-12"><label class="form-label" for="notes">Notes</label><textarea id="notes" name="notes" rows="4" class="form-control"></textarea></div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle"></i> Save</button>
          <a class="btn btn-outline-secondary" href="<?= $routeReception ?>/patients.php">Cancel</a>
        </div>
      </form>
    </div></div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
