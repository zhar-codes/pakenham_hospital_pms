-- 02_demo_data.sql
-- Tiny demo rows for support tables

USE pakenham_hospital_pms;

-- pick some existing ids safely
SET @any_user      := (SELECT id FROM users      ORDER BY id LIMIT 1);
SET @any_user2     := (SELECT id FROM users      ORDER BY id LIMIT 1 OFFSET 1);
SET @any_patient   := (SELECT id FROM patients   ORDER BY id LIMIT 1);
SET @any_clinician := (SELECT id FROM clinicians ORDER BY id LIMIT 1);

-- guard: if we don't have the basics yet, stop (prevents FK errors)
DO CASE
  WHEN @any_user IS NULL OR @any_patient IS NULL OR @any_clinician IS NULL THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Seed prerequisites missing (need at least 1 user, patient, clinician)';
  ELSE 0
END;

-- tickets: one open, one assigned
INSERT INTO tickets (patient_id, opened_by, assigned_to, subject, status, priority)
VALUES
(@any_patient, @any_user,  NULL,        'Portal login help',       'Open',   'Normal'),
(@any_patient, @any_user,  @any_user2,  'Reschedule appointment',  'Open',   'High');

-- messages: inbox/outbox example
INSERT INTO messages (sender_user_id, recipient_user_id, body)
VALUES
(@any_user,  @any_user2, 'Hello! Please review the patient notes.'),
(@any_user2, @any_user,  'Got it—will do after clinic.');

-- clinician availability: one weekday slot (Mon 09:00–17:00)
-- (weekday: 0=Sun..6=Sat)
INSERT IGNORE INTO clinician_availability (clinician_id, weekday, start_time, end_time, location)
VALUES (@any_clinician, 1, '09:00:00', '17:00:00', 'Main Clinic');

-- audit_log: example action
INSERT INTO audit_log (user_id, action, entity, entity_id, details)
VALUES (@any_user, 'seed_insert', 'tickets', LAST_INSERT_ID(), 'created demo ticket');

-- optional: a future appointment to light up the "patient upcoming" view
INSERT INTO appointments (patient_id, clinician_id, scheduled_at, status)
VALUES (@any_patient, @any_clinician, NOW() + INTERVAL 1 DAY, 'Scheduled');
