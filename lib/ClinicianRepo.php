<?php
declare(strict_types=1);

final class ClinicianRepo {
  public static function getClinicianIdByUser(PDO $pdo, int $userId): ?int {
    $stmt = $pdo->prepare("SELECT id FROM clinicians WHERE user_id = :uid LIMIT 1");
    $stmt->execute([':uid' => $userId]);
    $id = (int)($stmt->fetchColumn() ?: 0);
    return $id > 0 ? $id : null;
  }

  public static function getTodaySchedule(PDO $pdo, int $clinicianId): array {
    $sql = "SELECT
              clinician_id,
              scheduled_at,
              DATE_FORMAT(scheduled_at, '%H:%i') AS time,
              patient_name,
              reason,
              status,
              patient_id,
              appointment_id
            FROM v_clinician_schedule_today
            WHERE clinician_id = :cid
            ORDER BY scheduled_at";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':cid' => $clinicianId]);
    return $stmt->fetchAll() ?: [];
  }

  public static function getKpis(PDO $pdo, int $clinicianId, int $userId): array {
    // 1) distinct patients today
    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT patient_id)
                           FROM v_clinician_schedule_today
                           WHERE clinician_id = :cid");
    $stmt->execute([':cid' => $clinicianId]);
    $distinct = (int)($stmt->fetchColumn() ?: 0);

    // 2) next appt time today-or-later (ignoring Cancelled)
    $stmt = $pdo->prepare("SELECT DATE_FORMAT(MIN(scheduled_at), '%H:%i')
                           FROM appointments
                           WHERE clinician_id = :cid
                             AND scheduled_at >= CURRENT_DATE()
                             AND status <> 'Cancelled'");
    $stmt->execute([':cid' => $clinicianId]);
    $nextTime = (string)($stmt->fetchColumn() ?: '—');

    // 3) unread messages for this clinician’s user id
    $stmt = $pdo->prepare("SELECT COUNT(*)
                           FROM messages
                           WHERE recipient_user_id = :uid AND COALESCE(is_read,0)=0");
    $stmt->execute([':uid' => $userId]);
    $unread = (int)($stmt->fetchColumn() ?: 0);

    return [
      'distinct_patients_today' => $distinct,
      'next_appt_time'          => $nextTime,
      'unread_msgs'             => $unread,
    ];
  }
}
