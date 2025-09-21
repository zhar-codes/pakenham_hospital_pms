<?php
// PakenhamH_Web_App/lib/StubStore.php
declare(strict_types=1);

final class StubStore {
  // username => [password, role]
  private static array $USERS = [
    'admin'     => ['password' => 'admin123',   'role' => 'admin'],
    'clin'      => ['password' => 'clin123',    'role' => 'clinician'],
    'recept'    => ['password' => 'recept123',  'role' => 'reception'],
    'patient1'  => ['password' => 'patient123', 'role' => 'patient'],
  ];

  public static function getUser(string $username): ?array {
    $u = strtolower(trim($username));
    return self::$USERS[$u] ?? null;
  }

  public static function pretendCreatePatient(string $username, string $password): bool {
    return !isset(self::$USERS[strtolower($username)]);
  }
}
