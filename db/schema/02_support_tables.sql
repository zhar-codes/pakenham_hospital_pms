-- 02_support_tables.sql
-- Project: pakenham_hospital_pms
-- Engine/Charset: InnoDB / utf8mb4_unicode_ci
-- No DROPs. Safe for fresh setups.

USE pakenham_hospital_pms;

-- ========== SUPPORT TABLES ==========

CREATE TABLE IF NOT EXISTS audit_log (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id    INT UNSIGNED NULL,
  action     VARCHAR(64)  NOT NULL,
  entity     VARCHAR(64)  NOT NULL,
  entity_id  INT UNSIGNED NULL,
  details    TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_auditlog_user_created (user_id, created_at),
  KEY idx_auditlog_entity (entity, entity_id),
  CONSTRAINT fk_auditlog_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tickets (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  patient_id   INT UNSIGNED NOT NULL,
  opened_by    INT UNSIGNED NOT NULL,
  assigned_to  INT UNSIGNED NULL,
  subject      VARCHAR(150) NOT NULL,
  status       VARCHAR(32)  NOT NULL DEFAULT 'Open',
  priority     VARCHAR(16)  NOT NULL DEFAULT 'Normal',
  created_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   DATETIME NULL,
  PRIMARY KEY (id),
  KEY idx_tickets_status_priority (status, priority),
  KEY idx_tickets_assigned_status (assigned_to, status),
  KEY idx_tickets_patient_created (patient_id, created_at),
  CONSTRAINT fk_tickets_patient    FOREIGN KEY (patient_id)  REFERENCES patients(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT fk_tickets_opened_by  FOREIGN KEY (opened_by)   REFERENCES users(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT fk_tickets_assigned_to FOREIGN KEY (assigned_to) REFERENCES users(id)
    ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS messages (
  id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
  sender_user_id    INT UNSIGNED NOT NULL,
  recipient_user_id INT UNSIGNED NOT NULL,
  body              TEXT NOT NULL,
  sent_at           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  is_read           TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  KEY idx_messages_inbox  (recipient_user_id, is_read, sent_at),
  KEY idx_messages_outbox (sender_user_id,    sent_at),
  CONSTRAINT fk_messages_sender    FOREIGN KEY (sender_user_id)    REFERENCES users(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT fk_messages_recipient FOREIGN KEY (recipient_user_id) REFERENCES users(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS clinician_availability (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  clinician_id INT UNSIGNED NOT NULL,
  weekday      TINYINT UNSIGNED NOT NULL, -- 0=Sun..6=Sat
  start_time   TIME NOT NULL,
  end_time     TIME NOT NULL,
  location     VARCHAR(100) NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_clinician_week_slot (clinician_id, weekday, start_time, end_time),
  KEY idx_clinavail_clin_week (clinician_id, weekday),
  CONSTRAINT fk_clinavail_clinician FOREIGN KEY (clinician_id) REFERENCES clinicians(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========== INDEXES ON EXISTING TABLES ==========

-- users
ALTER TABLE users
  ADD UNIQUE KEY uq_users_username (username),
  ADD KEY idx_users_role (role),
  ADD KEY idx_users_status (status);

-- patients
ALTER TABLE patients
  ADD KEY idx_patients_user_id (user_id),
  ADD KEY idx_patients_last_name (last_name),
  ADD UNIQUE KEY uq_patients_user_id (user_id);

-- clinicians
ALTER TABLE clinicians
  ADD KEY idx_clinicians_user_id (user_id),
  ADD KEY idx_clinicians_last_name (last_name),
  ADD UNIQUE KEY uq_clinicians_user_id (user_id);

-- appointments
ALTER TABLE appointments
  ADD KEY idx_appt_clin_sched (clinician_id, scheduled_at),
  ADD KEY idx_appt_pat_sched  (patient_id,  scheduled_at),
  ADD KEY idx_appt_status     (status);

-- visits
ALTER TABLE visits
  ADD KEY idx_visits_patient_checkin   (patient_id,  checkin_time),
  ADD KEY idx_visits_clinician_checkin (clinician_id, checkin_time);
