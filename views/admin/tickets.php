<?php
// /views/admin/tickets.php
$title  = 'Admin · Tickets';
$user   = $user ?? 'User Name';
$active = 'tickets';

require_once __DIR__ . '/../../includes/header.php'; // sets $routeAdmin & loads nav
$status  = $_GET['status']  ?? '';
$assignee= $_GET['assignee']?? '';
$q       = trim($_GET['q'] ?? '');
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <div class="row g-4">
      <!-- LEFT: Filters + list -->
      <div class="col-lg-7">
        <!-- Filters -->
        <div class="card mb-4">
          <div class="card-body">
            <form class="row g-3 align-items-end" method="get" action="<?= $routeAdmin ?>/tickets.php">
              <div class="col-md-5">
                <label class="form-label" for="q">Search</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input id="q" name="q" class="form-control" placeholder="Subject, patient…" value="<?= htmlspecialchars($q) ?>">
                </div>
              </div>
              <div class="col-md-3">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-select">
                  <option value="">All</option>
                  <option <?= $status==='Open'?'selected':'' ?>>Open</option>
                  <option <?= $status==='Pending'?'selected':'' ?>>Pending</option>
                  <option <?= $status==='Closed'?'selected':'' ?>>Closed</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label" for="assignee">Assignee</label>
                <select id="assignee" name="assignee" class="form-select">
                  <option value="">Any</option>
                  <option <?= $assignee==='Me'?'selected':'' ?>>Me</option>
                  <option <?= $assignee==='Unassigned'?'selected':'' ?>>Unassigned</option>
                </select>
              </div>
              <div class="col-md-1 d-grid">
                <button class="btn btn-primary"><i class="bi bi-funnel"></i></button>
              </div>
            </form>
          </div>
        </div>

        <!-- Tickets table -->
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h1 class="h6 mb-0">Tickets</h1>
              <a class="btn btn-outline-secondary btn-sm" href="<?= $routeAdmin ?>/ticket_new.php">
                <i class="bi bi-plus-lg"></i> New Ticket
              </a>
            </div>

            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width:70px;">#</th>
                    <th>Subject</th>
                    <th style="width:160px;">Patient</th>
                    <th style="width:110px;">Status</th>
                    <th style="width:90px;">Age</th>
                  </tr>
                </thead>
                <tbody>
                  <?php for ($i=101; $i<=106; $i++): ?>
                  <tr>
                    <td><a href="<?= $routeAdmin ?>/tickets.php?sel=<?= $i ?>" class="link-secondary">#<?= $i ?></a></td>
                    <td><a href="<?= $routeAdmin ?>/tickets.php?sel=<?= $i ?>">— Subject placeholder</a></td>
                    <td>—</td>
                    <td><span class="badge bg-secondary">Open</span></td>
                    <td>—</td>
                  </tr>
                  <?php endfor; ?>
                </tbody>
              </table>
            </div>

            <!-- Pagination (placeholder) -->
            <nav aria-label="Tickets pagination" class="mt-3">
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><span class="page-link">Prev</span></li>
                <li class="page-item active"><span class="page-link">1</span></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>

      <!-- RIGHT: Detail panel -->
      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h2 class="h6 mb-0">Ticket Details</h2>
              <div class="btn-group btn-group-sm">
                <a class="btn btn-outline-secondary" href="#"><i class="bi bi-arrow-clockwise"></i></a>
                <a class="btn btn-outline-secondary" href="#"><i class="bi bi-download"></i></a>
              </div>
            </div>

            <!-- Header -->
            <div class="border rounded p-3 mb-3">
              <div class="d-flex justify-content-between">
                <div>
                  <div class="text-muted small">Ticket</div>
                  <div class="fw-semibold">#<?= htmlspecialchars($_GET['sel'] ?? '—') ?></div>
                </div>
                <div>
                  <span class="badge bg-secondary">Open</span>
                </div>
              </div>
              <div class="mt-2 text-muted small">
                Patient: <span class="text-body">—</span> • Created: — • Assignee: —
              </div>
            </div>

            <!-- Messages -->
            <div class="d-flex flex-column gap-3" style="max-height: 280px; overflow:auto;">
              <div class="d-flex gap-2">
                <div class="badge rounded-pill text-bg-secondary align-self-start">Patient</div>
                <div class="p-3 rounded-3 border bg-light flex-fill">
                  — Initial message placeholder.
                </div>
              </div>

              <div class="d-flex gap-2 justify-content-end">
                <div class="p-3 rounded-3 border bg-white flex-fill">
                  — Staff reply placeholder.
                </div>
                <div class="badge rounded-pill text-bg-primary align-self-start">Staff</div>
              </div>
            </div>

            <!-- Reply composer -->
            <form class="row g-2 align-items-end mt-3" action="<?= $routeAdmin ?>/ticket_reply.php" method="post">
              <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['sel'] ?? '') ?>">
              <div class="col-12">
                <label class="form-label" for="reply">Reply</label>
                <textarea id="reply" name="reply" rows="3" class="form-control" placeholder="Type your reply…"></textarea>
              </div>
              <div class="col-12">
                <label class="form-label" for="canned">Canned reply</label>
                <select id="canned" name="canned" class="form-select">
                  <option value="">— Select a template —</option>
                  <option value="thanks">Thanks, we’re on it</option>
                  <option value="followup">Need more info</option>
                  <option value="resolved">Marked as resolved</option>
                </select>
              </div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i> Send</button>
                <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/tickets.php">Discard</a>
                <div class="ms-auto btn-group">
                  <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/ticket_assign.php?id=<?= htmlspecialchars($_GET['sel'] ?? '') ?>"><i class="bi bi-person-check"></i> Assign</a>
                  <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/ticket_status.php?id=<?= htmlspecialchars($_GET['sel'] ?? '') ?>&to=Closed"><i class="bi bi-check2-circle"></i> Close</a>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
