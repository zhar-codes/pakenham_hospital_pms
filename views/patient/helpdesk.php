<?php
// /views/patient/helpdesk.php
$title  = 'Patient · Helpdesk';
$user   = $user ?? 'User Name';
$active = 'pat_helpdesk';   // highlight in patient menu
$menu   = 'patient';        // use patient top nav

require_once __DIR__ . '/../../includes/header.php'; // sets $routePatient & loads nav
$q = trim($_GET['q'] ?? '');
$tag = $_GET['tag'] ?? '';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <div class="row g-4">
      <!-- LEFT column: chat -->
      <div class="col-lg-7">
        <!-- Tags -->
        <div class="card mb-4">
          <div class="card-body">
            <form class="d-flex flex-wrap gap-2 align-items-center" method="get" action="<?= $routePatient ?>/helpdesk.php">
              <div class="text-muted small me-1">Tags:</div>
              <?php
                $tags = ['All','Appointments','Billing','Technical'];
                foreach ($tags as $t):
                  $is = (strtolower($tag)===strtolower($t) || ($t==='All' && !$tag));
              ?>
                <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
                <button class="btn btn-sm <?= $is?'btn-primary':'btn-outline-secondary' ?>" name="tag" value="<?= $t ?>" type="submit">
                  <?= $t ?>
                </button>
              <?php endforeach; ?>
            </form>
          </div>
        </div>

        <!-- Chat thread -->
        <div class="card mb-4">
          <div class="card-body">
            <h1 class="h6 mb-3">Chat</h1>

            <div class="d-flex flex-column gap-3" style="max-height: 360px; overflow:auto;">
              <div class="d-flex gap-2">
                <div class="badge rounded-pill text-bg-secondary align-self-start">You</div>
                <div class="p-3 rounded-3 border bg-light flex-fill">
                  — Your question will appear here.
                </div>
              </div>

              <div class="d-flex gap-2 justify-content-end">
                <div class="p-3 rounded-3 border bg-white flex-fill">
                  — Assistant reply placeholder.
                </div>
                <div class="badge rounded-pill text-bg-primary align-self-start">Helpdesk</div>
              </div>
            </div>

            <!-- Composer -->
            <form class="row g-2 align-items-end mt-3" action="<?= $routePatient ?>/helpdesk_send.php" method="post">
              <div class="col-12">
                <label class="form-label" for="msg">Type a question…</label>
                <textarea id="msg" name="msg" rows="3" class="form-control" placeholder="e.g., How do I reschedule my appointment?"></textarea>
              </div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i> Send</button>
                <a class="btn btn-outline-secondary" href="<?= $routePatient ?>/helpdesk.php">Clear</a>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- RIGHT column: search + FAQs + ticket/disclaimer -->
      <div class="col-lg-5">
        <!-- Search FAQs -->
        <div class="card mb-4">
          <div class="card-body">
            <form class="row g-2" method="get" action="<?= $routePatient ?>/helpdesk.php">
              <div class="col-12">
                <label for="q" class="form-label">Search FAQs</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input id="q" name="q" class="form-control" placeholder="Type keywords…" value="<?= htmlspecialchars($q) ?>">
                </div>
              </div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="bi bi-funnel"></i> Apply</button>
                <a class="btn btn-outline-secondary" href="<?= $routePatient ?>/helpdesk.php">Reset</a>
              </div>
            </form>
          </div>
        </div>

        <!-- FAQ list (accordion) -->
        <div class="card mb-4">
          <div class="card-body">
            <h2 class="h6 mb-3">FAQ List</h2>
            <div class="accordion" id="faq">
              <?php for ($i=1; $i<=3; $i++): ?>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="h<?= $i ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c<?= $i ?>">
                      — Question placeholder
                    </button>
                  </h2>
                  <div id="c<?= $i ?>" class="accordion-collapse collapse" data-bs-parent="#faq">
                    <div class="accordion-body">
                      Answer placeholder text. Keep as wireframe only.
                    </div>
                  </div>
                </div>
              <?php endfor; ?>
            </div>
          </div>
        </div>

        <!-- Create ticket -->
        <div class="card mb-4">
          <div class="card-body">
            <h2 class="h6 mb-2">If not found → Create ticket</h2>
            <p class="text-muted small mb-3">Our team will follow up by email or phone.</p>
            <a class="btn btn-outline-secondary w-100" href="<?= $routePatient ?>/ticket_new.php">
              <i class="bi bi-ticket-detailed"></i> Create support ticket
            </a>
          </div>
        </div>

        <!-- Disclaimer -->
        <div class="card">
          <div class="card-body">
            <h2 class="h6 mb-2">Disclaimer</h2>
            <p class="text-muted small mb-0">
              This helpdesk provides general information only and does not replace professional medical advice.
              If you are experiencing an emergency, call <strong>000</strong>.
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
