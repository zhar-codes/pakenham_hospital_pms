<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('patient');

if (!isset($pdo) || !($pdo instanceof PDO)) {
  require_once __DIR__ . '/../../config/db.php';
}
require_once __DIR__ . '/../../lib/PatientRepo.php';

$userId    = (int)($_SESSION['auth']['id'] ?? 0);
$patientId = PatientRepo::getPatientIdByUser($pdo, $userId);
if (!$patientId) {
  $_SESSION['flash_error'] = 'No patient profile linked to this account.';
  header('Location: ' . base_url() . '/index.php?p=public/login');
  exit;
}

$title  = 'Patient · My Appointments';
$active = 'pat_appts';
$menu   = 'patient';

require_once __DIR__ . '/../../includes/header.php'; // provides $routePatient, $baseUrl

$action = $_GET['action'] ?? '';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">

    <?php if ($action === 'new'): ?>
      <!-- Book appointment -->
      <div class="card">
        <div class="card-body">
          <h1 class="h6 mb-3">Book Appointment</h1>

          <form class="row g-3" action="<?= $baseUrl ?>/index.php?p=appointments/book" method="post">
            <input type="hidden" name="patient_id" value="<?= (int)$patientId ?>">

            <div class="col-md-4">
              <label class="form-label" for="clinician_id">Clinician ID</label>
              <input id="clinician_id" name="clinician_id" type="number" class="form-control" placeholder="e.g., 1" required>
            </div>

            <div class="col-md-4">
              <label class="form-label" for="scheduled_at">Date &amp; Time</label>
              <input id="scheduled_at" name="scheduled_at" type="datetime-local" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label" for="location">Location</label>
              <input id="location" name="location" type="text" class="form-control" placeholder="Main Clinic">
            </div>

            <div class="col-12">
              <label class="form-label" for="reason">Reason</label>
              <input id="reason" name="reason" type="text" class="form-control" placeholder="e.g., follow-up">
            </div>

            <div class="col-12 d-flex gap-2">
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-check2-circle"></i> Submit
              </button>
              <a class="btn btn-outline-secondary" href="<?= $routePatient ?>/appointments.php">Cancel</a>
            </div>
          </form>
        </div>
      </div>

    <?php else: ?>
      <?php
      // Load upcoming appointments from the read-only view
      $rows = [];
      try {
        $st = $pdo->prepare("
          SELECT
            appointment_id,
            DATE(scheduled_at)                         AS d,
            DATE_FORMAT(scheduled_at, '%H:%i')         AS t,
            COALESCE(location,'Main Clinic')           AS location,
            COALESCE(status,'Scheduled')               AS status,
            clinician_name
          FROM v_patient_upcoming_appointments
          WHERE patient_id = :pid
          ORDER BY scheduled_at ASC
          LIMIT 50
        ");
        $st->execute([':pid' => (int)$patientId]);
        $rows = $st->fetchAll() ?: [];
      } catch (Throwable $e) {
        $_SESSION['flash_error'] = 'Failed to load appointments: ' . $e->getMessage();
      }
      ?>
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h1 class="h6 mb-0">My Appointments</h1>
            <a class="btn btn-primary btn-sm" href="<?= $routePatient ?>/appointments.php?action=new">
              <i class="bi bi-calendar-plus"></i> Book Appointment
            </a>
          </div>

          <div class="table-responsive">
            <table class="table align-middle">
              <thead class="table-light">
                <tr>
                  <th style="width:130px;">Date</th>
                  <th style="width:110px;">Time</th>
                  <th>Doctor</th>
                  <th style="width:160px;">Location</th>
                  <th style="width:120px;">Status</th>
                  <th class="text-end" style="width:120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($rows): ?>
                  <?php foreach ($rows as $r): ?>
                    <tr>
                      <td><?= htmlspecialchars($r['d']) ?></td>
                      <td><?= htmlspecialchars($r['t']) ?></td>
                      <td><?= htmlspecialchars($r['clinician_name'] ?? '—') ?></td>
                      <td><?= htmlspecialchars($r['location']) ?></td>
                      <td><span class="badge bg-secondary"><?= htmlspecialchars($r['status']) ?></span></td>
                      <td class="text-end">
                        <div class="btn-group btn-group-sm">
                          <a class="btn btn-outline-secondary" href="#"><i class="bi bi-eye"></i></a>
                          <a class="btn btn-outline-secondary" href="#"><i class="bi bi-pencil"></i></a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="6" class="text-muted">No upcoming appointments.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
