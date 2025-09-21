<?php
// /views/admin/settings.php
$title  = 'Admin · Settings';
$user   = $user ?? 'User Name';
$active = 'settings';

require_once __DIR__ . '/../../includes/header.php'; // sets $routeAdmin & loads nav
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Privacy notice / Disclaimer -->
    <div class="card mb-4">
      <div class="card-body">
        <h1 class="h6 mb-3">Privacy notice / Disclaimer</h1>
        <form class="row g-3" method="post" action="<?= $routeAdmin ?>/settings_save.php#privacy">
          <div class="col-12">
            <label for="privacy" class="form-label">Message shown to patients</label>
            <textarea id="privacy" name="privacy" class="form-control" rows="5"
              placeholder="This service provides general information and does not replace professional medical advice. In an emergency call 000."></textarea>
          </div>
          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
            <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/settings.php#privacy">Reset</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Chatbox: Confidence threshold -->
    <div class="card mb-4">
      <div class="card-body">
        <h2 class="h6 mb-3">Chatbox · Confidence threshold</h2>
        <form class="row g-3" method="post" action="<?= $routeAdmin ?>/settings_save.php#chatbox">
          <div class="col-md-8">
            <label for="confidence" class="form-label d-flex justify-content-between">
              <span>Minimum confidence to auto-answer</span>
              <span class="text-muted small" id="confLabel">0.70</span>
            </label>
            <input type="range" class="form-range" min="0" max="1" step="0.01" id="confidence" name="chat_confidence" value="0.70"
              oninput="document.getElementById('confLabel').textContent=this.value">
            <div class="form-text">
              Below this value, the chatbox will suggest escalation or creating a ticket.
            </div>
          </div>
          <div class="col-md-4">
            <label class="form-label">When below threshold</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="escSuggest" name="chat_suggest_escalation" checked>
              <label class="form-check-label" for="escSuggest">Suggest escalation</label>
            </div>
            <div class="form-check mt-1">
              <input class="form-check-input" type="checkbox" id="autoTicket" name="chat_autoticket">
              <label class="form-check-label" for="autoTicket">Offer ticket creation</label>
            </div>
          </div>
          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
            <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/settings.php#chatbox">Reset</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Password policy & Escalation toggle -->
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h6 mb-3">Password policy</h2>
            <form class="row g-3" method="post" action="<?= $routeAdmin ?>/settings_save.php#password">
              <div class="col-12">
                <label for="minLen" class="form-label">Minimum length</label>
                <input id="minLen" name="pw_min_len" type="number" min="8" max="128" value="10" class="form-control">
              </div>
              <div class="col-12">
                <label for="complexity" class="form-label">Complexity</label>
                <select id="complexity" name="pw_complexity" class="form-select">
                  <option value="basic">Letters & numbers</option>
                  <option value="mixed" selected>Mixed case + numbers</option>
                  <option value="strong">Mixed case + numbers + symbols</option>
                </select>
              </div>
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="pwExpire" name="pw_expire">
                  <label class="form-check-label" for="pwExpire">Expire passwords every 90 days</label>
                </div>
              </div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
                <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/settings.php#password">Reset</a>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h6 mb-3">Escalation</h2>
            <form class="row g-3" method="post" action="<?= $routeAdmin ?>/settings_save.php#escalation">
              <div class="col-12">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="escEnable" name="escalation_enabled" checked>
                  <label class="form-check-label" for="escEnable">Enable escalation to human support</label>
                </div>
              </div>
              <div class="col-12">
                <label for="escSLA" class="form-label">Target first response (minutes)</label>
                <input id="escSLA" name="escalation_sla" type="number" min="1" value="15" class="form-control">
                <div class="form-text">Used to alert if no staff reply within the SLA.</div>
              </div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
                <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/settings.php#escalation">Reset</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Session timeout -->
    <div class="card mt-4">
      <div class="card-body">
        <h2 class="h6 mb-3">Session timeout</h2>
        <form class="row g-3" method="post" action="<?= $routeAdmin ?>/settings_save.php#session">
          <div class="col-md-6">
            <label for="timeout" class="form-label">Auto-logout after (minutes)</label>
            <input id="timeout" name="session_timeout" type="number" min="5" max="480" value="30" class="form-control">
          </div>
          <div class="col-md-6">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" id="warnBefore" name="session_warn" checked>
              <label class="form-check-label" for="warnBefore">Warn user 2 minutes before logout</label>
            </div>
          </div>
          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
            <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/settings.php#session">Reset</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
