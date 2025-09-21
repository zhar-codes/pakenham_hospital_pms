<?php
// /views/admin/helpdesk.php
$title  = 'Admin · Helpdesk (FAQ)';
$user   = $user ?? 'User Name';
$active = 'helpdesk';

require_once __DIR__ . '/../../includes/header.php'; // sets $baseUrl, $routeAdmin and loads /includes/nav.php
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Tags -->
    <div class="card mb-4">
      <div class="card-body">
        <h1 class="h6 mb-3">Tags</h1>
        <div class="d-flex flex-wrap gap-2">
          <a href="<?= $routeAdmin ?>/helpdesk.php?tag=all"         class="btn btn-outline-secondary btn-sm">All</a>
          <a href="<?= $routeAdmin ?>/helpdesk.php?tag=accounts"    class="btn btn-outline-secondary btn-sm">Accounts</a>
          <a href="<?= $routeAdmin ?>/helpdesk.php?tag=appointments"class="btn btn-outline-secondary btn-sm">Appointments</a>
          <a href="<?= $routeAdmin ?>/helpdesk.php?tag=billing"     class="btn btn-outline-secondary btn-sm">Billing</a>
          <a href="<?= $routeAdmin ?>/helpdesk.php?tag=technical"   class="btn btn-outline-secondary btn-sm">Technical</a>
        </div>
      </div>
    </div>

    <!-- Search -->
    <div class="card mb-4">
      <div class="card-body">
        <form class="row g-3" method="get" action="<?= $routeAdmin ?>/helpdesk.php">
          <div class="col-md-9">
            <label for="q" class="form-label">Search FAQs</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input id="q" name="q" class="form-control" placeholder="Type keywords…"
                     value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Search</button>
          </div>
        </form>
      </div>
    </div>

    <!-- FAQ list -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h2 class="h6 mb-0">FAQ List</h2>
          <a class="btn btn-outline-secondary btn-sm" href="<?= $routeAdmin ?>/helpdesk_new.php">
            <i class="bi bi-plus-lg"></i> New FAQ
          </a>
        </div>

        <div class="accordion" id="faqAcc">
          <!-- Item 1 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="q1h">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1c" aria-expanded="true" aria-controls="q1c">
                How do I reset a patient portal password?
              </button>
            </h2>
            <div id="q1c" class="accordion-collapse collapse show" aria-labelledby="q1h" data-bs-parent="#faqAcc">
              <div class="accordion-body">
                Go to <em>Patients → View</em>, open the patient profile, and click <strong>Reset Portal Password</strong>. The patient receives an email with a reset link.
              </div>
            </div>
          </div>

          <!-- Item 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="q2h">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2c" aria-expanded="false" aria-controls="q2c">
                How can I reschedule an appointment?
              </button>
            </h2>
            <div id="q2c" class="accordion-collapse collapse" aria-labelledby="q2h" data-bs-parent="#faqAcc">
              <div class="accordion-body">
                Go to <em>Appointments</em>, select the appointment, click <strong>Edit</strong>, change the date/time, and save. The system notifies the patient automatically.
              </div>
            </div>
          </div>

          <!-- Item 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="q3h">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3c" aria-expanded="false" aria-controls="q3c">
                Where do I view billing statements?
              </button>
            </h2>
            <div id="q3c" class="accordion-collapse collapse" aria-labelledby="q3h" data-bs-parent="#faqAcc">
              <div class="accordion-body">
                Open <em>Reports</em> and choose <strong>Billing</strong>. You can filter by date range and export CSV.
              </div>
            </div>
          </div>

          <!-- Placeholder items -->
          <?php for ($i=4; $i<=6; $i++): ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="qh<?= $i ?>">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qc<?= $i ?>" aria-expanded="false" aria-controls="qc<?= $i ?>">
                — Question placeholder
              </button>
            </h2>
            <div id="qc<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="qh<?= $i ?>" data-bs-parent="#faqAcc">
              <div class="accordion-body">Answer placeholder text.</div>
            </div>
          </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
