<?php
declare(strict_types=1);

final class DashboardRepo {
    public static function getAdminKpis(PDO $pdo): array {
        $row = $pdo->query("SELECT * FROM v_admin_kpis LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        return $row ?: [
            'kpi_date'       => date('Y-m-d'),
            'arrivals_today' => 0,
            'appts_today'    => 0,
            'open_tickets'   => 0,
        ];
    }
}
