<?php
// Admin sidebar (no logo)
// Uses $NAV (from header.php) and $active. Falls back to static list if needed.

$items = [];
if (!empty($NAV)) {
  foreach ($NAV as $i) if (!empty($i['side'])) $items[] = $i;
}
if (empty($items)) { // fallback
  $items = [
    ['key'=>'dashboard','label'=>'Dashboard','href'=>$routeAdmin.'/dashboard.php'],
    ['key'=>'appointments','label'=>'Appointments','href'=>$routeAdmin.'/appointments.php'],
    ['key'=>'patients','label'=>'Patients','href'=>$routeAdmin.'/patients.php'],
    ['key'=>'arrivals','label'=>'Arrivals','href'=>$routeAdmin.'/arrivals.php'],
    ['key'=>'helpdesk','label'=>'Helpdesk (FAQ)','href'=>$routeAdmin.'/helpdesk.php'],
    ['key'=>'chatbox','label'=>'Chatbox','href'=>$routeAdmin.'/chatbox.php'],
    ['key'=>'tickets','label'=>'Tickets','href'=>$routeAdmin.'/tickets.php'],
    ['key'=>'audit','label'=>'Audit','href'=>$routeAdmin.'/audit.php'],
    ['key'=>'reports','label'=>'Reports','href'=>$routeAdmin.'/reports.php'],
    ['key'=>'profile','label'=>'Profile','href'=>$routeAdmin.'/profile.php'],
    ['key'=>'settings','label'=>'Settings','href'=>$routeAdmin.'/settings.php'],
  ];
}
?>
<aside class="col-lg-3">
  <div class="card shadow-sm sidebar-card mb-4">
    <div class="card-body py-3">
      <div class="text-muted small fw-semibold">ADMIN MENU</div>
    </div>
    <div class="list-group list-group-flush">
      <?php foreach ($items as $it): ?>
        <a class="list-group-item list-group-item-action <?= ($active??'')===$it['key'] ? 'active' : '' ?>"
           href="<?= $it['href'] ?>"><?= htmlspecialchars($it['label']) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</aside>
