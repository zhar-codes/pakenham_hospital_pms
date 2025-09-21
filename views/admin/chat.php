<?php
// /views/admin/chat.php
$title  = 'Admin · Chatbox';
$user   = $user ?? 'User Name';
$active = 'chat'; // highlights in sidebar (and top if you ever expose it)

require_once __DIR__ . '/../../includes/header.php'; // sets $routeAdmin, loads nav config
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <div class="row g-4">
      <!-- Chat main column -->
      <div class="col-lg-8">
        <!-- Thread -->
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h1 class="h6 mb-0">Chat thread</h1>
              <div class="btn-group btn-group-sm">
                <a href="<?= $routeAdmin ?>/chat.php?clear=1" class="btn btn-outline-secondary">
                  <i class="bi bi-trash"></i> Clear
                </a>
                <a href="<?= $routeAdmin ?>/chat_export.php?fmt=txt" class="btn btn-outline-secondary">
                  <i class="bi bi-download"></i> Export
                </a>
              </div>
            </div>

            <!-- Simple chat bubbles (placeholders) -->
            <div class="d-flex flex-column gap-3" style="min-height: 280px;">
              <div class="d-flex gap-2">
                <div class="badge rounded-pill text-bg-secondary align-self-start">Patient</div>
                <div class="p-3 rounded-3 border bg-light flex-fill">
                  Hello, what are the clinic hours today?
                </div>
              </div>

              <div class="d-flex gap-2 justify-content-end">
                <div class="p-3 rounded-3 border bg-white flex-fill">
                  Our outpatient clinic is open 9:00–17:00 today. Can I help with an appointment?
                </div>
                <div class="badge rounded-pill text-bg-primary align-self-start">Staff</div>
              </div>

              <div class="d-flex gap-2">
                <div class="badge rounded-pill text-bg-secondary align-self-start">Patient</div>
                <div class="p-3 rounded-3 border bg-light flex-fill">
                  Thanks! Also, where can I park?
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Composer -->
        <div class="card mt-3">
          <div class="card-body">
            <form class="row g-2 align-items-end" action="<?= $routeAdmin ?>/chat_send.php" method="post">
              <div class="col-12">
                <label for="message" class="form-label">Type a message</label>
                <textarea id="message" name="message" rows="3" class="form-control" placeholder="Write your reply…"></textarea>
              </div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary" type="submit">
                  <i class="bi bi-send"></i> Send
                </button>
                <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/chat.php">
                  Discard
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Right rail -->
      <div class="col-lg-4">
        <!-- Create ticket -->
        <div class="card">
          <div class="card-body">
            <h2 class="h6 mb-3">Create Ticket</h2>
            <form class="row g-2" action="<?= $routeAdmin ?>/ticket_new.php" method="get">
              <div class="col-12">
                <label class="form-label" for="subject">Subject</label>
                <input id="subject" name="subject" class="form-control" placeholder="Short summary">
              </div>
              <div class="col-12">
                <label class="form-label" for="priority">Priority</label>
                <select id="priority" name="priority" class="form-select">
                  <option>Low</option><option>Normal</option><option>High</option>
                </select>
              </div>
              <div class="col-12">
                <button class="btn btn-outline-primary btn-sm" type="submit">
                  <i class="bi bi-plus-lg"></i> New Ticket
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Disclaimer -->
        <div class="card mt-3">
          <div class="card-body">
            <h2 class="h6 mb-2">Disclaimer</h2>
            <p class="text-muted small mb-0">
              Chat responses provide general information and are not a substitute for professional medical advice.
              For emergencies call 000 or visit the nearest emergency department.
            </p>
          </div>
        </div>

        <!-- Quick links -->
        <div class="card mt-3">
          <div class="card-body">
            <h2 class="h6 mb-2">Quick links</h2>
            <div class="d-grid gap-2">
              <a class="btn btn-outline-secondary btn-sm" href="<?= $routeAdmin ?>/helpdesk.php">
                <i class="bi bi-question-circle"></i> Helpdesk / FAQ
              </a>
              <a class="btn btn-outline-secondary btn-sm" href="<?= $routeAdmin ?>/patients.php">
                <i class="bi bi-people"></i> Patients
              </a>
              <a class="btn btn-outline-secondary btn-sm" href="<?= $routeAdmin ?>/appointments.php">
                <i class="bi bi-calendar2-week"></i> Appointments
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
