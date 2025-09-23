<?php
declare(strict_types=1);

final class PatientRepo {
  public static function getPatientIdByUser(PDO $pdo, int $userId): ?int {
    $stmt = $pdo->prepare("SELECT id FROM patients WHERE user_id = :uid LIMIT 1");
    $stmt->execute([':uid' => $userId]);
    $id = (int)($stmt->fetchColumn() ?: 0);
    return $id > 0 ? $id : null;
  }

  /** Returns upcoming appointments from the view */
  public static function upcoming(PDO $pdo, int $patientId): array {
    $sql = "
      SELECT
        appointment_id,
        patient_id,
        clinician_id,
        clinician_name,
        scheduled_at,
        DATE_FORMAT(scheduled_at, '%Y-%m-%d') AS day,
        DATE_FORMAT(scheduled_at, '%H:%i')     AS time,
        status
      FROM v_patient_upcoming_appointments
      WHERE patient_id = :pid
      ORDER BY scheduled_at
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':pid' => $patientId]);
    return $stmt->fetchAll() ?: [];
  }
}
