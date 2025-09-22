# pakenham_hospital_pms – DB how-to

## Apply order (safe, no DROPs)

USE pakenham_hospital_pms;
SOURCE db/schema/02_support_tables.sql;
SOURCE db/schema/03_views.sql;
SOURCE db/schema/04_procedures.sql;
SOURCE db/seed/02_demo_data.sql;  -- optional demo data

## Quick checks

SHOW FULL TABLES IN pakenham_hospital_pms WHERE TABLE_TYPE='VIEW';
SHOW PROCEDURE STATUS WHERE Db='pakenham_hospital_pms';
SELECT * FROM v_admin_kpis LIMIT 1;
SELECT * FROM v_patient_upcoming_appointments ORDER BY scheduled_at LIMIT 3;

## Notes
- Charset/Collation: utf8mb4 / utf8mb4_unicode_ci
- Engine: InnoDB
- App DB user: pmsapp@127.0.0.1, pmsapp@localhost (least-privilege)
- No DROPs used; scripts are re-runnable.
