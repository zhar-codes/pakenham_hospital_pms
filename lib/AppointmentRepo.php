<?php
declare(strict_types=1);

final class AppointmentRepo {
  public static function book(PDO $pdo, int $patientId, int $clinicianId, string $when, string $reason='', string $location=''): int {
    $stmt = $pdo->prepare("CALL sp_book_appointment(?, ?, ?, ?, ?)");
    $stmt->execute([$patientId, $clinicianId, $when, $reason, $location]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $stmt->closeCursor();
    return (int)($row['new_appointment_id'] ?? $row['appointment_id'] ?? $pdo->lastInsertId() ?? 0);
  }
}
