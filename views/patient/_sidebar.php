<?php
// /views/patient/_sidebar.php
require_once __DIR__ . '/../../includes/nav.php';
$NAV = $NAV_PATIENT ?? [];
?>
<aside class="col-lg-3">
  <div class="card">
    <div class="card-body py-3">
      <div class="text-uppercase text-muted small mb-2">Patient Menu</div>
      <div class="list-group list-group-flush">
        <?php foreach ($NAV as $item): if (empty($item['side'])) continue; ?>
          <a class="list-group-item list-group-item-action <?= ($active??'')===$item['key'] ? 'active' : '' ?>"
             href="<?= $item['href'] ?>"><?= htmlspecialchars($item['label']) ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</aside>
