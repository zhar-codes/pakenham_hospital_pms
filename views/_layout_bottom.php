<?php
// PakenhamH_Web_App/views/_layout_bottom.php
?>
</main>

<footer class="border-top py-4 mt-5">
  <div class="container small text-muted">
    <div class="row">
      <div class="col-md">
        <strong>Pakenham Hospital</strong><br>
        123 Princes Hwy, Pakenham VIC<br>
        (03) 9000 0000
      </div>
      <div class="col-md text-md-end mt-3 mt-md-0">
        © <?= date('Y') ?> Pakenham Hospital — All rights reserved.
      </div>
    </div>
  </div>
</footer>
  </div> <!-- /.container -->

  <!-- Bootstrap JS (needed for navbar toggler, modals, etc.) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php if (!empty($_SESSION['flash'])): ?>
  <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['flash_error'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
<?php endif; ?>

</html>
