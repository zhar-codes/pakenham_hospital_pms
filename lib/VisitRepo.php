<?php
declare(strict_types=1);

final class VisitRepo {
  /** Returns new visit id (int) after check-in by appointment */
  public static function checkInByAppointment(PDO $pdo, int $appointmentId, string $note = ''): int {
    $stmt = $pdo->prepare("CALL sp_checkin_patient(?, NULL, NULL, ?)");
    $stmt->execute([$appointmentId, $note]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $stmt->closeCursor();
    $id = (int)($row['new_visit_id'] ?? $row['visit_id'] ?? 0);
    if ($id <= 0) $id = (int)$pdo->lastInsertId();
    return $id;
  }

  /** Returns new visit id (int) after check-in by patient+clinician */
  public static function checkInByPatientClinician(PDO $pdo, int $patientId, int $clinicianId, string $note = ''): int {
    $stmt = $pdo->prepare("CALL sp_checkin_patient(NULL, ?, ?, ?)");
    $stmt->execute([$patientId, $clinicianId, $note]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $stmt->closeCursor();
    $id = (int)($row['new_visit_id'] ?? $row['visit_id'] ?? 0);
    if ($id <= 0) $id = (int)$pdo->lastInsertId();
    return $id;
  }

  /** Completes a visit; returns row with visit_id/checkin_time/checkout_time */
  public static function complete(PDO $pdo, int $visitId, string $note = ''): array {
    $stmt = $pdo->prepare("CALL sp_complete_visit(?, ?)");
    $stmt->execute([$visitId, $note]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $stmt->closeCursor();
    return $row ?: ['visit_id' => $visitId];
  }

  /** Today’s arrivals from read-only view */
  public static function arrivalsToday(PDO $pdo): array {
    $stmt = $pdo->query("
      SELECT checkin_time, patient_name, clinician_name, status, notes
      FROM v_reception_arrivals_today
      ORDER BY checkin_time DESC
      LIMIT 200
    ");
    return $stmt->fetchAll() ?: [];
  }

  /** Map of patient_id => open visit_id for this clinician today */
  public static function openVisitsForClinicianToday(PDO $pdo, int $clinicianId): array {
    $sql = "SELECT patient_id, id AS visit_id
            FROM visits
            WHERE clinician_id = :cid
              AND DATE(checkin_time) = CURRENT_DATE()
              AND checkout_time IS NULL
            ORDER BY checkin_time DESC, id DESC";
    $st = $pdo->prepare($sql);
    $st->execute([':cid' => $clinicianId]);
    $map = [];
    foreach ($st->fetchAll() as $r) {
      $map[(int)$r['patient_id']] = (int)$r['visit_id']; // latest per patient
    }
    return $map;
  }
}
