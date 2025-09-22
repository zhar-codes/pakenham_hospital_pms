-- 03_views.sql
-- Project: pakenham_hospital_pms
-- Read-only views for dashboards/ops.

USE pakenham_hospital_pms;

-- Admin KPIs (today)
CREATE OR REPLACE VIEW v_admin_kpis AS
SELECT
  CURDATE() AS kpi_date,
  (SELECT COUNT(*) FROM visits v
     WHERE v.checkin_time >= CURDATE()
       AND v.checkin_time <  CURDATE() + INTERVAL 1 DAY) AS arrivals_today,
  (SELECT COUNT(*) FROM appointments a
     WHERE a.scheduled_at >= CURDATE()
       AND a.scheduled_at <  CURDATE() + INTERVAL 1 DAY) AS appts_today,
  (SELECT COUNT(*) FROM tickets t WHERE t.status='Open') AS open_tickets;

-- Clinician schedule (today)
CREATE OR REPLACE VIEW v_clinician_schedule_today AS
SELECT
  a.clinician_id,
  a.id            AS appointment_id,
  a.scheduled_at,
  a.status,
  a.patient_id,
  TRIM(CONCAT(COALESCE(p.first_name,''),' ',COALESCE(p.last_name,''))) AS patient_name
FROM appointments a
JOIN patients p ON p.id = a.patient_id
WHERE a.scheduled_at >= CURDATE()
  AND a.scheduled_at <  CURDATE() + INTERVAL 1 DAY
ORDER BY a.clinician_id, a.scheduled_at;

-- Reception arrivals (today)
CREATE OR REPLACE VIEW v_reception_arrivals_today AS
SELECT
  v.id AS visit_id,
  v.patient_id,
  TRIM(CONCAT(COALESCE(p.first_name,''),' ',COALESCE(p.last_name,''))) AS patient_name,
  v.clinician_id,
  TRIM(CONCAT(COALESCE(c.first_name,''),' ',COALESCE(c.last_name,''))) AS clinician_name,
  v.checkin_time
FROM visits v
JOIN patients   p ON p.id = v.patient_id
JOIN clinicians c ON c.id = v.clinician_id
WHERE v.checkin_time >= CURDATE()
  AND v.checkin_time <  CURDATE() + INTERVAL 1 DAY
ORDER BY v.checkin_time;

-- Patient upcoming appointments (>= now)
CREATE OR REPLACE VIEW v_patient_upcoming_appointments AS
SELECT
  a.patient_id,
  a.id           AS appointment_id,
  a.scheduled_at,
  a.status,
  a.clinician_id,
  TRIM(CONCAT(COALESCE(c.first_name,''),' ',COALESCE(c.last_name,''))) AS clinician_name
FROM appointments a
JOIN clinicians c ON c.id = a.clinician_id
WHERE a.scheduled_at >= NOW()
ORDER BY a.patient_id, a.scheduled_at;
