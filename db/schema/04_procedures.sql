-- 04_procedures.sql
-- Project: pakenham_hospital_pms
-- Stored procedures (MariaDB-safe)
-- No DROPs; uses CREATE OR REPLACE.

USE pakenham_hospital_pms;
DELIMITER $$

-- 1) Book an appointment (validates + prevents exact-slot double book)
CREATE OR REPLACE PROCEDURE sp_book_appointment(
  IN p_patient_id    INT UNSIGNED,
  IN p_clinician_id  INT UNSIGNED,
  IN p_datetime      DATETIME,
  IN p_reason        VARCHAR(255),   -- accepted for future use
  IN p_location      VARCHAR(100)    -- accepted for future use
)
BEGIN
  DECLARE v_cnt INT DEFAULT 0;

  -- validate patient
  SELECT COUNT(*) INTO v_cnt FROM patients WHERE id = p_patient_id;
  IF v_cnt = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid patient_id';
  END IF;

  -- validate clinician
  SELECT COUNT(*) INTO v_cnt FROM clinicians WHERE id = p_clinician_id;
  IF v_cnt = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid clinician_id';
  END IF;

  -- check for exact slot clash for this clinician (ignore Cancelled)
  SELECT COUNT(*) INTO v_cnt
  FROM appointments
  WHERE clinician_id = p_clinician_id
    AND scheduled_at = p_datetime
    AND (status IS NULL OR status <> 'Cancelled');

  IF v_cnt > 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Time slot already booked';
  END IF;

  -- insert with safe columns (reason/location ignored if not present)
  INSERT INTO appointments (patient_id, clinician_id, scheduled_at, status)
  VALUES (p_patient_id, p_clinician_id, p_datetime, 'Scheduled');

  SELECT LAST_INSERT_ID() AS new_appointment_id;
END$$

-- 2) Check-in a patient (by appointment OR by patient+clinician)
CREATE OR REPLACE PROCEDURE sp_checkin_patient(
  IN p_appointment_id INT UNSIGNED,   -- pass NULL if not using an appointment
  IN p_patient_id     INT UNSIGNED,   -- required if appointment_id is NULL
  IN p_clinician_id   INT UNSIGNED,   -- required if appointment_id is NULL
  IN p_note           TEXT            -- accepted for future use
)
BEGIN
  DECLARE v_patient_id   INT UNSIGNED;
  DECLARE v_clinician_id INT UNSIGNED;
  DECLARE v_cnt          INT DEFAULT 0;

  IF p_appointment_id IS NOT NULL THEN
    SELECT a.patient_id, a.clinician_id
      INTO v_patient_id, v_clinician_id
    FROM appointments a
    WHERE a.id = p_appointment_id;

    IF v_patient_id IS NULL THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid appointment_id';
    END IF;
  ELSE
    SET v_patient_id   = p_patient_id;
    SET v_clinician_id = p_clinician_id;
  END IF;

  -- validate patient & clinician
  SELECT COUNT(*) INTO v_cnt FROM patients   WHERE id = v_patient_id;
  IF v_cnt = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid patient_id';
  END IF;

  SELECT COUNT(*) INTO v_cnt FROM clinicians WHERE id = v_clinician_id;
  IF v_cnt = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid clinician_id';
  END IF;

  -- insert visit (notes/appointment linkage can be added later if columns exist)
  INSERT INTO visits (patient_id, clinician_id, checkin_time)
  VALUES (v_patient_id, v_clinician_id, NOW());

  SELECT LAST_INSERT_ID() AS new_visit_id;
END$$

-- 3) Complete a visit (set checkout_time; keep/merge notes)
CREATE OR REPLACE PROCEDURE sp_complete_visit(
  IN p_visit_id INT UNSIGNED,
  IN p_note     TEXT
)
BEGIN
  DECLARE v_cnt INT DEFAULT 0;

  SELECT COUNT(*) INTO v_cnt FROM visits WHERE id = p_visit_id;
  IF v_cnt = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid visit_id';
  END IF;

  UPDATE visits
     SET checkout_time = NOW(),
         notes = COALESCE(p_note, notes)
   WHERE id = p_visit_id;

  SELECT id AS visit_id, checkin_time, checkout_time
    FROM visits
   WHERE id = p_visit_id;
END$$

DELIMITER ;
