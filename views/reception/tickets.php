<?php
// /views/reception/tickets.php
$title  = 'Reception · Tickets';
$user   = $user ?? 'User Name';
$active = 'tickets';     // highlight in sidebar
$menu   = 'reception';   // top nav: reception

require_once __DIR__ . '/../../includes/header.php';
$q = trim($_GET['q'] ?? '');
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <form class="row g-3 align-items-end" method="get" action="<?= $routeReception ?>/tickets.php">
          <div class="col-md-6">
            <label for="q" class="form-label">Search</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input id="q" name="q" class="form-control" placeholder="Subject, patient…" value="<?= htmlspecialchars($q) ?>">
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label" for="status">Status</label>
            <select id="status" name="status" class="form-select">
              <option value="">All</option>
              <option>Open</option>
              <option>Pending</option>
              <option>Resolved</option>
            </select>
          </div>
          <div class="col-md-3 d-flex">
            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-funnel"></i> Apply</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tickets list -->
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th style="width:80px;">#</th>
                <th>Subject</th>
                <th style="width:160px;">Patient</th>
                <th style="width:120px;">Status</th>
                <th style="width:100px;">Age</th>
                <th class="text-end" style="width:140px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=101; $i<=106; $i++): ?>
              <tr>
                <td><?= $i ?></td>
                <td>—</td>
                <td><a href="<?= $routeReception ?>/patients.php?id=<?= $i ?>">—</a></td>
                <td><span class="badge bg-secondary">Open</span></td>
                <td>—</td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm">
                    <a class="btn btn-outline-secondary" href="#"><i class="bi bi-eye"></i></a>
                    <a class="btn btn-outline-primary" href="#"><i class="bi bi-chat-left-text"></i></a>
                  </div>
                </td>
              </tr>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
