<?php // expects: $NAV (reception), $active, $brandLogo ?>
<aside class="col-lg-3">
  <div class="card shadow-sm sidebar-card mb-4">
    <div class="card-body py-3 d-flex align-items-center gap-2">
      <img src="<?= htmlspecialchars($brandLogo) ?>" alt="Logo" class="brand-logo-sidebar">
      <div class="text-muted small fw-semibold mb-0">RECEPTION MENU</div>
    </div>
    <div class="list-group list-group-flush">
      <?php foreach (($NAV ?? []) as $item): if (empty($item['side'])) continue; ?>
        <a class="list-group-item list-group-item-action <?= ($active ?? '') === $item['key'] ? 'active' : '' ?>"
           href="<?= $item['href'] ?>"><?= htmlspecialchars($item['label']) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</aside>
